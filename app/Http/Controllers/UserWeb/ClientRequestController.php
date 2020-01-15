<?php

namespace App\Http\Controllers\UserWeb;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use File;
use App\Support\Util;
use App\Models\User;
use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\AccountClient;
use App\Models\Account;
use App\Models\UserOtp;
use App\Models\UserOtherAccount;
use App\Util\HelperUtil;
use DB;

class ClientRequestController extends Controller
{
    public function save_request(Request $request)
    {
        $campos = $request->all();

        try
        {
            $data = [
                    "message" => null,
                    "error" => false,
                    "code" => 200,
                ];

            $folio = DB::table('client_requests')->max('id');

            if(!$folio){
                $filio_number = '00000001';
            }else{
                $filio_number = sprintf('%08d', ($folio + 1));
            }


            $user_id = auth()->user()->id;

            $client_id = Client::where('user_id', $user_id)->pluck('id')->first();

            $account_id = 0;

            if ($client_id)
            {
                $account_id = AccountClient::where('client_id', $client_id)->pluck('account_id')->first();
            }

            if(in_array($campos['request_type_id'], [8,9,42])){


                $chkClientRequest = ClientRequest::select('id','text')->where("request_type_id",$campos['request_type_id'])->whereDate('request_send_date', date('Y-m-d'))->get();

                $getTransactionLimits = Account::select('id','transfer_internal_account','transfer_third_party_account','transfer_international_account')->where('id',$account_id)->first();

                $amount = 0;

                if($campos['request_type_id'] == 8){

                    $json_decode_c = json_decode($campos['text'], true);
                    $amount = $amount + (isset($json_decode_c['amount']) ? $json_decode_c['amount']['value'] : 0);

                    foreach ($chkClientRequest as $key => $value) {
                        $json_decode = json_decode($value->text, true);
                        $amount = $amount + (isset($json_decode['amount']) ? $json_decode['amount']['value'] : 0);
                    }

                    //dd($amount);
                    if($amount > $getTransactionLimits->transfer_internal_account)
                    {
                        $data = [
                            "message" => __('frontsistema.entre_mis_cuentas.daily_limit_error_msg'),
                            "error" => true,
                            "code" => 500,
                        ];
                        return response()->json($data,200);
                    }

                }else if($campos['request_type_id'] == 42){

                    $json_decode_c = json_decode($campos['text'], true);
                    $amount = $amount + (isset($json_decode_c['amount']) ? $json_decode_c['amount']['value'] : 0);

                    foreach ($chkClientRequest as $key => $value) {
                        $json_decode = json_decode($value->text, true);
                        $amount = $amount + (isset($json_decode['amount']) ? $json_decode['amount']['value'] : 0);
                    }

                    if($amount > $getTransactionLimits->transfer_third_party_account)
                    {
                        $data = [
                            "message" => __('frontsistema.entre_el_mis_broker.daily_limit_error_msg'),
                            "error" => true,
                            "code" => 500,
                        ];
                        return response()->json($data,200);
                    }
                }
                else{

                    $json_decode_c = json_decode($campos['text'], true);
                    $amount = $amount + (isset($json_decode_c['ti_amount']) ? $json_decode_c['ti_amount']['value'] : 0);

                    foreach ($chkClientRequest as $key => $value) {
                        $json_decode = json_decode($value->text, true);
                        $amount = $amount + (isset($json_decode['ti_amount']) ? $json_decode['ti_amount']['value'] : 0);
                    }

                    if($amount > $getTransactionLimits->transfer_international_account)
                    {
                        $data = [
                            "message" => __('frontsistema.transferencias_internacionales.daily_limit_error_msg'),
                            "error" => true,
                            "code" => 500,
                        ];
                        return response()->json($data,200);
                    }
                }
                
            }
            
            DB::beginTransaction();
            $client_request = new ClientRequest;
            $client_request->file_number = $filio_number;
            $client_request->user_id = $user_id;
            $client_request->account_id = $account_id;
            $client_request->request_status_id = 1;
            $client_request->request_type_id = $campos['request_type_id'];
            if(isset($campos['category_id'])){
                $client_request->category_id = $campos['category_id'];
            }
            if(isset($campos['verify']) && ($campos['verify'] == 1 || $campos['verify'] == 2)){
                $client_request->status = 0;
            }else{
                $client_request->request_send_date = date('Y-m-d H:i:s');
            }
            
            if(in_array($campos['request_type_id'], [7,9,24])){
                $json_encoded_main = [];
                $json_decoded = json_decode($campos['text'], true);
                foreach ($campos['documents'] as $key => $value){
                    $fileName       = time() . rand() . $key . '.' . $value->getClientOriginalExtension();
                    $current_folder = 'upload/requests/' . date('Ymd');
                    $folder_path    = public_path($current_folder);
                    if (!File::exists($folder_path))
                    {
                        File::makeDirectory($folder_path, 0777, true);
                    }
                    $value->move($folder_path, $fileName);

                    $json_decoded['document' . ($key + 1)] =
                    [
                        'type'               => 'file',
                        'path'               => $current_folder . '/' . $fileName,
                        'extension'          => $value->getClientOriginalExtension(),
                        'original_file_name' => $value->getClientOriginalName()
                    ];                    
                }

                $json_encoded = json_encode($json_decoded);
                $json_encoded = str_replace('\/', '/', $json_encoded);    
                $campos['text'] = $json_encoded;
            }
            else if($campos['request_type_id'] == 27){
                
                $json_encoded_main = [];
                foreach ($campos['documents'] as $key => $value){
                    $fileName       = time() . rand() . $key . '.' . $value->getClientOriginalExtension();
                    $current_folder = 'upload/requests/' . date('Ymd');
                    $folder_path    = public_path($current_folder);
                    if (!File::exists($folder_path))
                    {
                        File::makeDirectory($folder_path, 0777, true);
                    }
                    $value->move($folder_path, $fileName);

                    $from                          = [
                        'document' => [
                            'type'               => 'file',
                            'path'               => $current_folder . '/' . $fileName,
                            'extension'          => $value->getClientOriginalExtension(),
                            'original_file_name' => $value->getClientOriginalName()
                        ]
                    ];
                    
                    array_push($json_encoded_main,$from);

                }
                $finishedText=[]; 
                $json_decoded = json_decode($campos['text']);
                $finishedText['document_type'] = isset($json_decoded->document_type)?$json_decoded->document_type:null;
                $finishedText['documents'] = $json_encoded_main;

                // dd(json_encode($finishedText));
                $json_encoded = json_encode($finishedText);

                $json_encoded = str_replace('\/', '/', $json_encoded);    
                $campos['text'] = $json_encoded;
                
            }
            
            $client_request->from = $campos['from'];
            $client_request->text = $campos['text'];
            $client_request->save();

            $data['filio_number'] = $filio_number;
            $data['client_request_id'] = $client_request->id;

            //verify mobile code
            if(isset($campos['verify']) && $campos['verify'] == 1){

                //send code in sms
                $client = Client::where('user_id', $user_id)->first();

                if ($client)
                {
                    $six_digit_random = HelperUtil::send_sms($client->telephone1);
                }

                UserOtp::where('user_id', $user_id)->where('type', 'client_request')->delete();
                $registered_device = UserOtp::create([
                        'user_id' => $user_id,
                        'code'    => $six_digit_random,
                        'status'  => 1,
                        'type'    => 'client_request',
                ]);
            }
            //verify mobile code
            
            DB::commit();

            if(isset($campos['verify']) && $campos['verify'] == 0)
            {
                HelperUtil::event_notification($client_request);
            }
            
            return response()->json($data,200);
        }
        catch (\Exception $e)
        {
            //dd($e->getMessage());
            $data = [
                "message" => __('frontsistema.went_wrong_msg'),
                "error" => true,
                "code" => 500,
            ];

            DB::rollback();
            return response()->json($data,200);
        }
    }

    public function dataclient_request()
    {

        $current_lang      = HelperUtil::get_currentlang();

        $client_requests = ClientRequest::select('client_requests.file_number','client_requests.request_type_id','client_requests.updated_at',DB::raw("request_status.status_".$current_lang." as status"),'request_status.color_code')
            ->leftJoin('request_status','request_status.id','=','client_requests.request_status_id')
            ->where('request_type_id','!=',2)
            ->where('client_requests.status',1)
            ->where('user_id',Auth()->user()->id);

        return DataTables::of($client_requests)
        
        ->editColumn('request_type_id', function($client_requests) use ($current_lang) {

            return config('site.client_request_type.'.$client_requests->request_type_id.'.'.$current_lang);
        })
        ->editColumn('color_code', function ($client_requests) {
            return "<div class='small_color_bx' style='background:".$client_requests->color_code."'></div>";
        })
        ->editColumn('updated_at', function ($client_requests) {
            return $client_requests->updated_at->format('d-m-Y');
        })
        ->rawColumns(['color_code'])
        ->make(true);
    }

    public function tramites_en_curso()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if(auth()->user()->isActive)
        {
            return view('tramites_en_curso')->with('elmenu',['elmenu'=>$lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function ajax_generate_code(Request $request)
    {
        $campos = $request->all();

        try
        {
            DB::beginTransaction();

            $user_id = auth()->user()->id;
            $data = [
                        "result"  => null,
                        "error"   => false,
                        "code"    => 200,
                        "message" => __('frontsistema.validate_mob.generate_code_success')
                    ];

            if(isset($campos['request_type_id']) && in_array($campos['request_type_id'], [8,9,42])){

                $chkClientRequest = ClientRequest::select('id','text')->where("request_type_id",$campos['request_type_id'])->whereDate('request_send_date', date('Y-m-d'))->get();

                $getCurrentClientRequset = ClientRequest::select('id','text','account_id')->where('id',$campos['client_request_id'])->first();
                
                $getTransactionLimits = Account::select('id','transfer_internal_account','transfer_third_party_account','transfer_international_account')->where('id',$getCurrentClientRequset->account_id)->first();

                $amount = 0;
                
                if($campos['request_type_id'] == 8){

                    $json_decode_c = json_decode($getCurrentClientRequset['text'], true);
                    $amount = $amount + (isset($json_decode_c['amount']) ? $json_decode_c['amount']['value'] : 0);

                    foreach ($chkClientRequest as $key => $value) {
                        $json_decode = json_decode($value->text, true);
                        $amount = $amount + (isset($json_decode['amount']) ? $json_decode['amount']['value'] : 0);
                    }

                    if($amount > $getTransactionLimits->transfer_internal_account)
                    {
                        $data = [
                            "message" => __('frontsistema.entre_mis_cuentas.daily_limit_error_msg'),
                            "error" => true,
                            "code" => 500,
                        ];
                        return response()->json($data,200);
                    }

                }else if($campos['request_type_id'] == 42){

                    $json_decode_c = json_decode($getCurrentClientRequset['text'], true);
                    $amount = $amount + (isset($json_decode_c['amount']) ? $json_decode_c['amount']['value'] : 0);

                    foreach ($chkClientRequest as $key => $value) {
                        $json_decode = json_decode($value->text, true);
                        $amount = $amount + (isset($json_decode['amount']) ? $json_decode['amount']['value'] : 0);
                    }

                    if($amount > $getTransactionLimits->transfer_third_party_account)
                    {
                        $data = [
                            "message" => __('frontsistema.entre_el_mis_broker.daily_limit_error_msg'),
                            "error" => true,
                            "code" => 500,
                        ];
                        return response()->json($data,200);
                    }
                }
                else{

                    $json_decode_c = json_decode($getCurrentClientRequset['text'], true);
                    $amount = $amount + (isset($json_decode_c['ti_amount']) ? $json_decode_c['ti_amount']['value'] : 0);

                    foreach ($chkClientRequest as $key => $value) {
                        $json_decode = json_decode($value->text, true);
                        $amount = $amount + (isset($json_decode['ti_amount']) ? $json_decode['ti_amount']['value'] : 0);
                    }

                    if($amount > $getTransactionLimits->transfer_international_account)
                    {
                        $data = [
                            "message" => __('frontsistema.transferencias_internacionales.daily_limit_error_msg'),
                            "error" => true,
                            "code" => 500,
                        ];
                        return response()->json($data,200);
                    }
                }
            }

            //send code in sms
            $client = Client::where('user_id', $user_id)->first();

            if ($client)
            {
                $six_digit_random = HelperUtil::send_sms($client->telephone1);
            }
            //$six_digit_random = mt_rand(100000, 999999);

            UserOtp::where('user_id', $user_id)->where('type', 'client_request')->delete();

            $registered_device = UserOtp::create([
                    'user_id' => $user_id,
                    'code'    => $six_digit_random,
                    'status'  => 1,
                    'type'    => 'client_request',
            ]);

            DB::commit();
            
            return response()->json($data, 200);
        }
        catch (\Exception $e)
        {
            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.went_wrong_msg')
            ];

            DB::rollback();
            return response()->json($data,200);
        }
    }

    public function ajax_verify_request(Request $request)
    {
        //Verify client request with mobile otp
        $campos   = $request->all();

        try
        {
            DB::beginTransaction();

            $user_id = auth()->user()->id;

            $user_otp = UserOtp::where('user_id', $user_id)
                        ->where('code', $campos['code'])
                        ->where('type', 'client_request')->first();

            if ($user_otp)
            {
                $data = [
                    "result"  => null,
                    "error"   => false,
                    "code"    => 200,
                    "message" => __('frontsistema.validate_mob.verify_code_success')
                ];

                UserOtp::where('user_id', $user_id)
                        ->where('type', 'client_request')->delete();
                //Update Client request status
                $client_request = ClientRequest::find($campos['client_request_id']);
                if($client_request){
                    $client_request->status = 1;
                    $client_request->request_send_date = date('Y-m-d H:i:s');
                    $client_request->save();
                    HelperUtil::event_notification($client_request);
                }
            }
            else
            {
                $data = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => __('frontsistema.validate_mob.verify_code_error')
                ];
            }
            DB::commit();
            return response()->json($data, 200);
        }
        catch (\Exception $e)
        {
            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.went_wrong_msg') . ' - ' . $e->getMessage()
            ];

            DB::rollback();
            return response()->json($data,200);
        }
    }

    public function delete_client_request(Request $request)
    {
        //Verify client request with mobile otp
        $campos   = $request->all();
        try
        {
            DB::beginTransaction();
            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 200,
                "message" => ''
            ];
            $client_request_deleted = ClientRequest::find($campos['client_request_id'])->delete();
            if ($client_request_deleted) {
                $data['error'] = false;
            }
            else {
                $data["code"] = 500;
                $data["message"] = __('frontsistema.went_wrong_msg');
            }
            DB::commit();
            return response()->json($data, 200);
        }
        catch (\Exception $e)
        {
            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.went_wrong_msg')
            ];
            DB::rollback();
            return response()->json($data,200);
        }
    }

    public function databaja_de_cuentas()
    {
        $current_lang      = HelperUtil::get_currentlang();

        $user_id = auth()->user()->id;
        $client_id = Client::where('user_id', $user_id)->pluck('id')->first();
        $account_id = AccountClient::where('client_id', $client_id)->pluck('account_id')->first();

        $user_other_accounts = UserOtherAccount::select('user_other_accounts.id','user_other_accounts.first_name','user_other_accounts.destination_type','user_other_accounts.currency','user_other_accounts.dest_account_number','user_other_accounts.dest_bank_name','user_other_accounts.created_at',DB::raw("instruments.instrument_".$current_lang." as instrument"))
            ->leftJoin('instruments','instruments.id','=','user_other_accounts.instrument_id')
            ->where('account_id', $account_id);

        return DataTables::of($user_other_accounts)
        ->addColumn('action', function ($user_other_accounts) {

            $json_encoded = json_encode($user_other_accounts,true);
            $data = base64_encode($json_encoded);

            $botones = '<a class=" font-700 eliminar-btn font-14" onclick="confirmaDel('.$user_other_accounts->id.',\''.$data.'\');"><i class="fa fa-trash-o"></i> <span style="text-decoration: underline;">'.__('frontsistema.baja_de_cuentas.delete').'</span></a>';
            return $botones;
        })
        ->editColumn('destination_type', function($user_other_accounts) use ($current_lang) {
            return config('site.destinations.'.$user_other_accounts->destination_type.'.'.$current_lang);
        })
        ->editColumn('currency', function($user_other_accounts) use ($current_lang) {

            return config('site.currencies.'.$user_other_accounts->currency.'.'.$current_lang);
        })
        ->editColumn('created_at', function ($user_other_accounts) {
            return $user_other_accounts->created_at->format('d-m-Y');
        })
        ->make(true);
        
    }

    public function baja_de_cuentas()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if(auth()->user()->isActive)
        {
            $user_id = auth()->user()->id;
            $client = Client::where('user_id', $user_id)->first();

            return view('baja_de_cuentas')
                ->with('elmenu',['elmenu'=>$lstMenus])
                ->with('client',$client);
        }
        else
        {
            return redirect('error');
        }
    }
    // Function to activate the client request
    public function activate_client_request(Request $request)
    {
        $campos   = $request->all();

        try
        {

            DB::beginTransaction();

            $user_id = auth()->user()->id;

            $user_client_id = ClientRequest::where('user_id', $user_id)
                        ->where('id', $campos['client_request_id'])->first();

            if ($user_client_id)
            {

                $data = [
                    "result"  => null,
                    "error"   => false,
                    "code"    => 200,
                    "message" => ''
                ];

                //Update Client request status
                $client_request = ClientRequest::find($campos['client_request_id']);
                if($client_request){
                    $client_request->status = 1;
                    $client_request->save();
                }
            }
            else
            {
                $data = [
                    "result"  => null,
                    "error"   => true,
                    "code"    => 500,
                    "message" => ''
                ];
            }
            DB::commit();
            return response()->json($data, 200);
        }
        catch (\Exception $e)
        {
            $data   = [
                "result"  => null,
                "error"   => true,
                "code"    => 500,
                "message" => __('frontsistema.went_wrong_msg')
            ];

            DB::rollback();
            return response()->json($data,200);
        }
    }
}

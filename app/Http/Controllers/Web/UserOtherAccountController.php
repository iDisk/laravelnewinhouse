<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserOtherAccount;
use App\Models\Instrument;
use App\Models\Country;
use App\Models\Account;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use App\Util\HelperUtil;
use Validator;
use DB;

class UserOtherAccountController extends Controller
{


    //Funcion para DataTable
    public function datauser_other_accounts()
    {
        $user_other_accounts = UserOtherAccount::select('user_other_accounts.*','accounts.account_number as user_account_number', DB::raw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) as client_name'))
                ->leftJoin('accounts', 'accounts.id', '=', 'user_other_accounts.account_id')
                ->leftJoin('account_clients', 'account_clients.account_id', '=', 'user_other_accounts.account_id')
                ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                ->groupBy('user_other_accounts.id');

        return DataTables::of($user_other_accounts)
        ->addColumn('action', function ($user_other_accounts) {
            $botones = '<a href="'.url('user_other_accounts/'.$user_other_accounts->id.'/edit').'" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> '.__('sistema.btn_edit').'</a> ';

            $botones .= '<form action="'.url('user_other_accounts/' . $user_other_accounts->id).'" id="borra_Frm'.$user_other_accounts->id.'" method="POST" class="pull-left">'.csrf_field()  .' '.method_field('DELETE') .'<button type="button" onclick="confirmaDel('.$user_other_accounts->id.',\''.$user_other_accounts->id.'\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';
            return $botones;
        })
        ->editColumn('type_of_recipient', function ($user_other_accounts) {
            if($user_other_accounts->type_of_recipient == 'personal')
            {
                return __('sistema.alta_de_cuentas.personal');
            }
            else if($user_other_accounts->type_of_recipient == 'company')
            {
                return __('sistema.alta_de_cuentas.empresa');
            }
        })
        ->editColumn('destination_type', function ($user_other_accounts) {
            if($user_other_accounts->destination_type == 'same')
            {
                return __('sistema.alta_de_cuentas.same_entity');
            }
            else if($user_other_accounts->destination_type == 'international')
            {
                return __('sistema.alta_de_cuentas.international');
            }
        })
        ->editColumn('created_at', function ($user_other_accounts) {
            return $user_other_accounts->created_at->format('d/m/Y H:i');
        })
        ->filterColumn('client_name', function($query, $keyword)
        {
            return $query->whereRaw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) like "' . '%' . $keyword . '%"');
        })
        ->filterColumn('user_account_number', function($query, $keyword)
        {
            $query->where('accounts.account_number', 'like', '%' . $keyword . '%');
        })
        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.user_other_account.index')->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $current_lang = HelperUtil::get_currentlang();

        $instruments = Instrument::select('id',DB::raw("instrument_" . $current_lang . " as instrument"))
        ->where('active',1)->pluck('instrument', 'id')->toArray();
        $accounts = Account::select('id', 'account_number')->orderBy('account_number')->get();
        $countries = Country::select('id','name')->get();

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.user_other_account.new')
                ->with('instruments',$instruments)
                ->with('accounts',$accounts)
                ->with('countries',$countries)
                ->with('elmenu',['elmenu'=>$lstMenus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $campos = $request->all();

        //dd($campos);

        $rules = array(
            'type_of_recipient' => 'required',
            'destination_type' => 'required',
        );
        $messages = array(
            'type_of_recipient.required' =>  __('sistema.alta_de_cuentas.type_of_recipient_err'),
            'destination_type.required' =>  __('sistema.alta_de_cuentas.destination_error'),
        );


        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){

            return redirect('user_other_accounts/create')->withInput()->withErrors($validator);
        }
        else{
            // Save userOtherAccount
            $userOtherAccount = new UserOtherAccount;

            if($campos['destination_type'] == 'same'){

                $userOtherAccount->account_id = $campos['account_number'];
                $userOtherAccount->type_of_recipient = $campos['type_of_recipient'];
                $userOtherAccount->destination_type = $campos['destination_type'];
                $userOtherAccount->instrument_id = $campos['instrument_id'];
                $userOtherAccount->first_name = $campos['first_name'];
                $userOtherAccount->dest_account_number = $campos['dest_account_number'];
                $userOtherAccount->currency = $campos['currency'];
                $userOtherAccount->intermediary_banking = 0;

            }
            else if($campos['destination_type'] == 'international'){

                $userOtherAccount->account_id = $campos['account_number'];
                $userOtherAccount->type_of_recipient = $campos['type_of_recipient'];
                $userOtherAccount->destination_type = $campos['destination_type'];
                $userOtherAccount->instrument_id = $campos['instrument_id'];
                $userOtherAccount->first_name = $campos['first_name'];
                $userOtherAccount->telephone = $campos['telephone'];
                $userOtherAccount->address = $campos['address'];
                $userOtherAccount->country = $campos['country'];
                $userOtherAccount->state = $campos['state'];
                $userOtherAccount->city = $campos['city'];
                $userOtherAccount->dest_bank_country = $campos['dest_bank_country'];
                $userOtherAccount->dest_account_number = $campos['dest_account_number'];
                $userOtherAccount->dest_swift = $campos['dest_swift'];
                $userOtherAccount->dest_bank_name = $campos['dest_bank_name'];
                $userOtherAccount->dest_bank_address = $campos['dest_bank_address'];
                $userOtherAccount->intermediary_banking = 0;

                if(isset($campos['intermediary_banking']) && $campos['intermediary_banking'] == 1)
                {
                    $userOtherAccount->intermediary_banking = 1;
                    $userOtherAccount->intermediary_bank_country = $campos['intermediary_bank_country'];
                    $userOtherAccount->intermediary_bank_account = $campos['intermediary_bank_account'];
                    $userOtherAccount->intermediary_swift = $campos['intermediary_swift'];
                    $userOtherAccount->intermediary_bank_name = $campos['intermediary_bank_name'];
                    $userOtherAccount->intermediary_bank_address = $campos['intermediary_bank_address'];
                }
            }

            $userOtherAccount->save();

            return redirect('user_other_accounts')->with('msg',__('sistema.save_success_msg'))->with('type','success');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        $current_lang = HelperUtil::get_currentlang();

        $userOtherAccount = UserOtherAccount::find($id);
        $instruments = Instrument::select('id',DB::raw("instrument_" . $current_lang . " as instrument"))
        ->where('active',1)->pluck('instrument', 'id')->toArray();
        $accounts = Account::select('id', 'account_number')->orderBy('account_number')->get();
        $countries = Country::select('id','name')->get();

        return view('catalogos.user_other_account.edit')
            ->with('elmenu',['elmenu'=>$lstMenus])
            ->with('instruments',$instruments)
            ->with('accounts',$accounts)
            ->with('countries',$countries)
            ->with('userOtherAccount',$userOtherAccount);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $campos = $request->all();

        $rules = array(
            'type_of_recipient' => 'required',
            'destination_type' => 'required',
        );
        $messages = array(
            'type_of_recipient.required' =>  __('sistema.alta_de_cuentas.type_of_recipient_err'),
            'destination_type.required' =>  __('sistema.alta_de_cuentas.destination_error'),
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){

            return redirect('user_other_accounts/'.$id.'/edit')->withInput()->withErrors($validator);
        }
        else
        {
            // Save userOtherAccount
            $userOtherAccount = UserOtherAccount::find($id);

            if($campos['destination_type'] == 'same'){

                $userOtherAccount->account_id = $campos['account_number'];
                $userOtherAccount->type_of_recipient = $campos['type_of_recipient'];
                $userOtherAccount->destination_type = $campos['destination_type'];
                $userOtherAccount->instrument_id = $campos['instrument_id'];
                $userOtherAccount->first_name = $campos['first_name'];
                $userOtherAccount->dest_account_number = $campos['dest_account_number'];
                $userOtherAccount->currency = $campos['currency'];

                $userOtherAccount->telephone = '';
                $userOtherAccount->address = '';
                $userOtherAccount->country = '';
                $userOtherAccount->state = '';
                $userOtherAccount->city = '';
                $userOtherAccount->dest_bank_country = '';
                $userOtherAccount->dest_swift = '';
                $userOtherAccount->dest_bank_name = '';
                $userOtherAccount->dest_bank_address = '';
                $userOtherAccount->intermediary_banking = 0;
                $userOtherAccount->intermediary_bank_country = '';
                $userOtherAccount->intermediary_bank_account = '';
                $userOtherAccount->intermediary_swift = '';
                $userOtherAccount->intermediary_bank_name = '';
                $userOtherAccount->intermediary_bank_address = '';
            }
            else if($campos['destination_type'] == 'international'){

                $userOtherAccount->account_id = $campos['account_number'];
                $userOtherAccount->type_of_recipient = $campos['type_of_recipient'];
                $userOtherAccount->destination_type = $campos['destination_type'];
                $userOtherAccount->instrument_id = $campos['instrument_id'];
                $userOtherAccount->first_name = $campos['first_name'];
                $userOtherAccount->telephone = $campos['telephone'];
                $userOtherAccount->address = $campos['address'];
                $userOtherAccount->country = $campos['country'];
                $userOtherAccount->state = $campos['state'];
                $userOtherAccount->city = $campos['city'];
                $userOtherAccount->dest_bank_country = $campos['dest_bank_country'];
                $userOtherAccount->dest_account_number = $campos['dest_account_number'];
                $userOtherAccount->dest_swift = $campos['dest_swift'];
                $userOtherAccount->dest_bank_name = $campos['dest_bank_name'];
                $userOtherAccount->dest_bank_address = $campos['dest_bank_address'];
                
                if(isset($campos['intermediary_banking']) && $campos['intermediary_banking'] == 1)
                {
                    $userOtherAccount->intermediary_banking = 1;
                    $userOtherAccount->intermediary_bank_country = $campos['intermediary_bank_country'];
                    $userOtherAccount->intermediary_bank_account = $campos['intermediary_bank_account'];
                    $userOtherAccount->intermediary_swift = $campos['intermediary_swift'];
                    $userOtherAccount->intermediary_bank_name = $campos['intermediary_bank_name'];
                    $userOtherAccount->intermediary_bank_address = $campos['intermediary_bank_address'];

                }else
                {
                    $userOtherAccount->intermediary_banking = 0;
                    $userOtherAccount->intermediary_bank_country = '';
                    $userOtherAccount->intermediary_bank_account = '';
                    $userOtherAccount->intermediary_swift = '';
                    $userOtherAccount->intermediary_bank_name = '';
                    $userOtherAccount->intermediary_bank_address = '';
                }
            }

            $userOtherAccount->save();

            return redirect('user_other_accounts')->with('msg',__('sistema.update_success_msg'))->with('type','success');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserOtherAccount::find($id)->delete();
        return redirect('user_other_accounts')->with('msg',__('sistema.remove_success_msg'))->with('type','success');
    }

    public function ajax_get_user_other_account($id)
    {
        try{

            $current_lang      = HelperUtil::get_currentlang();

            $user_other_account = UserOtherAccount::select('user_other_accounts.*',DB::raw("instruments.instrument_".$current_lang." as instrument"),'c.name as al_country','dbc.name as al_dest_bank_country','ibc.name as al_intermediary_bank_country')
                                ->leftJoin('instruments','instruments.id','=','user_other_accounts.instrument_id')
                                ->leftJoin('countries as c','c.id','=','user_other_accounts.country')
                                ->leftJoin('countries as dbc','dbc.id','=','user_other_accounts.dest_bank_country')
                                ->leftJoin('countries as ibc','ibc.id','=','user_other_accounts.intermediary_bank_country')
                                ->where('user_other_accounts.id',$id)
                                ->first();

            //dd($user_other_account);

            if($user_other_account){

                $data = [
                    "data" => $user_other_account,
                    "message" => null,
                    "error" => false,
                    "code" => 200,
                ];
                return response()->json($data,200);
            }

            $data = [
                "message" => null,
                "error" => true,
                "code" => 500,
            ];
            return response()->json($data,200);
        }
        catch (\Exception $e)
        {
            $data = [
                "message" => __('frontsistema.went_wrong_msg'),
                "error" => true,
                "code" => 500,
            ];
            return response()->json($data,200);
        }
    }
}

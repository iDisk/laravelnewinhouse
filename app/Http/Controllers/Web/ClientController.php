<?php

namespace App\Http\Controllers\Web;

use DB;
use Mail;
use Storage;
use Carbon\Carbon;
use App\Support\Util;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Broker;
use App\Models\Client;
use App\Models\Account;
use App\Models\Country;
use App\Models\ClientFile;
use App\Util\HelperUtil;
use App\Models\Instrument;
use Illuminate\Http\Request;
use App\Mail\NotificationMail;
use App\Models\AccountClient;
use App\Models\BusinessDetail;
use App\Models\AccountReference;
use App\Models\AccountInstrument;
use App\Models\AccountBeneficiary;
use App\Models\NationalIdentityDoc;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    /*
     * Constructor de la clase que instancia el middleware auth
     */

    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function dataclients()
    {
        $accounts = Account::select('accounts.*', DB::raw('(CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2)) as client_name'))
                ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                ->groupBy('accounts.account_number');

        return DataTables::of($accounts)
                        ->addColumn('action', function ($accounts)
                        {
                            $encoded_id = HelperUtil::encode($accounts->id);

                            $botones = '<a href="' . url('clients/' . $accounts->id . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';
//                $botones .= '<a href="'.url('account_transactions/'.$encoded_id).'" class="btn btn-xs btn-info waves-effect waves-light" title="'.__('sistema.transaction.transactions').'"><i class="fa fa-usd"></i></a> ';
                            return $botones;
                        })
                        ->filterColumn('client_name', function($query, $keyword)
                        {
                            return $query->whereRaw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) like "' . '%' . $keyword . '%"');
                        })
                        ->editColumn('created_at', function ($accounts)
                        {
                            return $accounts->created_at->format('d/m/Y H:i');
                        })
                        ->editColumn('date_of_transfer', function ($accounts)
                        {
                            return Carbon::parse($accounts->date_of_transfer)->format('d/m/Y');
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
        return view('catalogos.clients.index')
                        ->with('elmenu', ['elmenu' => $lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lstMenus     = Util::generateMenu(auth()->user()->perfil_id);
        $countries    = Country::orderBy('name')->get();
        $brokers      = Broker::orderBy('broker')->pluck('broker', 'id')->toArray();
        $current_lang = HelperUtil::get_currentlang();

        $ventas             = User::where('perfil_id', 3)->where('status', 1)->orderBy('name')->get();
        $gerente            = User::where('perfil_id', 4)->where('status', 1)->orderBy('name')->get();
        $analista           = User::where('perfil_id', 5)->where('status', 1)->orderBy('name')->get();
        $atencion_a_cliente = User::where('perfil_id', 6)->where('status', 1)->orderBy('name')->get();

        $national_identity_docs = NationalIdentityDoc::orderBy('national_identity_' . $current_lang)->pluck('national_identity_' . $current_lang, 'id')->toArray();
        //$financial_services     = FinancialService::orderBy('service_' . $current_lang)->pluck('service_' . $current_lang, 'id')->toArray();
        $account_instruments = Instrument::where('active', 1)->orderBy('instrument_' . $current_lang)->pluck('instrument_' . $current_lang, 'id')->toArray();

        return view('catalogos.clients.new')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('brokers', $brokers)
                        ->with('national_identity_docs', $national_identity_docs)
                        ->with('account_instruments', $account_instruments)
                        ->with('ventas', $ventas)
                        ->with('gerente', $gerente)
                        ->with('analista', $analista)
                        ->with('atencion_a_cliente', $atencion_a_cliente)
                        ->with('countries', $countries);
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

        //dd($campos,$request);
        $brokers         = Broker::find($campos['account']['broker_id']);
        $random_password = mt_rand(100000, 999999);

        DB::beginTransaction();
        try
        {
            //Save account detail
            $account                   = new Account;
            $account->fill($campos['account']);
            $account->account_number   = $brokers->code;
            $account->date_of_transfer = Carbon::createFromFormat('d/m/Y', $campos['account']['date_of_transfer'])->format('Y-m-d');
            $account->opt_notification = isset($campos['account']['opt_notification']) ? $campos['account']['opt_notification'] : 0;
            $account->save();
            $account_id                = $account->id;
            $account->account_number   = $brokers->code . '' . str_pad($account_id, 5, '0', STR_PAD_LEFT);
            $account->save();

            //Save Account instruments
            if ($campos['account_instruments'])
            {
                foreach ($campos['account_instruments'] as $key => $value)
                {
                    $account_instrument                = new AccountInstrument;
                    $account_instrument->account_id    = $account_id;
                    $account_instrument->instrument_id = $value;
                    $account_instrument->save();
                }
            }

            //Save refrences
            if ($campos['account']['credit_line_facility'] && $campos['account']['credit_line_facility'] == 'Yes')
            {
                if (isset($campos['reference1_name']) && $campos['reference1_name'] != '' && isset($campos['reference1_relationship']) && $campos['reference1_relationship'] != '' && isset($campos['reference1_telephone']) && $campos['reference1_telephone'] != '')
                {
                    $account_references               = new AccountReference;
                    $account_references->account_id   = $account_id;
                    $account_references->name         = $campos['reference1_name'];
                    $account_references->relationship = $campos['reference1_relationship'];
                    $account_references->telephone    = $campos['reference1_telephone'];
                    $account_references->save();
                }

                if (isset($campos['reference2_name']) && $campos['reference2_name'] != '')
                {
                    $account_references               = new AccountReference;
                    $account_references->account_id   = $account_id;
                    $account_references->name         = $campos['reference2_name'];
                    $account_references->relationship = $campos['reference2_relationship'];
                    $account_references->telephone    = $campos['reference2_telephone'];
                    $account_references->save();
                }

                if (isset($campos['reference3_name']) && $campos['reference3_name'] != '')
                {
                    $account_references               = new AccountReference;
                    $account_references->account_id   = $account_id;
                    $account_references->name         = $campos['reference3_name'];
                    $account_references->relationship = $campos['reference3_relationship'];
                    $account_references->telephone    = $campos['reference3_telephone'];
                    $account_references->save();
                }
            }

            //Save Beneficiory
            if (isset($campos['beneficiary_name']))
            {
                foreach ($campos['beneficiary_name'] as $key => $value)
                {
                    $account_beneficiaries             = new AccountBeneficiary;
                    $account_beneficiaries->account_id = $account_id;
                    $account_beneficiaries->name       = $value;
                    $account_beneficiaries->percentage = ($campos['beneficiary_percentage'][$key]) ? $campos['beneficiary_percentage'][$key] : 0;
                    $account_beneficiaries->save();
                }
            }

            //Save Entity detail for Business account
            if ($campos['account']['account_type'] == 'business')
            {
                $business_detail                         = new BusinessDetail;
                $campos['business_detail']['account_id'] = $account_id;
                $business_detail->fill($campos['business_detail']);
                $business_detail->incorporation_date     = Carbon::createFromFormat('d/m/Y', $campos['business_detail']['incorporation_date'])->format('Y-m-d');
                $business_detail->branch_id              = isset($campos['business_detail']['branch_id']) ? $campos['business_detail']['branch_id'] : '';
                $business_detail->save();
            }

            //Save user for login
            $user             = new User;
            $user->name       = $campos['client']['first_name'][0];
            $user->user_login = $account->account_number;
            $user->password   = bcrypt($random_password);
            $user->perfil_id  = 2;
            $user->status     = 0;
            $user->save();

            //Save account holder information
            $i = 1;
            foreach ($campos['client']['first_name'] as $key => $value)
            {

                $client                           = new Client;
                $client->first_name               = $campos['client']['first_name'][$key];
                $client->middle_name              = $campos['client']['middle_name'][$key];
                $client->surname1                 = $campos['client']['surname1'][$key];
                $client->surname2                 = $campos['client']['surname2'][$key];
                $client->national_identity_doc_id = $campos['client']['national_identity_doc_id'][$key];
                $client->national_identity_number = $campos['client']['national_identity_number'][$key];
                $client->dob                      = Carbon::createFromFormat('d/m/Y', $campos['client']['dob'][$key])->format('Y-m-d');
                $client->gender                   = $campos['client']['gender'][$key];
                $client->birth_place              = $campos['client']['birth_place'][$key];
                $client->birth_country            = $campos['client']['birth_country'][$key];
                $client->nationality              = $campos['client']['nationality'][$key];

                $client->telephone1 = $campos['client']['telephone1'][$key];
                $client->telephone2 = $campos['client']['telephone2'][$key];
                $client->email1     = $campos['client']['email1'][$key];
                $client->email2     = $campos['client']['email2'][$key];

                $client->branch_id = isset($campos['client']['branch_id'][$key]) ? $campos['client']['branch_id'][$key] : '';

                if ($campos['account']['account_type'] != 'business')
                {
                    $client->address         = $campos['client']['address'][$key];
                    $client->country         = $campos['client']['country'][$key];
                    $client->state           = $campos['client']['state'][$key];
                    $client->city            = $campos['client']['city'][$key];
                    $client->zip_code        = $campos['client']['zip_code'][$key];
                    $client->county          = $campos['client']['county'][$key];
                    $client->company         = $campos['client']['company'][$key];
                    $client->industry_type   = $campos['client']['industry_type'][$key];
                    $client->occupation      = $campos['client']['occupation'][$key];
                    $client->marrital_status = $campos['client']['marrital_status'][$key];
                    $client->spouse_name     = $campos['client']['spouse_name'][$key];
                    $client->telephone3      = $campos['client']['telephone3'][$key];
                }

                $client->client_type = $i;


                if ($i == 1)
                {
                    $client->user_id = $user->id;
                }
                else
                {
                    $client->user_id = 0;
                }

                $client->save();

                //Upload National Identity
                if ($request->hasFile('national_identity_file'))
                {
                    $client_file = new ClientFile;
                    $rutaS3      = '/users/photos';
                    Storage::disk()->makeDirectory($rutaS3);

                    $checksum = md5($client->id);
                    $filename = 'national_identity' . time() . '_' . $checksum . '.jpg';
                    //$procesa = Image::make($request->national_identity_file[$key])->encode('jpg', 95);
                    //$procesa->save(public_path().$rutaS3.'/'.$filename);

                    $client_file->client_id = $client->id;
                    $client_file->file      = $filename;
                    $client_file->name      = 'national_identity_file';
                    $client_file->save();
                }


                $account_client             = new AccountClient;
                $account_client->account_id = $account_id;
                $account_client->client_id  = $client->id;
                $account_client->save();

                $i++;
            }

            //Send Email to first client
            $subject         = __('sistema.register_mail.welcome_msg');
            $msg             = [];
            $msg['url']      = url('/client_registration/' . HelperUtil::encode($user->id));
            $msg['user']     = $account->account_number;
            $msg['password'] = $random_password;

            $email_to = $campos['client']['email1'][0];

            if ($campos['account']['account_type'] == 'business')
            {
                //$email_to = $campos['business_detail']['email1'];
            }

            //Open Account Notifications
            $parameters_json = [
                'NOMBRE_DEL_BROKER' => $brokers->broker,
                'LOGIN_URL'         => url('/client_registration/' . HelperUtil::encode($user->id)),
                'NOMBRE_DE_USUARIO' => $user->name,
                'USER_PASSWORD'     => $random_password,
                'NUMERO_DE_CUENTA'  => $account->account_number
            ];

            \App\Models\Notification::create([
                'user_id'       => $user->id,
                'short_message' => 'open_account',
                'parameters'    => json_encode($parameters_json),
                'template_name' => 'open_account',
                'is_read'       => 0,
            ]);

            DB::commit();
            
            $current_lang = HelperUtil::get_currentlang();
            //Mail::to($email_to)->send(new NotificationMail('emails.notifications.' . $current_lang . '.open_account', $subject, $parameters_json));
            Mail::to($email_to)->send(new NotificationMail('notifications.' . $current_lang . '.open_account', $subject, $parameters_json));           
            return redirect('clients')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
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

        $countries    = Country::orderBy('name')->get();
        $brokers      = Broker::orderBy('broker')->pluck('broker', 'id')->toArray();
        $current_lang = HelperUtil::get_currentlang();

        $national_identity_docs = NationalIdentityDoc::orderBy('national_identity_' . $current_lang)->pluck('national_identity_' . $current_lang, 'id')->toArray();
        //$financial_services     = FinancialService::orderBy('service_' . $current_lang)->pluck('service_' . $current_lang, 'id')->toArray();
        $financial_services = Instrument::where('active', 1)->orderBy('instrument_' . $current_lang)->pluck('instrument_' . $current_lang, 'id')->toArray();
        
        $ventas             = User::where('perfil_id', 3)->where('status', 1)->orderBy('name')->get();
        $gerente            = User::where('perfil_id', 4)->where('status', 1)->orderBy('name')->get();
        $analista           = User::where('perfil_id', 5)->where('status', 1)->orderBy('name')->get();
        $atencion_a_cliente = User::where('perfil_id', 6)->where('status', 1)->orderBy('name')->get();

        //Account data
        $account                    = Account::with('clients')->where('id', $id)->first();
        $account_instruments        = AccountInstrument::where('account_id', $id)->pluck('instrument_id')->toArray();
        $account_beneficiaries      = AccountBeneficiary::where('account_id', $id)->orderBy('name')->get();
        $account_references         = AccountReference::where('account_id', $id)->orderBy('name')->get();

        $business_detail = BusinessDetail::where('account_id', $id)->orderBy('registered_name')->first();

        $branches = \App\Models\Branch::orderBy('branch_' . $current_lang)->pluck('branch_' . $current_lang, 'id')->toArray();

        //Client dtata


        $client = Client::find($id);

        return view('catalogos.clients.edit')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('brokers', $brokers)
                        ->with('national_identity_docs', $national_identity_docs)
                        ->with('financial_services', $financial_services)
                        ->with('account_references', $account_references)
                        ->with('countries', $countries)
                        ->with('ventas', $ventas)
                        ->with('gerente', $gerente)
                        ->with('analista', $analista)
                        ->with('atencion_a_cliente', $atencion_a_cliente)
                        ->with('client', $client)
                        ->with('account', $account)
                        ->with('account_beneficiaries', $account_beneficiaries)
                        ->with('business_detail', $business_detail)
                        ->with('account_instruments', $account_instruments)
                        ->with('branches', $branches);
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

        DB::beginTransaction();
        try
        {
            $brokers = Broker::find($campos['account']['broker_id']);

            //Update Account information
            $account                   = Account::find($id);
            $account->fill($campos['account']);
            $account->account_number   = $brokers->code . '' . str_pad($id, 5, '0', STR_PAD_LEFT);
            $account->date_of_transfer = Carbon::createFromFormat('d/m/Y', $campos['account']['date_of_transfer'])->format('Y-m-d');
            if (isset($campos['account']['opt_notification']))
            {
                $account->opt_notification = $campos['account']['opt_notification'];
            }
            $account->save();

            $account_id = $id;

            //Save account instruments
            if ($campos['account_instruments'])
            {
                AccountInstrument::where('account_id', $account_id)->delete();
                foreach ($campos['account_instruments'] as $key => $value)
                {
                    $account_instruments                = new AccountInstrument;
                    $account_instruments->account_id    = $account_id;
                    $account_instruments->instrument_id = $value;
                    $account_instruments->save();
                }
            }

            //Save refrences
            if ($campos['account']['credit_line_facility'] == 'No')
            {
                AccountReference::where('account_id', $account_id)->delete();
            }
            if ($campos['account']['credit_line_facility'] && $campos['account']['credit_line_facility'] == 'Yes')
            {

                AccountReference::where('account_id', $account_id)->delete();

                if (isset($campos['reference1_name']) && $campos['reference1_name'] != '' && isset($campos['reference1_relationship']) && $campos['reference1_relationship'] != '' && isset($campos['reference1_telephone']) && $campos['reference1_telephone'] != '')
                {
                    $account_references               = new AccountReference;
                    $account_references->account_id   = $account_id;
                    $account_references->name         = $campos['reference1_name'];
                    $account_references->relationship = $campos['reference1_relationship'];
                    $account_references->telephone    = $campos['reference1_telephone'];
                    $account_references->save();
                }

                if (isset($campos['reference2_name']) && $campos['reference2_name'] != '')
                {
                    $account_references               = new AccountReference;
                    $account_references->account_id   = $account_id;
                    $account_references->name         = $campos['reference2_name'];
                    $account_references->relationship = $campos['reference2_relationship'];
                    $account_references->telephone    = $campos['reference2_telephone'];
                    $account_references->save();
                }

                if (isset($campos['reference3_name']) && $campos['reference3_name'] != '')
                {
                    $account_references               = new AccountReference;
                    $account_references->account_id   = $account_id;
                    $account_references->name         = $campos['reference3_name'];
                    $account_references->relationship = $campos['reference3_relationship'];
                    $account_references->telephone    = $campos['reference3_telephone'];
                    $account_references->save();
                }
            }

            //Save Beneficiory
            if (isset($campos['beneficiary_name']))
            {

                AccountBeneficiary::where('account_id', $account_id)->delete();

                foreach ($campos['beneficiary_name'] as $key => $value)
                {
                    $account_beneficiaries             = new AccountBeneficiary;
                    $account_beneficiaries->account_id = $account_id;
                    $account_beneficiaries->name       = $value;
                    $account_beneficiaries->percentage = ($campos['beneficiary_percentage'][$key]) ? $campos['beneficiary_percentage'][$key] : 0;
                    $account_beneficiaries->save();
                }
            }

            //Save Entity detail for Business account
            if ($campos['account']['account_type_temp'] == 'business')
            {
                $business_detail                         = BusinessDetail::where('account_id', $account_id)->first();
                //$business_detail = new BusinessDetail;
                $campos['business_detail']['account_id'] = $account_id;
                $business_detail->fill($campos['business_detail']);
                $business_detail->incorporation_date     = Carbon::createFromFormat('d/m/Y', $campos['business_detail']['incorporation_date'])->format('Y-m-d');
                $business_detail->save();
            }

            //Save account holder information
            $i             = 1;
            $client_id_arr = AccountClient::where('account_id', $account_id)->pluck('client_id')->toArray();
            AccountClient::where('account_id', $account_id)->delete();
            $user_detail   = Client::whereIn('id', $client_id_arr)->where('user_id', '!=', 0)->first();
            Client::whereIn('id', $client_id_arr)->delete();
            foreach ($campos['client']['first_name'] as $key => $value)
            {

                $client                           = new Client;
                $client->first_name               = $campos['client']['first_name'][$key];
                $client->middle_name              = $campos['client']['middle_name'][$key];
                $client->surname1                 = $campos['client']['surname1'][$key];
                $client->surname2                 = $campos['client']['surname2'][$key];
                $client->national_identity_doc_id = $campos['client']['national_identity_doc_id'][$key];
                $client->national_identity_number = $campos['client']['national_identity_number'][$key];
                $client->dob                      = Carbon::createFromFormat('d/m/Y', $campos['client']['dob'][$key])->format('Y-m-d');
                $client->gender                   = $campos['client']['gender'][$key];
                $client->birth_place              = $campos['client']['birth_place'][$key];
                $client->birth_country            = $campos['client']['birth_country'][$key];
                $client->nationality              = $campos['client']['nationality'][$key];
                $client->telephone1               = $campos['client']['telephone1'][$key];
                $client->telephone2               = $campos['client']['telephone2'][$key];
                $client->email1                   = $campos['client']['email1'][$key];
                $client->email2                   = $campos['client']['email2'][$key];

                $client->branch_id = isset($campos['client']['branch_id'][$key]) ? $campos['client']['branch_id'][$key] : '';

                if ($campos['account']['account_type_temp'] != 'business')
                {
                    $client->address         = $campos['client']['address'][$key];
                    $client->country         = $campos['client']['country'][$key];
                    $client->state           = $campos['client']['state'][$key];
                    $client->city            = $campos['client']['city'][$key];
                    $client->zip_code        = $campos['client']['zip_code'][$key];
                    $client->county          = $campos['client']['county'][$key];
                    $client->company         = $campos['client']['company'][$key];
                    $client->industry_type   = $campos['client']['industry_type'][$key];
                    $client->occupation      = $campos['client']['occupation'][$key];
                    $client->marrital_status = $campos['client']['marrital_status'][$key];
                    $client->spouse_name     = $campos['client']['spouse_name'][$key];
                    $client->telephone3      = $campos['client']['telephone3'][$key];
                }
                $client->client_type = $i;
                if ($i == 1)
                {
                    $client->user_id = $user_detail->user_id;
                }
                else
                {
                    $client->user_id = 0;
                }

                $client->save();

                //Upload National Identity
                if ($request->hasFile('national_identity_file'))
                {
                    ClientFile::where('client_id', $client->id)->delete();

                    $client_file = new ClientFile;
                    $rutaS3      = '/users/photos';
                    Storage::disk()->makeDirectory($rutaS3);

                    $checksum = md5($client->id);
                    $filename = 'national_identity' . time() . '_' . $checksum . '.jpg';
                    //$procesa = Image::make($request->national_identity_file[$key])->encode('jpg', 95);
                    //$procesa->save(public_path().$rutaS3.'/'.$filename);

                    $client_file->client_id = $client->id;
                    $client_file->file      = $filename;
                    $client_file->name      = 'national_identity_file';
                    $client_file->save();
                }


                $account_client             = new AccountClient;
                $account_client->account_id = $account_id;
                $account_client->client_id  = $client->id;
                $account_client->save();

                $i++;
            }

            DB::commit();
            return redirect('clients')->with('msg', __('sistema.update_success_msg'))->with('type', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

        return redirect('clients')->with('msg', __('sistema.update_success_msg'))->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getStatelist($id)
    {
        $states = State::where('country_id', $id)->orderBy('name')->pluck('name', 'id')->toArray();
        return ['status' => 1, 'data' => $states];
    }

    public function getcitylist($id)
    {
        $states = City::where('state_id', $id)->orderBy('name')->pluck('name', 'id')->toArray();
        return ['status' => 1, 'data' => $states];
    }

    public function getbrokercolor($id)
    {
        $broker = Broker::find($id);
        $color  = ($broker->color) ? $broker->color : '#fff';
        $code   = $broker->code . 'XXXXX';
        return ['status' => 1, 'data' => $color, 'code' => $code];
    }

}

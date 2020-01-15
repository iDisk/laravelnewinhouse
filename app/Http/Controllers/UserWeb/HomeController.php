<?php

namespace App\Http\Controllers\UserWeb;

use DB;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Util\HelperUtil;
use App\Support\Util;
use App\Models\User;
use App\Models\Client;
use App\Models\Account;
use App\Models\MovimientosTransaction;
use App\Models\AccountTransaction;
use App\Models\AccountClient;
use App\Models\Promotion;
use App\Models\TradeInvestment;
use App\Models\Country;
use App\Models\Instrument;
use App\Models\BusinessDetail;
use App\Models\AccountReference;
use App\Models\AccountBeneficiary;
use App\Models\SecurityImage;
use App\Models\SecurityQuestion;
use App\Models\UserOtherAccount;
use Yajra\DataTables\Facades\DataTables;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {

            $user_id = auth()->user()->id;

            $client_id = Client::where('user_id', $user_id)->pluck('id')->first();

            $account = Account::select('accounts.id', 'accounts.broker_id', 'accounts.account_number', 'accounts.account_type')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client_id)
                            ->groupBy('accounts.account_number')->first();

            $today_date                      = \Carbon\Carbon::now()->format('Y-m-d');
            $trade_tradeinvestment_movement  = HelperUtil::get_trade_n_trade_investment_n_movement($account->id, $today_date);
            $movement_operation_type_amt     = HelperUtil::get_movement_operation_type_amount($account->id, $today_date);
            $trade_n_tradeinvestment_amt     = HelperUtil::get_trade_n_trade_investment($account->id, $today_date);
            $financiamientos_activos_amt     = HelperUtil::getFinanciamientos_activosTotal($account->id,$today_date);

            return view('inicio')
                ->with('account', $account)
                ->with('trade_tradeinvestment_movement', $trade_tradeinvestment_movement)
                ->with('movement_operation_type_amt', $movement_operation_type_amt)
                ->with('trade_n_tradeinvestment_amt', $trade_n_tradeinvestment_amt)
                ->with('financiamientos_activos_amt', $financiamientos_activos_amt)
                ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect()->route('client_login');
        }
    }

    public function estado_de_cuenta()
    {

        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $client = auth()->user()->client;

            $account_ids = AccountClient::where('client_id', $client->id)->pluck('account_id')->toArray();

            $statement_history = \App\Models\StatementHistory::whereIn('account_id', $account_ids)->get();

            return view('estado_de_cuenta')->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('client', $client)
                            ->with('statement_history', $statement_history);
        }
        else
        {
            return redirect('error');
        }
    }

    public function derivados_etim()
    {

        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $user_id = auth()->user()->id;


            $client_id = Client::where('user_id', $user_id)->pluck('id')->first();

            $account_id = 0;

            if ($client_id)
            {
                //get account
                $account_id = AccountClient::where('client_id', $client_id)->pluck('account_id')->first();
            }

            $instrument_id = array('1');

            $transactions = AccountTransaction::select('account_transactions.id', 'account_transactions.ticket', DB::raw('account_transactions.created_at as fecha'), DB::raw("transaction_types.type_" . session('language') . " as type"), DB::raw("items.item_" . session('language') . " as item"), 'account_transactions.opening_price', 'account_transactions.closing_price', 'account_transactions.net_result as monto', 'account_transactions.contracts as size', DB::raw('0 as operation_category'), DB::raw('0 as trans_type'))
                    ->leftJoin('items', 'items.id', '=', 'account_transactions.item_id')
                    ->leftJoin('transaction_types', 'transaction_types.id', '=', 'account_transactions.transaction_type_id')
                    ->where('account_id', $account_id)
                    ->whereIn('instrument_id', $instrument_id);


            $movimientos_trans = MovimientosTransaction::select('movimientos_transactions.id', 'movimientos_transactions.ticket', DB::raw('movimientos_transactions.fecha_transaccion as fecha'), DB::raw("movimientos_tipos.type_" . session('language') . " as type"), DB::raw('null as item'), DB::raw('0 as opening_price'), DB::raw('0 as closing_price'), 'movimientos_transactions.monto', DB::raw('null as size'), 'movimientos_transactions.operation_category', DB::raw('1 as trans_type'))
                    ->leftJoin('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                    ->where('movimientos_transactions.account_id', $account_id)
                    ->whereIn('instrument_id', $instrument_id);

            $results = $transactions->union($movimientos_trans)->orderBy('fecha', 'ASC')->orderBy('id', 'ASC')->get();


            /* Get transaction total */
            $transaction_total = AccountTransaction::select(DB::raw('IFNULL(SUM(net_result),0) AS total_amount'))
                    ->where('account_id', $account_id)
                    ->whereIn('instrument_id', $instrument_id)
                    ->first();

            $movimientos_total = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 1 THEN monto WHEN operation_category = 0 THEN - monto END),0) AS total_amount')
                    ->where('account_id', $account_id)
                    ->whereIn('instrument_id', $instrument_id)
                    ->first();
            /* Get transaction total */


            return view('derivados_etim', [
                                'results'           => $results,
                                'transactions'      => $transactions,
                                'transaction_total' => $transaction_total,
                                'movimientos_total' => $movimientos_total
                            ])
                            ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function fondos_de_inversion()
    {

        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $user_id = auth()->user()->id;

            $client_id = Client::where('user_id', $user_id)->pluck('id')->first();

            $account_id = 0;

            if ($client_id)
            {
                $account_id = AccountClient::where('client_id', $client_id)->pluck('account_id')->first();
            }

            $tarde_investments = TradeInvestment::where('account_id', $account_id)
                    ->where('instrument_id', 2)
                    ->orderBy('fecha', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->get();

            $total_credit = TradeInvestment::select(DB::raw('IFNULL(SUM(monto),0) AS credit_monto'))
                    ->where('instrument_id', 2)
                    ->where('tipo', 'cr')
                    ->where('account_id', $account_id)
                    ->first();
            $total_debit  = TradeInvestment::select(DB::raw('IFNULL(SUM(monto),0) AS debit_monto'))
                    ->where('instrument_id', 2)
                    ->where('tipo', 'dr')
                    ->where('account_id', $account_id)
                    ->first();

            return view('fondos_de_inversion')
                            ->with('tarde_investments', $tarde_investments)
                            ->with('total_credit', $total_credit)
                            ->with('total_debit', $total_debit)
                            ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function promociones()
    {

        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $current_lang = HelperUtil::get_currentlang();

            $promotions = Promotion::select('id', DB::raw("promotions.promo_title_" . $current_lang . " as promo_title"), DB::raw("promotions.short_description_" . $current_lang . " as short_description"), 'promo_image', 'promo_image_thumb')
                    ->where('broker_id', 1)
                    ->where('estatus', 1)
                    ->get();

            return view('promociones')
                            ->with('promotions', $promotions)
                            ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function promociones_detale($id)
    {
        $promotion_id = HelperUtil::decode($id);
        $lstMenus     = Util::generateFrontMenu(1);
        //dd($promotion_id);

        if (auth()->user()->isActive)
        {
            $current_lang = HelperUtil::get_currentlang();

            $promotion = Promotion::select('id', DB::raw("promotions.promo_title_" . $current_lang . " as promo_title"), DB::raw("promotions.short_description_" . $current_lang . " as short_description"), DB::raw("promotions.long_description_" . $current_lang . " as long_description"), 'promo_image', 'promo_image_thumb')->find($promotion_id);

            //dd($promotion);

            if (!$promotion)
            {
                return redirect()->back();
            }

            return view('promociones_detail')
                            ->with('promotion', $promotion)
                            ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function financiamiento()
    {

        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {

            $client_id = Client::where('user_id', auth()->user()->id)->pluck('id')->first();

            $account = Account::select('accounts.id')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client_id)
                            ->groupBy('accounts.account_number')->first();

            $movimientos_tpos = array('10', '1');

            $movimientos_trans = MovimientosTransaction::select('movimientos_transactions.*', DB::raw("movimientos_tipos.type_" . session('language') . " as type"))
                    ->leftJoin('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                    ->where('movimientos_transactions.account_id', $account->id)
                    ->whereIn('movimientos_tipo_id', $movimientos_tpos)
                    ->orderBy('fecha_transaccion')
                    ->orderBy('id')
                    ->get();

            $movimientos_total = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN movimientos_tipo_id = 10 THEN monto WHEN movimientos_tipo_id = 1 THEN - monto END),0) AS total_amount')
                    ->where('account_id', $account->id)
                    ->whereIn('movimientos_tipo_id', $movimientos_tpos)
                    ->first();

            return view('financiamiento')
                ->with('movimientos_trans', $movimientos_trans)
                ->with('movimientos_total', $movimientos_total)
                ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function cambio_de_custodio()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->groupBy('accounts.account_number')->first();

            return view('cambio_de_custodio')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('account', $account);
        }
        else
        {
            return redirect('error');
        }
    }

    public function noAccess()
    {
        return view('noingresar')->with('elmenu', ['elmenu' => '']);
    }

    public function show_tnc()
    {
        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();
            $broker = $client->broker;

            $tnc = '';

            if ($broker)
            {
                $tnc = $broker->setting->footer_tnc;
            }

            $lstMenus = Util::generateFrontMenu(1);

            return view('tnc')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('tnc', $tnc);
        }
        else
        {
            return redirect('error');
        }
    }

    public function show_privacy_policy()
    {
        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();
            $broker = $client->broker;

            $privacy_policy = '';

            if ($broker)
            {
                $privacy_policy = $broker->setting->footer_privacy_policy;
            }

            $lstMenus = Util::generateFrontMenu(1);

            return view('privacy_policy')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('privacy_policy', $privacy_policy);
        }
        else
        {
            return redirect('error');
        }
    }

    public function show_change_password()
    {
        return view('change_password');
    }

    public function change_password(Request $request)
    {
        try
        {
            $campos = $request->only('old_password', 'password', 'password_confirmation');

            $rules = [
                'old_password' => 'required|min:6',
                'password'     => 'required|min:6|confirmed',
            ];

            $messages = [
                'old_password.required' => __('sistema.old_password_required_error'),
                'old_password.min'      => __('sistema.old_password_min_error'),
                'password.required'     => __('sistema.new_password_required_error'),
                'password.min'          => __('sistema.new_password_min_error'),
                'password.confirmed'    => __('sistema.new_password_confirm_error'),
            ];

            $validator = Validator::make($campos, $rules, $messages);

            if ($validator->fails())
            {
                return redirect()->back()->withInput()->with('errors', $validator->messages());
            }

            $user = auth()->user();

            $current_password = $user->password;
            if (\Hash::check($campos['old_password'], $current_password))
            {
                $user->password         = \Hash::make($campos['password']);
                $user->password_changed = 1;
                $user->save();
                return redirect()->route('client_home')->with('type', 'success')->with('message', 'Password updated successfully.');
            }
            else
            {
                return redirect()->back()->withInput()->with('errors', collect([__('sistema.old_password_invalid_error')]));
            }
        }
        catch (\Exception $ex)
        {
            return redirect()->back()->withInput()->with('errors', collect([$ex->getMessage()]));
        }
    }

    public function solicitar_un_financiamiento()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->groupBy('accounts.account_number')->first();

            return view('solicitar_un_financiamiento')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('account', $account)
                            ->with('broker_setting', $broker_setting);
        }
        else
        {
            return redirect('error');
        }
    }

    public function administracion_de_cuentas()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $countries = Country::orderBy('name')->get();

            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();
            
            return view('administracion_de_cuentas')
                            ->with('countries', $countries)                            
                            ->with('client', $client)
                            ->with('primary_account', $client->primary_account)
                            ->with('broker_setting', $broker_setting)
                            ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function amplie_su_financiamiento()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->groupBy('accounts.account_number')->first();

            $linea_de_credito_actual = HelperUtil::getFinanciamientos_activosTotal($account->id, date('Y-m-d'));
            
            $saldo_calc = HelperUtil::amplie_saldo_actual($user_id);                      
            
            $saldo_calc['linea_de_credito_actual'] = $linea_de_credito_actual;
            
            return view('amplie_su_financiamiento')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('account', $account)
                            ->with('saldo_calc', $saldo_calc)
                            ->with('broker_setting', $broker_setting);
        }
        else
        {
            return redirect('error');
        }
    }

    public function refinanciamiento()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->groupBy('accounts.account_number')->first();

            $select_arr = ['movimientos_transactions.id', 'movimientos_transactions.monto', 'movimientos_transactions.operation_category', 'movimientos_transactions.ticket', 
                'movimientos_transactions.fecha_transaccion', 'movimientos_transactions.fecha_valor'];
            
            $open_credit_requests = MovimientosTransaction::select($select_arr)                                        
                    ->where(['movimientos_transactions.account_id' => $account->id, 'movimientos_transactions.operation_category' => 1])
                    ->orderBy('movimientos_transactions.fecha_transaccion')
                    ->get()
                    ->toArray();

            if(!empty($open_credit_requests) && count($open_credit_requests) > 0)
            {
                foreach($open_credit_requests as $keyIndex => $credit_request)
                {                    
                    $this_debits = MovimientosTransaction::where(['movimientos_transactions.account_id' => $account->id, 'movimientos_transactions.operation_category' => 0, 'reference_ticket' => $credit_request['ticket']])
                    ->sum('movimientos_transactions.monto');                                        
                    $open_credit_requests[$keyIndex]['total_deposits'] = $this_debits;
                    
                    $debit_amount = number_format($this_debits, 2, '.', '');
                    $credit_amount = number_format($credit_request['monto'], 2, '.', '');
                    
                    if($debit_amount >= $credit_amount)
                    {
                        unset($open_credit_requests[$keyIndex]);
                    }
                }
            }            

            $linea_de_credito_actual = HelperUtil::getFinanciamientos_activosTotal($account->id, date('Y-m-d'));
            
            $saldo_calc = HelperUtil::amplie_saldo_actual($user_id);                      
            
            $saldo_calc['linea_de_credito_actual'] = $linea_de_credito_actual;
            
            return view('refinanciamiento')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('account', $account)
                            ->with('saldo_calc', $saldo_calc)
                            ->with('open_credit_requests', $open_credit_requests)
                            ->with('broker_setting', $broker_setting);
        }
        else
        {
            return redirect('error');
        }
    }

    public function diversify()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->groupBy('accounts.account_number')->first();

            // Fetch the different accounts of the current user
            $payment_accounts = Account::select(['accounts.*', 'account_instruments.instrument_id', 'instruments.instrument_en', 'instruments.instrument_es'])
                            ->leftJoin('account_instruments', 'account_instruments.account_id', '=', 'accounts.id')
                            ->join('instruments', 'account_instruments.instrument_id', '=', 'instruments.id')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->get();

            // Create an array of the required payment accounts
            foreach($payment_accounts as $key => $payment_account) {
                $temp = $payment_account['account_number'] . ' - ' . ($payment_account->primary_client ? $payment_account->primary_client->full_name : '') . ' - ' . $payment_account['instrument_' . session('language')];
                $payment_accounts[$key]['instrument_label'] = $temp;
            }

            // Get the list of all instruments
            $instruments = Instrument::where('active', 1)->get();
            $instrument_list = [];
            foreach($instruments as $item) {
                $temp = $item['instrument_' . session('language')];
                $instrument_list[$temp] = $temp;
            }
            

            return view('diversify')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('account', $account)
                            ->with('broker_setting', $broker_setting)
                            ->with('payment_accounts', $payment_accounts)
                            ->with('instrument_list', $instrument_list);
        }
        else
        {
            return redirect('error');
        }
    }

    public function capacidad_de_financiamiento()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->groupBy('accounts.account_number')->first();

            $today_date                      = \Carbon\Carbon::now()->format('Y-m-d');
            
            $trade_tradeinvestment_movement  = HelperUtil::get_trade_n_trade_investment_n_movement($account->id, $today_date);
            
            $consolidated_balance = 0;

            if(isset($trade_tradeinvestment_movement['1'])){
                $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['1'];
            }
            if(isset($trade_tradeinvestment_movement['2'])){
                $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['2'];
            }
            if(isset($trade_tradeinvestment_movement['3'])){
                $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['3'];
            }
            if(isset($trade_tradeinvestment_movement['4'])){
                $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['4'];
            }
            if(isset($trade_tradeinvestment_movement['5'])){
                $consolidated_balance = $consolidated_balance + $trade_tradeinvestment_movement['5'];
            }           

            $capacidad_financiamiento = $consolidated_balance * $account->credit_capability;

            return view('capacidad_de_financiamiento')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('account', $account)
                            ->with('capacidad_financiamiento', $capacidad_financiamiento)
                            ->with('broker_setting', $broker_setting);
        }
        else
        {
            return redirect('error');
        }
    }

    public function cerrar_un_financiamiento()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->groupBy('accounts.account_number')->first();

            $select_arr = ['movimientos_transactions.id', 'movimientos_transactions.monto', 'movimientos_transactions.operation_category', 'movimientos_transactions.ticket', 
                'movimientos_transactions.fecha_transaccion', 'movimientos_transactions.fecha_valor'];
            
            $open_credit_requests = MovimientosTransaction::select($select_arr)                       
                    ->where(['movimientos_transactions.account_id' => $account->id, 'movimientos_transactions.operation_category' => 1,'movimientos_tipo_id' => 18])
                    ->orderBy('movimientos_transactions.fecha_transaccion')
                    ->get()
                    ->toArray();

            if(!empty($open_credit_requests) && count($open_credit_requests) > 0)
            {
                foreach($open_credit_requests as $keyIndex => $credit_request)
                {                    
                    $this_debits = MovimientosTransaction::where(['movimientos_transactions.account_id' => $account->id, 'movimientos_transactions.operation_category' => 0, 'reference_ticket' => $credit_request['ticket'],'movimientos_tipo_id' => 18])
                    ->sum('movimientos_transactions.monto');                                        
                    $open_credit_requests[$keyIndex]['total_deposits'] = $this_debits;
                    
                    $debit_amount = number_format($this_debits, 2, '.', '');
                    $credit_amount = number_format($credit_request['monto'], 2, '.', '');
                    
                    if($debit_amount >= $credit_amount)
                    {
                        unset($open_credit_requests[$keyIndex]);
                    }else{
                        $open_credit_requests[$keyIndex]['paid'] = null;
                        if($debit_amount > 0){
                            $open_credit_requests[$keyIndex]['paid'] = $debit_amount;
                        }
                    }
                }
            }
            
            $linea_de_credito_actual = HelperUtil::getLineaDeCreditoTotal($account->id, date('Y-m-d'));
            //dd($linea_de_credito_actual);
            
            $saldo_calc = HelperUtil::amplie_saldo_actual($user_id);                      
            
            $saldo_calc['linea_de_credito_actual'] = $linea_de_credito_actual;
            
            return view('cerrar_un_financiamiento')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('account', $account)
                            ->with('saldo_calc', $saldo_calc)
                            ->with('open_credit_requests', $open_credit_requests)
                            ->with('broker_setting', $broker_setting);
        }
        else
        {
            return redirect('error');
        }
    }

    public function entre_mis_cuentas()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $current_lang      = HelperUtil::get_currentlang();
            //fetch user account
            $user_id = auth()->user()->id;

            //$client = Client::where('user_id', $user_id)->first();


            $broker_setting = HelperUtil::broker_setting();


            $client_id = Client::where('user_id', $user_id)->pluck('id')->first();
            $account_id = AccountClient::where('client_id', $client_id)->pluck('account_id')->first();

            // Fetch the different accounts of the current user
            $payment_accounts = Account::select(['accounts.*', 'account_instruments.instrument_id', 'instruments.instrument_en', 'instruments.instrument_es'])
                            ->leftJoin('account_instruments', 'account_instruments.account_id', '=', 'accounts.id')
                            ->join('instruments', 'account_instruments.instrument_id', '=', 'instruments.id')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client_id)
                            ->get();

                           
            // Create an array of the required payment accounts
            foreach($payment_accounts as $key => $payment_account) {
                $temp = $payment_account['account_number'] . ' - ' . ($payment_account->primary_client ? $payment_account->primary_client->full_name : '') . ' - ' . $payment_account['instrument_' . session('language')];
                $payment_accounts[$key]['instrument_label'] = $temp;
                $payment_accounts[$key]['saldo'] = number_format(HelperUtil::get_all_transaction_instrument($payment_accounts[$key]['id'], $payment_accounts[$key]['instrument_id']), 2);
            }

            $accountName = $payment_accounts[0]->primary_client ? $payment_accounts[0]->primary_client->full_name : '';

            return view('entre_mis_cuentas')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('accountName', $accountName)
                            ->with('broker_setting', $broker_setting)
                            ->with('payment_accounts', $payment_accounts);
        }
        else
        {
            return redirect('error');
        }
    }

    public function entre_el_mis_broker()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $current_lang      = HelperUtil::get_currentlang();
            //fetch user account
            $user_id = auth()->user()->id;

            //$client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();

            $client_id = Client::where('user_id', $user_id)->pluck('id')->first();
            $account_id = AccountClient::where('client_id', $client_id)->pluck('account_id')->first();

            $user_other_accounts = UserOtherAccount::select('user_other_accounts.dest_account_number','user_other_accounts.first_name',DB::raw("instruments.instrument_".$current_lang." as instrument"))
                ->leftJoin('instruments','instruments.id','=','user_other_accounts.instrument_id')
                ->where('destination_type','same')
                ->where('account_id', $account_id)
                ->get();

                //dd($client_id, $account_id);

            // Fetch the different accounts of the current user
            $payment_accounts = Account::select(['accounts.*', 'account_instruments.instrument_id', 'instruments.instrument_en', 'instruments.instrument_es'])
                            ->leftJoin('account_instruments', 'account_instruments.account_id', '=', 'accounts.id')
                            ->join('instruments', 'account_instruments.instrument_id', '=', 'instruments.id')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client_id)
                            ->get();

            // Create an array of the required payment accounts
            foreach($payment_accounts as $key => $payment_account) {
                $temp = $payment_account['account_number'] . ' - ' . ($payment_account->primary_client ? $payment_account->primary_client->full_name : '') . ' - ' . $payment_account['instrument_' . session('language')];
                $payment_accounts[$key]['instrument_label'] = $temp;
                $payment_accounts[$key]['saldo'] = number_format(HelperUtil::get_all_transaction_instrument($payment_accounts[$key]['id'], $payment_accounts[$key]['instrument_id']), 2);
            }

            $accountName = $payment_accounts[0]->primary_client ? $payment_accounts[0]->primary_client->full_name : '';

            return view('entre_el_mis_broker')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('accountName', $accountName)
                            ->with('broker_setting', $broker_setting)
                            ->with('user_other_accounts', $user_other_accounts)
                            ->with('payment_accounts', $payment_accounts);
        }
        else
        {
            return redirect('error');
        }
    }

    public function alta_de_cuentas()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $countries = Country::orderBy('name')->get();

            $broker_setting = HelperUtil::broker_setting();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->groupBy('accounts.account_number')->first();

            $accountName = $account->primary_client ? $account->primary_client->full_name : '';

            // Get the list of all instruments
            $instruments = Instrument::where('active', 1)->get();

            return view('alta_de_cuentas')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('accountName', $accountName)
                            ->with('broker_setting', $broker_setting)
                            ->with('instruments', $instruments)
                            ->with('countries', $countries);
        }
        else
        {
            return redirect('error');
        }
    }

    public function transferencias_internacionales()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            //fetch user account
            $user_id = auth()->user()->id;
            $current_lang      = HelperUtil::get_currentlang();

            $countries = Country::orderBy('name')->get();

            $broker_setting = HelperUtil::broker_setting();

            
            $client_id = Client::where('user_id', $user_id)->pluck('id')->first();
            $account_id = AccountClient::where('client_id', $client_id)->pluck('account_id')->first();

            $user_other_accounts = UserOtherAccount::select('user_other_accounts.id','user_other_accounts.dest_account_number','user_other_accounts.first_name',DB::raw("instruments.instrument_".$current_lang." as instrument"))
                ->leftJoin('instruments','instruments.id','=','user_other_accounts.instrument_id')
                ->where('destination_type','international')
                ->where('account_id', $account_id)
                ->get();

            $all_other_accounts = UserOtherAccount::select('user_other_accounts.dest_account_number','user_other_accounts.first_name',DB::raw("instruments.instrument_".$current_lang." as instrument"))
                ->leftJoin('instruments','instruments.id','=','user_other_accounts.instrument_id')
                /*->where('destination_type','international')*/
                ->where('account_id', $account_id)
                ->get();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client_id)
                            ->groupBy('accounts.account_number')->first();

            $accountName = $account->primary_client ? $account->primary_client->full_name : '';


            $payment_accounts = Account::select(['accounts.*', 'account_instruments.instrument_id', 'instruments.instrument_en', 'instruments.instrument_es'])
                            ->leftJoin('account_instruments', 'account_instruments.account_id', '=', 'accounts.id')
                            ->join('instruments', 'account_instruments.instrument_id', '=', 'instruments.id')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client_id)
                            ->get();

                           
            // Create an array of the required payment accounts
            foreach($payment_accounts as $key => $payment_account) {
                $temp = $payment_account['account_number'] . ' - ' . ($payment_account->primary_client ? $payment_account->primary_client->full_name : '') . ' - ' . $payment_account['instrument_' . session('language')];
                $payment_accounts[$key]['instrument_label'] = $temp;
                $payment_accounts[$key]['saldo'] = number_format(HelperUtil::get_all_transaction_instrument($payment_accounts[$key]['id'], $payment_accounts[$key]['instrument_id']), 2);
            }

            return view('transferencias_internacionales')
                    ->with('elmenu', ['elmenu' => $lstMenus])
                    ->with('user_id', $user_id)
                    ->with('account', $account)
                    ->with('accountName', $accountName)
                    ->with('user_other_accounts', $user_other_accounts)
                    ->with('all_other_accounts', $all_other_accounts)
                    ->with('countries', $countries)
                    ->with('payment_accounts', $payment_accounts)
                    ->with('broker_setting', $broker_setting);
        }
        else
        {
            return redirect('error');
        }
    }

    public function datos_personales()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $current_lang = HelperUtil::get_currentlang();
            //fetch user account
            $user_id = auth()->user()->id;

            $countries = Country::orderBy('name')->get();

            $client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();

            $account = Account::select('accounts.*')
                            ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                            ->join('clients', 'account_clients.client_id', '=', 'clients.id')
                            ->where('clients.id', $client->id)
                            ->groupBy('accounts.account_number')->first();

            $business_detail = BusinessDetail::select(['business_details.*', 'states.name as state_name', 'cities.name as city_name'])->where('account_id', $account->id)->join('states', 'states.id', '=', 'business_details.state')->join('cities', 'cities.id', '=', 'business_details.city')->orderBy('registered_name')->first();
            $account_beneficiaries = AccountBeneficiary::where('account_id', $account->id)->orderBy('name')->get();
            $account_references = AccountReference::where('account_id', $account->id)->orderBy('name')->get();

            $branches = \App\Models\Branch::orderBy('branch_' . $current_lang)->pluck('branch_' . $current_lang, 'id')->toArray();

            return view('datos_personales')
                            ->with('elmenu', ['elmenu' => $lstMenus])
                            ->with('user_id', $user_id)
                            ->with('account', $account)
                            ->with('countries', $countries)
                            ->with('business_detail', $business_detail)
                            ->with('branches', $branches)
                            ->with('account_beneficiaries', $account_beneficiaries)
                            ->with('account_references', $account_references)
                            ->with('broker_setting', $broker_setting);
        }
        else
        {
            return redirect('error');
        }
    }

    public function envio_de_documentacion()
    {
        $lstMenus = Util::generateFrontMenu(1);
        return view('envio_de_documentacion')->with('elmenu', ['elmenu' => $lstMenus]);
    }

    public function control_de_acceso()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $current_lang      = HelperUtil::get_currentlang();
            $countries = Country::orderBy('name')->get();

            $user_id = auth()->user()->id;
            $user_login = auth()->user()->user_login;

            $client = Client::where('user_id', $user_id)->first();

            $security_images =  SecurityImage::where('active','1')->orderBy('order')->get();

            $security_questions1 =  SecurityQuestion::where('active','1')->where('question_type','1')->orderBy('order')->pluck('question_'.$current_lang,'id')->toArray();
            $security_questions2 =  SecurityQuestion::where('active','1')->where('question_type','2')->orderBy('order')->pluck('question_'.$current_lang,'id')->toArray();
            $security_questions3 =  SecurityQuestion::where('active','1')->where('question_type','3')->orderBy('order')->pluck('question_'.$current_lang,'id')->toArray();

            $broker_setting = HelperUtil::broker_setting();

            return view('control_de_acceso')
                            ->with('countries', $countries)
                            ->with('client', $client)
                            ->with('user_login', $user_login)
                            ->with('broker_setting', $broker_setting)
                            ->with('security_images', $security_images)
                            ->with('security_questions1',$security_questions1)
                            ->with('security_questions2',$security_questions2)
                            ->with('security_questions3',$security_questions3)
                            ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function adjuste_de_permisos()
    {
        $lstMenus = Util::generateFrontMenu(1);

        if (auth()->user()->isActive)
        {
            $countries = Country::orderBy('name')->get();

            $user_id = auth()->user()->id;

            $client = Client::where('user_id', $user_id)->first();

            $broker_setting = HelperUtil::broker_setting();

            
            return view('adjuste_de_permisos')
                            ->with('countries', $countries)
                            ->with('client', $client)
                            ->with('broker_setting', $broker_setting)
                            ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }    
} 


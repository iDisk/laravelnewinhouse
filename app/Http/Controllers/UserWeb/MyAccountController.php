<?php

namespace App\Http\Controllers\UserWeb;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

use App\Support\Util;
use App\Models\User;
use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\AccountTransaction;
use App\Models\MovimientosTransaction;
use App\Models\AccountClient;
use App\Models\TradeInvestment;
use App\Models\Instrument;
use App\Util\HelperUtil;
use DB;
use Carbon\Carbon;

class MyAccountController extends Controller
{

    public function dataget_trade($instruments)
    {
        $current_lang = HelperUtil::get_currentlang();

        $user_id = auth()->user()->id;


        $client_id = Client::where('user_id',$user_id)->pluck('id')->first();

        $account_id = 0;
        
        if($client_id){
            //get account
            $account_id = AccountClient::where('client_id',$client_id)->pluck('account_id')->first();
        }

        $instrument_id = array('');
        $detail_url = '';
        if($instruments == 'derivados_etim'){
            $instrument_id = array('1','6','7');
            $detail_url = 'derivados_etim_detail';

        }elseif('fondos_inversion'){
            $instrument_id = array('2','3','4','5');
            $detail_url = 'fondos_inversion_detail';
        }

        $account_transactions = AccountTransaction::select('account_transactions.id','account_transactions.ticket','account_transactions.opening_date','account_transactions.closing_date','account_transactions.opening_price','account_transactions.closing_price','account_transactions.commission','account_transactions.final_capital_client',DB::raw("transaction_types.type_".$current_lang." as type"))
            ->leftJoin('transaction_types','transaction_types.id','=','account_transactions.transaction_type_id')
            ->where('account_transactions.account_id',$account_id)
            ->whereIn('account_transactions.instrument_id',$instrument_id);

        return DataTables::of($account_transactions)

        ->addColumn('action', function ($account_transaction) use($detail_url)
        {
            $botones ='<a class="color_green" href="'.url('user/'.$detail_url.'/' . HelperUtil::encode($account_transaction->id)).'">'. __('frontsistema.derivados_etim_cfds_fx.view_complete') .'</a>';
            return $botones;
        })

        ->editColumn('opening_date', function ($account_transactions) {
            return Carbon::parse($account_transactions->opening_date)->format('d-m-Y');
        })
        ->editColumn('closing_date', function ($account_transactions) {
            return Carbon::parse($account_transactions->closing_date)->format('d-m-Y');
        })
        ->make(true);
    }

    public function derivados_etim_detail($type,$transaction_id)
    {

        $current_lang = HelperUtil::get_currentlang();

        if(auth()->user()->isActive)
        {
            $lstMenus = Util::generateFrontMenu(1);

            $transaction_id = HelperUtil::decode($transaction_id);

            $account_transaction =  $movement_transaction = array();

            if($type == 'trade'){

                $account_transaction = AccountTransaction::select('account_transactions.*',DB::raw("transaction_types.type_".$current_lang." as type"),DB::raw("instruments.instrument_".$current_lang." as instrument"),DB::raw("items.item_".$current_lang." as item"),DB::raw("leverages.calc_value"))
                ->leftJoin('transaction_types','transaction_types.id','=','account_transactions.transaction_type_id')
                ->leftJoin('instruments','instruments.id','=','account_transactions.instrument_id')
                ->leftJoin('items','items.id','=','account_transactions.item_id')
                ->leftJoin('leverages','leverages.id','=','account_transactions.leverage_id')
                ->find($transaction_id);

            }elseif($type == 'mov'){

                $movement_transaction = MovimientosTransaction::select('movimientos_transactions.*',DB::raw("movimientos_tipos.type_".$current_lang." as type"), DB::raw("movimientos_transactions.movimientos_descripcion as description"))
                    ->leftJoin('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                    ->find($transaction_id);
            }

            //dd($movement_transaction);

            return view('derivados_etim_detail')
                ->with('account_transaction',$account_transaction)
                ->with('movement_transaction',$movement_transaction)
                ->with('type',$type)
                ->with('elmenu',['elmenu'=>$lstMenus]);

        }
        else
        {
            return redirect('error');
        }
    }

    public function fondos_inversion_detail($transaction_id)
    {
        //dd('test');
        $current_lang = HelperUtil::get_currentlang();

        if(auth()->user()->isActive)
        {
            $lstMenus = Util::generateFrontMenu(1);

            $transaction_id = HelperUtil::decode($transaction_id);

            $tarde_investment = TradeInvestment::find($transaction_id);

            return view('fondos_inversion_detail')
                ->with('tarde_investment',$tarde_investment)
                ->with('elmenu',['elmenu'=>$lstMenus]);

        }
        else
        {
            return redirect('error');
        }

    }

    public function last_ten_records($type,$instrument_equity_id)
    {
        
        $current_lang = HelperUtil::get_currentlang();

        if(auth()->user()->isActive)
        {
            $lstMenus = Util::generateFrontMenu(1);

            //$instrument_equity_id = HelperUtil::decode($instrument_equity_id);
            
            $user_id = auth()->user()->id;
            $client_id = Client::where('user_id',auth()->user()->id)->pluck('id')->first();

            $account_id = 0;
            
            if($client_id){
                //get account
                $account_id = AccountClient::where('client_id',$client_id)->pluck('account_id')->first();
            }

            $trade_transactions =  $movimientos_transactions = array();

            $title = 'Records';

            if($type == 'trade'){

                $trade_transactions = AccountTransaction::select('account_transactions.id', 'account_transactions.ticket', DB::raw('account_transactions.created_at as fecha'), DB::raw("transaction_types.type_" . session('language') . " as type"), DB::raw("items.item_" . session('language') . " as item"), 'account_transactions.opening_price', 'account_transactions.closing_price', 'account_transactions.net_result as monto', 'account_transactions.contracts as size', DB::raw('0 as operation_category'), DB::raw('0 as trans_type'))
                    ->leftJoin('items', 'items.id', '=', 'account_transactions.item_id')
                    ->leftJoin('transaction_types', 'transaction_types.id', '=', 'account_transactions.transaction_type_id')
                    ->where('account_id', $account_id)
                    ->where('instrument_id', $instrument_equity_id)
                    ->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')
                    ->limit(10)
                    ->get();

                $instrument = Instrument::select('id',DB::raw("instrument_" . session('language') . " as instrument"))->find($instrument_equity_id);


                if($instrument){
                    $title = $instrument->instrument;
                }

            }elseif($type == 'mov'){

                $equity_arr = explode('_',$instrument_equity_id);

                $movimientos_transactions = MovimientosTransaction::select('movimientos_transactions.id', 'movimientos_transactions.ticket', DB::raw('movimientos_transactions.fecha_transaccion as fecha'), DB::raw("movimientos_tipos.type_" . session('language') . " as type"), DB::raw('null as item'), DB::raw('0 as opening_price'), DB::raw('0 as closing_price'), 'movimientos_transactions.monto', DB::raw('null as size'), 'movimientos_transactions.operation_category', DB::raw('1 as trans_type'))
                    ->join('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                    ->where('movimientos_transactions.account_id', $account_id)
                    ->whereIn('movimientos_tipos.movimientos_tipo_category_id', $equity_arr)
                    ->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')
                    ->limit(10)
                    ->get();

                switch ($instrument_equity_id) {
                    case '1':
                        $title = __('frontsistema.home.deposits');
                        break;
                    case '2':
                        $title = __('frontsistema.home.retreats');
                        break;
                    case '4_5':
                        $title = __('frontsistema.home.commission_n_expenses');
                        break;
                    case '3_6':
                        $title = __('frontsistema.home.active_investment');
                        break;
                    default:
                        $title = 'Records';
                }

            }elseif($type == 'trade_investment'){


                $title = __('frontsistema.home.transaction');

                $tarde_investments[1] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',1)
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->limit(10)
                        ->get();

                $tarde_investments[2] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',2)
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->limit(10)
                        ->get();

                $tarde_investments[3] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',3)
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->limit(10)
                        ->get();


                $tarde_investments[4] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',4)
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->limit(10)
                        ->get();

                $tarde_investments[5] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',5)
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->limit(10)
                        ->get();


                $instrument = Instrument::select('id',DB::raw("instrument_" . session('language') . " as instrument"))->pluck('instrument','id');

                return view('inicio_trade_investment')
                ->with('title',$title)
                ->with('tarde_investments',$tarde_investments)
                ->with('instrument',$instrument)
                ->with('elmenu', ['elmenu' => $lstMenus]);

            }

            return view('inicio_ultimos_diez')
                ->with('trade_transactions',$trade_transactions)
                ->with('movimientos_transactions',$movimientos_transactions)
                ->with('title',$title)
                ->with('type',$type)
                ->with('transaction_amount',0)
                ->with('show_total',0)
                ->with('elmenu',['elmenu'=>$lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function record_bydate($type,$instrument_equity_id,$from,$to){

        $current_lang = HelperUtil::get_currentlang();

        if(auth()->user()->isActive)
        {
            $lstMenus = Util::generateFrontMenu(1);

            //$instrument_equity_id = HelperUtil::decode($instrument_equity_id);
            
            $user_id = auth()->user()->id;
            $client_id = Client::where('user_id',auth()->user()->id)->pluck('id')->first();

            $account_id = 0;
            
            if($client_id){
                //get account
                $account_id = AccountClient::where('client_id',$client_id)->pluck('account_id')->first();
            }

            $trade_transactions =  $movimientos_transactions = array();

            $title = 'Records';
            $transaction_amount=0;

            if($type == 'trade'){

                $trade_transactions = AccountTransaction::select('account_transactions.id', 'account_transactions.ticket', DB::raw('account_transactions.created_at as fecha'), DB::raw("transaction_types.type_" . session('language') . " as type"), DB::raw("items.item_" . session('language') . " as item"), 'account_transactions.opening_price', 'account_transactions.closing_price', 'account_transactions.net_result as monto', 'account_transactions.contracts as size', DB::raw('0 as operation_category'), DB::raw('0 as trans_type'))
                    ->leftJoin('items', 'items.id', '=', 'account_transactions.item_id')
                    ->leftJoin('transaction_types', 'transaction_types.id', '=', 'account_transactions.transaction_type_id')
                    ->where('account_id', $account_id)
                    ->where('instrument_id', $instrument_equity_id)
                    ->whereBetween('account_transactions.created_at', [$from.' 00-00-00', $to.' 23-59-59'])
                    ->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')
                    ->get();

                $instrument = Instrument::select('id',DB::raw("instrument_" . session('language') . " as instrument"))->find($instrument_equity_id);


                if($instrument){
                    $title = $instrument->instrument;
                }
                
                $transaction_amount = HelperUtil::get_transactions_opening_instrument_balance($account_id,$from,$instrument_equity_id);

            }elseif($type == 'mov'){

                $equity_arr = explode('_',$instrument_equity_id);

                $movimientos_transactions = MovimientosTransaction::select('movimientos_transactions.id', 'movimientos_transactions.ticket', DB::raw('movimientos_transactions.fecha_transaccion as fecha'), DB::raw("movimientos_tipos.type_" . session('language') . " as type"), DB::raw('null as item'), DB::raw('0 as opening_price'), DB::raw('0 as closing_price'), 'movimientos_transactions.monto', DB::raw('null as size'), 'movimientos_transactions.operation_category', DB::raw('1 as trans_type'))
                    ->join('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                    ->where('movimientos_transactions.account_id', $account_id)
                    ->whereIn('movimientos_tipos.movimientos_tipo_category_id', $equity_arr)
                    ->whereBetween('movimientos_transactions.fecha_transaccion', [$from, $to])
                    ->orderBy('fecha', 'DESC')->orderBy('id', 'DESC')
                    ->get();
                //dd($movimientos_transactions);

                switch ($instrument_equity_id) {
                    case '1':
                        $title = __('frontsistema.home.deposits');
                        break;
                    case '2':
                        $title = __('frontsistema.home.retreats');
                        break;
                    case '4_5':
                        $title = __('frontsistema.home.commission_n_expenses');
                        break;
                    case '3_6':
                        $title = __('frontsistema.home.active_investment');
                        break;
                    default:
                        $title = 'Records';
                }

                $transaction_amount = HelperUtil::get_movement_opening_equity_balance($account_id,$from,$equity_arr);

            }elseif($type == 'trade_investment'){

                $title = __('frontsistema.home.transaction');

                $tarde_investments[1] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',1)
                        ->whereBetween('fecha', [$from, $to])
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->get();

                $tarde_investments[2] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',2)
                        ->whereBetween('fecha', [$from, $to])
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->get();

                $tarde_investments[3] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',3)
                        ->whereBetween('fecha', [$from, $to])
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->get();


                $tarde_investments[4] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',4)
                        ->whereBetween('fecha', [$from, $to])
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->get();

                $tarde_investments[5] = TradeInvestment::where('account_id',$account_id)
                        ->where('instrument_id',5)
                        ->whereBetween('fecha', [$from, $to])
                        ->orderBy('fecha','DESC')
                        ->orderBy('created_at','DESC')
                        ->get();


                $instrument = Instrument::select('id',DB::raw("instrument_" . session('language') . " as instrument"))->pluck('instrument','id');

                $from_date = date('d-m-Y', strtotime($from));
                $to_date = date('d-m-Y', strtotime($to));

                return view('inicio_trade_investment')
                ->with('title',$title)
                ->with('tarde_investments',$tarde_investments)
                ->with('instrument',$instrument)
                ->with('from',$from_date)
                ->with('to',$to_date)
                ->with('elmenu', ['elmenu' => $lstMenus]);
            }

            $from_date = date('d-m-Y', strtotime($from));
            $to_date = date('d-m-Y', strtotime($to));

            return view('inicio_ultimos_diez')
                ->with('trade_transactions',$trade_transactions)
                ->with('movimientos_transactions',$movimientos_transactions)
                ->with('title',$title)
                ->with('type',$type)
                ->with('from',$from_date)
                ->with('to',$to_date)
                ->with('transaction_amount',$transaction_amount)
                ->with('show_total',0)
                ->with('elmenu',['elmenu'=>$lstMenus]);
        }
        else
        {
            return redirect('error');
        }

    }

    public function inicio_view($type,$transaction_id)
    {
        $current_lang = HelperUtil::get_currentlang();

        if(auth()->user()->isActive)
        {
            $lstMenus = Util::generateFrontMenu(1);

            $transaction_id = HelperUtil::decode($transaction_id);

            $account_transaction =  $movement_transaction = array();

            if($type == 'trade'){

                $account_transaction = AccountTransaction::select('account_transactions.*',DB::raw("transaction_types.type_".$current_lang." as type"),DB::raw("instruments.instrument_".$current_lang." as instrument"),DB::raw("items.item_".$current_lang." as item"),DB::raw("leverages.calc_value"))
                ->leftJoin('transaction_types','transaction_types.id','=','account_transactions.transaction_type_id')
                ->leftJoin('instruments','instruments.id','=','account_transactions.instrument_id')
                ->leftJoin('items','items.id','=','account_transactions.item_id')
                ->leftJoin('leverages','leverages.id','=','account_transactions.leverage_id')
                ->find($transaction_id);

                $title = $account_transaction->instrument;
                

            }elseif($type == 'mov'){

                $movement_transaction = MovimientosTransaction::select('movimientos_transactions.*','movimientos_tipos.movimientos_tipo_category_id',DB::raw("movimientos_tipos.type_".$current_lang." as type"), DB::raw("movimientos_transactions.movimientos_descripcion as description"))
                    ->leftJoin('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                    ->find($transaction_id);

                switch ($movement_transaction->movimientos_tipo_category_id) {
                    case '1':
                        $title = __('frontsistema.home.deposits');
                        break;
                    case '2':
                        $title = __('frontsistema.home.retreats');
                        break;
                    case '4_5':
                        $title = __('frontsistema.home.commission_n_expenses');
                        break;
                    default:
                        $title = 'Records';
                }
            }

            return view('inicio_view')
                ->with('account_transaction',$account_transaction)
                ->with('movement_transaction',$movement_transaction)
                ->with('type',$type)
                ->with('title',$title)
                ->with('elmenu',['elmenu'=>$lstMenus]);

        }
        else
        {
            return redirect('error');
        }
    }

    // Function to return the pending internal transfers of the current user
    public function pending_internal_transfers(Request $request)
    {
        $campos = $request->all();
        $request_type_id = isset($campos['request_type_id'])?$campos['request_type_id']:8;
        try
        {
            $data = [
                "data" => null,
                "error" => false,
                "code" => 200,
            ];

            $internal_transfer_requests = ClientRequest::where('user_id', $campos['user_id'])
                                            ->where('account_id', $campos['account_id'])
                                            ->where('request_status_id', 1)
                                            ->where('status', 0)
                                            ->where('request_type_id', $request_type_id)
                                            ->get()
                                            ->toArray();

            $data['data'] = $internal_transfer_requests;
            
            return response()->json($data,200);
        }
        catch (\Exception $e)
        {
            dd($e);
            $data = [
                "message" => __('frontsistema.went_wrong_msg'),
                "error" => true,
                "code" => 500,
            ];
            return response()->json($data,200);
        }

    }

    // Function to return the pending internal broker transfers of the current user
    public function pending_internal_broker_transfers(Request $request)
    {
        $campos = $request->all();
        $request_type_id = isset($campos['request_type_id'])?$campos['request_type_id']:42;
        try
        {
            $data = [
                "data" => null,
                "error" => false,
                "code" => 200,
            ];

            $internal_transfer_requests = ClientRequest::where('user_id', $campos['user_id'])
                                            ->where('account_id', $campos['account_id'])
                                            ->where('request_status_id', 1)
                                            ->where('status', 0)
                                            ->where('request_type_id', $request_type_id)
                                            ->get()
                                            ->toArray();

            $data['data'] = $internal_transfer_requests;
            
            return response()->json($data,200);
        }
        catch (\Exception $e)
        {
            dd($e);
            $data = [
                "message" => __('frontsistema.went_wrong_msg'),
                "error" => true,
                "code" => 500,
            ];
            return response()->json($data,200);
        }

    }

    // Function to return the pending international transfers of the current user
    public function pending_international_transfers(Request $request)
    {
        $campos = $request->all();
        $request_type_id = isset($campos['request_type_id'])?$campos['request_type_id']:9;
        try
        {
            $data = [
                "data" => null,
                "error" => false,
                "code" => 200,
            ];

            $internal_transfer_requests = ClientRequest::where('user_id', $campos['user_id'])
                                            ->where('account_id', $campos['account_id'])
                                            ->where('request_status_id', 1)
                                            ->where('status', 0)
                                            ->where('request_type_id', $request_type_id)
                                            ->get()
                                            ->toArray();

            $data['data'] = $internal_transfer_requests;
            
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

    // Function to return the pending account registration of the current user
    public function pending_account_registrations(Request $request)
    {
        $campos = $request->all();
        $request_type_id = isset($campos['request_type_id'])?$campos['request_type_id']:28;
        try
        {
            $data = [
                "data" => null,
                "error" => false,
                "code" => 200,
            ];

            $pending_account_registrations = ClientRequest::select(['*', DB::raw("DATE_FORMAT(created_at,'%d/%m/%Y') as formatted_created_at")])->where('user_id', $campos['user_id'])
                                            ->where('request_status_id', 1)
                                            ->where('status', 0)
                                            ->where('request_type_id', $request_type_id)
                                            ->get()
                                            ->toArray();

            $data['data'] = $pending_account_registrations;

            
            return response()->json($data,200);
        }
        catch (\Exception $e)
        {
            dd($e);
            $data = [
                "message" => __('frontsistema.went_wrong_msg'),
                "error" => true,
                "code" => 500,
            ];
            return response()->json($data,200);
        }

    }
}

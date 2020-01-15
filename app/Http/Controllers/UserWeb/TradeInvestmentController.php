<?php

namespace App\Http\Controllers\UserWeb;

use DB;
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
use Yajra\DataTables\Facades\DataTables;

class TradeInvestmentController extends Controller
{

    public function mis_cuentas_instrumentos($instrumentos)
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

            switch ($instrumentos) {
                case 'fondos_de_inversion':
                    $instrument_id = 2;
                    $title = __('frontsistema.trade_investment.fondos_de_inversion');
                    break;
                case 'wealth_management':
                    $instrument_id = 3;
                    $title = __('frontsistema.trade_investment.wealth_management');
                    break;
                case 'productos_estructurados':
                    $instrument_id = 4;
                    $title = __('frontsistema.trade_investment.structured_products');
                    break;
                case 'portafolio_mixto':
                    $instrument_id = 5;
                    $title = __('frontsistema.trade_investment.mixed_portfolio');
                    break;
                default:
                    return redirect()->route('client_home');
                    break;
            }
            
            //Fetch records
            $trade_investments = TradeInvestment::select('trade_investments.id','trade_investments.ticket','trade_investments.fecha','trade_investments.transaction','trade_investments.fecha_vencimiento','trade_investments.monto','trade_investments.nav','trade_investments.riesgo','trade_investments.tipo',DB::raw('null as operation_category'),DB::raw('0 as trans_type'),'trade_investments.is_opening')
                    ->where('account_id', $account_id)
                    ->where('instrument_id', $instrument_id);

            $movimientos_trans = MovimientosTransaction::select('movimientos_transactions.id', 'movimientos_transactions.ticket', DB::raw('movimientos_transactions.fecha_transaccion as fecha'), DB::raw('movimientos_transactions.movimientos_descripcion as transaction'),DB::raw('null as fecha_vencimiento'),'movimientos_transactions.monto',DB::raw('null as nav'),DB::raw('null as riesgo'),DB::raw('null as tipo'),'movimientos_transactions.operation_category',DB::raw('1 as trans_type'),DB::raw('null as is_opening'))
                    ->where('movimientos_transactions.account_id', $account_id)
                    ->where('instrument_id', $instrument_id);

            // join records
            $results = $trade_investments->union($movimientos_trans)->orderBy('fecha', 'ASC')->orderBy('id', 'ASC')->get();


            //Get total
            $movimientos_total = MovimientosTransaction::select(DB::raw('IFNULL(SUM(CASE WHEN movimientos_transactions.operation_category = 1 THEN movimientos_transactions.monto WHEN movimientos_transactions.operation_category = 0 THEN - movimientos_transactions.monto END),0) AS total_amount'))
                    ->where('movimientos_transactions.account_id', $account_id)
                    ->where('instrument_id', $instrument_id)
                    ->pluck('total_amount')->first();

            $trade_investment_total = TradeInvestment::select(DB::raw('IFNULL(SUM(CASE WHEN tipo = "cr" THEN monto WHEN tipo = "dr" THEN - monto END),0) AS total_amount'))
                    ->where('account_id',$account_id)
                    ->where('instrument_id',$instrument_id)
                    ->pluck('total_amount')->first();


            $total_amount = $movimientos_total + $trade_investment_total;

            return view('mis_cuentas_instrumentos')
                ->with('results',$results)
                ->with('total_amount',$total_amount)
                ->with('title',$title)
                ->with('elmenu', ['elmenu' => $lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function cuentas_instrumentos_detalle($type,$transaction_id)
    {
        $current_lang = HelperUtil::get_currentlang();

        if(auth()->user()->isActive)
        {
            $lstMenus = Util::generateFrontMenu(1);

            $transaction_id = HelperUtil::decode($transaction_id);

            $tarde_investment = $movimientos_transaction = array();

            $instrumentos_id = 0;

            if($type == 'mov')
            {
                $movimientos_transaction = MovimientosTransaction::select('movimientos_transactions.*',DB::raw("movimientos_tipos.type_".$current_lang." as type"), DB::raw("movimientos_transactions.movimientos_descripcion as description"))
                    ->leftJoin('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                    ->find($transaction_id);

                $instrumentos_id = $movimientos_transaction->instrument_id;

            }else
            {
                $tarde_investment = TradeInvestment::find($transaction_id);

                $instrumentos_id = $tarde_investment->instrument_id;

            }



            switch ($instrumentos_id) {
                case 2:
                    $title = __('frontsistema.trade_investment.fondos_de_inversion');
                    $listing_url = '/user/mis_cuentas_instrumentos/fondos_de_inversion';
                    break;
                case 3:
                    $title = __('frontsistema.trade_investment.wealth_management');
                    $listing_url = '/user/mis_cuentas_instrumentos/wealth_management';
                    break;
                case 4:
                    $title = __('frontsistema.trade_investment.structured_products');
                    $listing_url = '/user/mis_cuentas_instrumentos/productos_estructurados';
                    break;
                case 5:
                    $title = __('frontsistema.trade_investment.mixed_portfolio');
                    $listing_url = '/user/mis_cuentas_instrumentos/portafolio_mixto';
                    break;
                default:
                    $title = redirect()->route('client_home');
                    break;
            }
            
            return view('cuentas_instrumentos_detalle')
                ->with('tarde_investment',$tarde_investment)
                ->with('movimientos_transaction',$movimientos_transaction)
                ->with('type',$type)
                ->with('title',$title)
                ->with('listing_url',$listing_url)
                ->with('elmenu',['elmenu'=>$lstMenus]);
        }
        else
        {
            return redirect('error');
        }
    }

    public function trade_investment_view($transaction_id)
    {
        $current_lang = HelperUtil::get_currentlang();

        if(auth()->user()->isActive)
        {
            $lstMenus = Util::generateFrontMenu(1);

            $transaction_id = HelperUtil::decode($transaction_id);

            $tarde_investment = TradeInvestment::find($transaction_id);

            return view('trade_investment_detail')
                ->with('tarde_investment',$tarde_investment)
                ->with('elmenu',['elmenu'=>$lstMenus]);

        }
        else
        {
            return redirect('error');
        }

    }
}
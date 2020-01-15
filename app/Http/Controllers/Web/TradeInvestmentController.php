<?php

namespace App\Http\Controllers\Web;

use DB;
use Validator;
use Carbon\Carbon;
use App\Support\Util;
use App\Models\Account;
use App\Util\HelperUtil;
use Illuminate\Http\Request;
use App\Models\TradeInvestment;
use App\Models\Instrument;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TradeInvestmentController extends Controller
{

    public function data_trade_investment(Request $request, $id = null)
    {
        $current_lang     = HelperUtil::get_currentlang();
        $account_id = $request->has('account_id') ? $request->account_id : null;
        $instrument_id = $request->has('instrument_id') ? $request->instrument_id : null;
        $broker_id = $request->has('broker_id') ? $request->broker_id : '';
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();
        
        if ($id)
        {
            $account_id = HelperUtil::decode($id);
        }

        $trade_investments = TradeInvestment::select('trade_investments.*', 'accounts.account_number', DB::raw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) as client_name'),DB::raw("instrument_" . $current_lang . " as instrument"))
                ->leftJoin('accounts', 'accounts.id', '=', 'trade_investments.account_id')
                ->leftJoin('account_clients', 'account_clients.account_id', '=', 'trade_investments.account_id')
                ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                ->leftJoin('instruments', 'instruments.id', '=', 'trade_investments.instrument_id')
                ->groupBy('trade_investments.id');

        if ($account_id)
        {
            $trade_investments->where('trade_investments.account_id', $account_id);
        }

        if ($instrument_id)
        {
            $trade_investments->where('trade_investments.instrument_id', $instrument_id);
        }

        if($broker_id == '')
        {            
            $trade_investments->whereIn('accounts.broker_id', $assigned_brokers_id);
        }
        else
        {
            if(in_array($broker_id, $assigned_brokers_id))
            {
                $trade_investments->where('accounts.broker_id', $broker_id);
            }
            else
            {
                $trade_investments->where('accounts.broker_id', null);
            }
        }          
        
        return DataTables::of($trade_investments)
                        ->addColumn('action', function ($trade_investments)
                        {
                            $botones = '<a href="' . url('trade_investment/' . $trade_investments->id . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';
                            $botones .= '<form action="' . url('trade_investment/' . $trade_investments->id) . '" id="borra_Frm' . $trade_investments->id . '" method="POST" class="pull-left">' . csrf_field() . ' ' . method_field('DELETE') . '<button type="button" onclick="confirmaDel(' . $trade_investments->id . ',\'' . $trade_investments->ticket . '\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>';
                            return $botones;
                        })
                        ->editColumn('monto', function($trade_investments){
                            return number_format($trade_investments->monto, 2, '.', ',');
                        })
                        ->editColumn('tipo', function($trade_investments)
                        {
                            return ucfirst($trade_investments->tipo);
                        })
                        ->filterColumn('client_name', function($query, $keyword)
                        {
                            return $query->whereRaw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) like "' . '%' . $keyword . '%"');
                        })
                        ->filterColumn('account_number', function($query, $keyword)
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
        $user = auth()->user();
        $current_lang     = HelperUtil::get_currentlang();
        $lstMenus = Util::generateMenu($user->perfil_id);
        $assigned_brokers_id = collect($user->assigned_brokers)->pluck('id')->toArray();
        
        $accounts = Account::select('id', 'account_number')
                                ->whereIn('broker_id', $assigned_brokers_id)
                                ->orderBy('account_number')
                                ->get();
        
        $instrument_id = array('2', '3', '4', '5');
        $instruments = Instrument::select('id',DB::raw("instrument_" . $current_lang . " as instrument"))->whereIn('id',$instrument_id)->where('active',1)->pluck('instrument', 'id')->toArray();

        return view('catalogos.trade_investment.index')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('instruments', $instruments)
                        ->with('accounts', $accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $lstMenus         = Util::generateMenu($user->perfil_id);
        $current_lang     = HelperUtil::get_currentlang();
        $assigned_brokers_id = collect($user->assigned_brokers)->pluck('id')->toArray();        
        $accounts = Account::select('id', 'account_number')
                                ->whereIn('broker_id', $assigned_brokers_id)
                                ->orderBy('account_number')
                                ->get();
        $instrument_id = array('2', '3', '4', '5');
        $instruments = Instrument::select('id',DB::raw("instrument_" . $current_lang . " as instrument"))->whereIn('id',$instrument_id)->where('active',1)->pluck('instrument', 'id')->toArray();
        
        /*
        $last_transaction = TradeInvestment::select('id', 'ticket')->orderBy('created_at', 'desc')->first();
        if ($last_transaction)
        {
            $next_token_number = sprintf("%08d", $last_transaction->ticket + env('TICKET_INCREMENT_FACTOR', 17));
            $already_exists    = TradeInvestment::select('id')->where('ticket', $next_token_number)->first();

            if ($already_exists)
            {
                $token_number = Util::nextAvailableTicketNumberTradeInvestment($next_token_number);
            }
            else
            {
                $token_number = $next_token_number;
            }
        }
        else
        {
            $token_number = env('TICKET_START_POINT_INVESTMENT', '10000017');
        } */

        $ticket_counter = \App\Models\TicketCounter::select('counter')->find(1);
        $token_number = Util::nextTicketNumber($ticket_counter->counter + 17,0);

        return view('catalogos.trade_investment.create')
                ->with('elmenu', ['elmenu' => $lstMenus])
                ->with('instruments', $instruments)
                ->with('token_number', $token_number)
                ->with('accounts', $accounts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $campos = $request->all();

            DB::beginTransaction();
            $trade_investment = new TradeInvestment;
            $account          = Account::where('id', $campos['account_number'])->first();


            $ticket_counter = \App\Models\TicketCounter::select('counter')->find(1);
            $next_id = Util::nextTicketNumber($ticket_counter->counter + 17,0);

            if (isset($campos['ticket']))
            {

                $ticket_number = $campos['ticket'];

                $exist = Util::checkTicketNumber($campos['ticket'],0,'TradeInvestment');

                if($exist == 1)
                {
                    $next_id = Util::nextTicketNumber($campos['ticket'],0);

                    DB::commit();
                    return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                }
            }
            else
            {
                $ticket_number = $next_id;
            }

            if($next_id == $ticket_number)
            {
                \App\Models\TicketCounter::where('id',1)->update(['counter' => DB::raw('counter + 17')]);

            }

            /*if (isset($campos['ticket']))
            {
                $ticket_number = $campos['ticket'];
                if ($ticket_number != '')
                {
                    $already_exists = TradeInvestment::select('id')->where('ticket', $ticket_number)->first();

                    if ($already_exists)
                    {
                        $next_id = Util::nextAvailableTicketNumberTradeInvestment($campos['ticket']);
                        DB::rollback();
                        return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                    }
                }
            }
            else
            {
                $last_transaction = TradeInvestment::select('id', 'ticket')->orderBy('created_at', 'desc')->first();

                if ($last_transaction)
                {
                    $next_token_number = sprintf("%08d", $last_transaction->ticket + env('TICKET_INCREMENT_FACTOR', 17));
                    $already_exists    = TradeInvestment::select('id')->where('ticket', $next_token_number)->first();

                    if ($already_exists)
                    {
                        $ticket_number = Util::nextAvailableTicketNumberTradeInvestment($next_token_number);
                    }
                }
                else
                {
                    $ticket_number = env('TICKET_START_POINT_INVESTMENT', '10000017');
                }
            } */

            //Check if opening balance transaction
            $prev_transaction = TradeInvestment::where('account_id', $campos['account_number'])
                            ->where('instrument_id',$campos['instrument_id'])
                            ->first();

            $is_opening = false;

            $fecha_vencimiento = (isset($campos['fecha_vencimiento']) && $campos['fecha_vencimiento'] != '') ?
                    Carbon::createFromFormat('d/m/Y', $campos['fecha_vencimiento'])->format('Y-m-d') : Carbon::createFromFormat('d/m/Y', $campos['fecha'])->format('Y-m-d');

            if (!$prev_transaction)
            {
                $campos['transaction'] = __('sistema.trade_investment.is_opening');
                $is_opening            = true;
                $fecha_vencimiento     = Carbon::createFromFormat('d/m/Y', $campos['fecha'])->format('Y-m-d');
                $campos['tipo']        = 'cr';
                $campos['precio']      = 0.00;
                $campos['riesgo']      = 0.00;
                $campos['contratos']   = 0.00;
            }

            $trade_investment->ticket            = $ticket_number;
            $trade_investment->account_id        = $campos['account_number'];
            $trade_investment->instrument_id     = $campos['instrument_id'];
            $trade_investment->fecha             = Carbon::createFromFormat('d/m/Y', $campos['fecha'])->format('Y-m-d');
            $trade_investment->fecha_vencimiento = $fecha_vencimiento;
            $trade_investment->transaction       = $campos['transaction'];
            $trade_investment->tipo              = $campos['tipo'];
            $trade_investment->monto             = str_replace(',', '', $campos['monto']);
            $trade_investment->precio            = $campos['precio'];
            $trade_investment->riesgo            = $campos['riesgo'];
            $trade_investment->contratos         = $campos['contratos'];
            $trade_investment->nav               = $campos['nav'];
            $trade_investment->is_opening        = $is_opening;

            if ($prev_transaction)
            {
                //Calculated values
                $nav_comm              = env("NAV_COMMISSION", 0.96);
                $nav_val               = $trade_investment->monto * $nav_comm;
                //$trade_investment->nav = number_format($nav_val, 4, '.', '');

                $exposicion_val               = $trade_investment->riesgo * $trade_investment->monto;
                $trade_investment->exposicion = number_format($exposicion_val, 4, '.', '');
            }
            else
            {
                $trade_investment->exposicion = 0.00;
            }

            if ($trade_investment->save())
            {
                DB::commit();
                return redirect('trade_investment')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
            }
            else
            {
                DB::rollback();
                return redirect()->back()->withInput()->with('msg', __('sistema.save_fail_msg'))->with('type', 'error');
            }
        }
        catch (\Exception $ex)
        {
            DB::rollback();
            return redirect()->back()->withErrors($ex->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TradeInvestment  $tradeInvestment
     * @return \Illuminate\Http\Response
     */
    public function show(TradeInvestment $trade_investment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TradeInvestment  $tradeInvestment
     * @return \Illuminate\Http\Response
     */
    public function edit(TradeInvestment $trade_investment)
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        $accounts = Account::select('id', 'account_number')->orderBy('account_number')->get();

        $current_lang     = HelperUtil::get_currentlang();
        $instrument_id = array('2', '3', '4', '5');
        $instruments = Instrument::select('id',DB::raw("instrument_" . $current_lang . " as instrument"))->whereIn('id',$instrument_id)->where('active',1)->pluck('instrument', 'id')->toArray();

        $opening_balance_date = null;
        
        $opening_balance = TradeInvestment::where(['account_id' => $trade_investment->account_id, 'is_opening' => 1,'instrument_id'=>$trade_investment->instrument_id])->first();
        
        if($opening_balance)
        {
            $opening_balance_date = $opening_balance->fecha;
        }
        
        return view('catalogos.trade_investment.edit')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('accounts', $accounts)
                        ->with('opening_balance_date', $opening_balance_date)
                        ->with('instruments', $instruments)
                        ->with('trade_investment', $trade_investment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TradeInvestment  $trade_investment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TradeInvestment $trade_investment)
    {
        try
        {
            $campos = $request->all();

            DB::beginTransaction();

            if ($campos['ticket'] != $trade_investment->ticket)
            {
                $exist = Util::checkTicketNumber($campos['ticket'],$trade_investment->id,'TradeInvestment');

                if($exist == 1)
                {
                    //$ticket_counter = \App\Models\TicketCounter::select('counter')->find(1);
                    $next_id = Util::nextTicketNumber($campos['ticket'],0);
                
                    DB::commit();
                    return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                }
            }

            /*if ($campos['ticket'] != $trade_investment->ticket)
            {
                $already_exists = TradeInvestment::select('id')->where('id', '<>', $trade_investment->id)
                        ->where('ticket', $campos['ticket'])
                        ->first();

                if ($already_exists)
                {
                    $next_id = Util::nextAvailableTicketNumberTradeInvestment($campos['ticket']);
                    DB::rollback();
                    return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                }
            }*/


            if ($campos['fecha'])
            {
                $campos['fecha'] = Carbon::createFromFormat('d/m/Y', $campos['fecha'])->format('Y-m-d');
            }

            if ($trade_investment->is_opening == 1)
            {
                $campos['tipo'] = 'cr';
            }

            //Check if opening balance transaction
            $prev_transaction = TradeInvestment::where('account_id', $trade_investment->account_id)->first();

            $is_opening = $trade_investment->is_opening;

            if ($is_opening)
            {
                if ($trade_investment->fecha != $campos['fecha'])
                {
                    $min_fecha = TradeInvestment::where('account_id', $trade_investment->account_id)
                                    ->where('id', '<>', $trade_investment->id)->min('fecha');

                    if ($min_fecha)
                    {
                        if ($min_fecha < $campos['fecha'])
                        {
                            DB::rollback();
                            return redirect()->back()->withInput()->with('msg', __('sistema.trade_investment.fecha_opening_error', ['minDateValue' => $min_fecha]))->with('type', 'error');
                        }
                    }
                }
            }

            $fecha_vencimiento = (isset($campos['fecha_vencimiento']) && $campos['fecha_vencimiento'] != '') ?
                    Carbon::createFromFormat('d/m/Y', $campos['fecha_vencimiento'])->format('Y-m-d') : Carbon::createFromFormat('d/m/Y', $campos['fecha'])->format('Y-m-d');

            if (!$prev_transaction)
            {
                $campos['transaction'] = __('sistema.trade_investment.is_opening');
                $fecha_vencimiento     = Carbon::createFromFormat('d/m/Y', $campos['fecha'])->format('Y-m-d');
                if (isset($campos['tipo']))
                {
                    $campos[] = ['tipo' => 'cr'];
                }
                else
                {
                    $campos['tipo'] = 'cr';
                }
                $campos['precio']    = 0.00;
                $campos['riesgo']    = 0.00;
                $campos['contratos'] = 0.00;
            }

            $trade_investment->ticket            = $campos['ticket'];
            //$trade_investment->account_id        = $campos['account_number'];
            $trade_investment->fecha             = $campos['fecha'];
            $trade_investment->fecha_vencimiento = $fecha_vencimiento;
            $trade_investment->transaction       = $campos['transaction'];
            $trade_investment->tipo              = $campos['tipo'];
            $trade_investment->monto             = str_replace(',', '', $campos['monto']);
            $trade_investment->precio            = $campos['precio'];
            $trade_investment->riesgo            = $campos['riesgo'];
            $trade_investment->contratos         = $campos['contratos'];
            $trade_investment->nav               = $campos['nav'];
            
            if ($is_opening)
            {
                //Calculated values
                $nav_comm              = env("NAV_COMMISSION", 0.96);
                $nav_val               = $trade_investment->monto * $nav_comm;
                //$trade_investment->nav = number_format($nav_val, 4, '.', '');

                $exposicion_val               = $trade_investment->riesgo * $trade_investment->monto;
                $trade_investment->exposicion = number_format($exposicion_val, 4, '.', '');
            }
            else
            {
                $trade_investment->exposicion = 0.00;
            }

            if ($trade_investment->save())
            {
                DB::commit();
                return redirect('trade_investment')->with('msg', __('sistema.update_success_msg'))->with('type', 'success');
            }
            else
            {
                DB::rollback();
                return redirect()->back()->withInput()->with('msg', __('sistema.update_fail_msg'))->with('type', 'error');
            }
        }
        catch (\Exception $ex)
        {
            DB::rollback();
            return redirect()->back()->withErrors($ex->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TradeInvestment  $tradeInvestment
     * @return \Illuminate\Http\Response
     */
    public function destroy(TradeInvestment $trade_investment)
    {
        try
        {
            DB::beginTransaction();

            $other_records = TradeInvestment::where('account_id', $trade_investment->account_id)->where('instrument_id',$trade_investment->instrument_id)->where('id', '<>', $trade_investment->id)->first();

            if ($other_records)
            {
                if ($trade_investment->is_opening)
                {
                    DB::rollback();
                    return redirect()->back()->withInput()->with('msg', __('sistema.trade_investment.fecha_opening_delete_error'))->with('type', 'error');
                }
            }

            if ($trade_investment->delete())
            {
                DB::commit();
                return redirect('trade_investment')->with('msg', __('sistema.remove_success_msg'))->with('type', 'success');
            }
            else
            {
                DB::rollback();
                return redirect()->back()->withInput()->with('msg', __('sistema.remove_fail_msg'))->with('type', 'error');
            }
        }
        catch (\Exception $ex)
        {
            DB::rollback();
            return redirect()->back()->withInput()->with('msg', $ex->getMessage())->with('type', 'error');
        }
    }

}

<?php

namespace App\Http\Controllers\Web;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MovimientosDescripcion;
use App\Models\MovimientosTipo;
use App\Models\Instrument;
use App\Models\Account;
use App\Models\MovimientosTransaction;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use App\Util\HelperUtil;
use Validator;
use Carbon\Carbon;

class MovimientosTransactionController extends Controller
{
    /*
     * Constructor de la clase que instancia el middleware auth
     */

    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    //Funcion para DataTable
    public function datamovimientos_transactions(Request $request)
    {
        $account_id = $request->has('account_id') ? $request->account_id : '';

        $movimientos_trans = MovimientosTransaction::select('movimientos_transactions.*', 'accounts.account_number', DB::raw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) as client_name'))
                ->join('accounts', 'accounts.id', '=', 'movimientos_transactions.account_id')
                ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                ->join('clients', 'clients.id', '=', 'account_clients.client_id')
                ->where('clients.client_type', 1);

        $broker_id = $request->has('broker_id') ? $request->broker_id : '';
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();
        
        if ($account_id != '')
        {
            $movimientos_trans->Where('movimientos_transactions.account_id', $account_id);
        }

        if($broker_id == '')
        {
            $movimientos_trans->whereIn('accounts.broker_id', $assigned_brokers_id);
        }
        else
        {
            if(in_array($broker_id, $assigned_brokers_id))
            {
                $movimientos_trans->where('accounts.broker_id', $broker_id);
            }
            else
            {
                $movimientos_trans->where('accounts.broker_id', null);
            }
        }
        
        return DataTables::of($movimientos_trans)
                        ->addColumn('action', function ($movimientos_trans)
                        {
                            $botones = '<a href="' . url('movimientos_transactions/' . $movimientos_trans->id . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';

                            $botones .= '<form action="' . url('movimientos_transactions/' . $movimientos_trans->id) . '" id="borra_Frm' . $movimientos_trans->id . '" method="POST" class="pull-left">' . csrf_field() . ' ' . method_field('DELETE') . '<button type="button" onclick="confirmaDel(' . $movimientos_trans->id . ',\'' . $movimientos_trans->account_number . '\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';

                            return $botones;
                        })
                        ->editColumn('monto', function($movimientos_trans){
                            return number_format($movimientos_trans->monto, 4, '.', ',');
                        })                        
                        ->editColumn('created_at', function ($movimientos_trans)
                        {
                            return $movimientos_trans->created_at->format('d/m/Y H:i');
                        })
                        ->editColumn('fecha_transaccion', function ($movimientos_trans)
                        {
                            return Carbon::parse($movimientos_trans->fecha_transaccion)->format('d/m/Y');
                        })
                        ->editColumn('fecha_valor', function ($movimientos_trans)
                        {
                            return Carbon::parse($movimientos_trans->fecha_valor)->format('d/m/Y');
                        })
                        ->filterColumn('client_name', function($query, $keyword)
                        {
                            return $query->whereRaw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) like "' . '%' . $keyword . '%"');
                        })
                        ->filterColumn('account_number', function($query, $keyword)
                        {
                            return $query->where('accounts.account_number', 'like', '%' . $keyword . '%');
                        })
                        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $account_id = $request->has('account_id') ? $request->account_id : '';
        $lstMenus   = Util::generateMenu(auth()->user()->perfil_id);
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();

        $accounts = Account::select('id', 'account_number')
                                ->whereIn('broker_id', $assigned_brokers_id)
                                ->orderBy('account_number')
                                ->get();
        return view('catalogos.movimientos_transactions.index')->with('elmenu', ['elmenu' => $lstMenus])->with('accounts', $accounts)->with('account_id', $account_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_lang = HelperUtil::get_currentlang();

        $instruments       = Instrument::where('active', 1)->orderBy('instrument_' . $current_lang)->pluck('instrument_' . $current_lang, 'id')->toArray();
        $movimientos_tipos = MovimientosTipo::orderBy('type_' . $current_lang)->pluck('type_' . $current_lang, 'id')->toArray();
        //$movimientos_desc  = MovimientosDescripcion::orderBy('description_' . $current_lang)->pluck('description_' . $current_lang, 'id')->toArray();
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();
        
        $accounts = Account::select('id', 'account_number')
                                ->whereIn('broker_id', $assigned_brokers_id)
                                ->orderBy('account_number')
                                ->get();

        /*
        
        $last_transaction = MovimientosTransaction::select('id', 'ticket')->orderBy('created_at', 'desc')->first();
        
        $token_number = env('TICKET_START_POINT_MOVEMENT', '20000017');

        if ($last_transaction && $last_transaction->ticket)
        {
            $next_token_number = sprintf("%08d", $last_transaction->ticket + env('TICKET_INCREMENT_FACTOR', 17));
            $already_exists    = MovimientosTransaction::select('id')->where('ticket', $next_token_number)->first();

            if ($already_exists)
            {
                $token_number = Util::nextAvailableTicketNumberMovements($next_token_number);
            }
            else
            {
                $token_number = $next_token_number;
            }
        }
        */
        $ticket_counter = \App\Models\TicketCounter::select('counter')->find(1);
        $token_number = Util::nextTicketNumber($ticket_counter->counter + 17, 0);

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.movimientos_transactions.new')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('movimientos_tipos', $movimientos_tipos)
                        //->with('movimientos_desc', $movimientos_desc)
                        ->with('accounts', $accounts)
                        ->with('token_number', $token_number)
                        ->with('instruments', $instruments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $campos = $request->all();

        $rules     = array(
            'account'                 => 'required',
            'monto'                   => 'required',
            'fecha_transaccion'       => 'required',
            'fecha_valor'             => 'required',
            'instrument'              => 'required',
            'movimientos_tipo'        => 'required',
            'movimientos_descripcion' => 'required',
        );
        $messages  = array(
            'account.required'                 => __('sistema.movimientos_transaction.req_account_number'),
            'monto.required'                   => __('sistema.movimientos_transaction.req_monto'),
            'fecha_transaccion.required'       => __('sistema.movimientos_transaction.req_fecha_transaccion'),
            'fecha_valor.required'             => __('sistema.movimientos_transaction.req_fecha_valor'),
            'instrument.required'              => __('sistema.movimientos_transaction.req_instrument'),
            'movimientos_tipo.required'        => __('sistema.movimientos_transaction.req_movimientos_tipo'),
            'movimientos_descripcion.required' => __('sistema.movimientos_transaction.req_movimientos_descripcion'),
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
        {
            return redirect('movimientos_transactions/create')->withInput()->withErrors($validator);
        }
        else
        {

            $ticket_counter = \App\Models\TicketCounter::select('counter')->find(1);
            $next_id = Util::nextTicketNumber($ticket_counter->counter + 17, 0);

            if (isset($campos['ticket']))
            {

                $ticket_number = $campos['ticket'];                
                $exist = Util::checkTicketNumber($campos['ticket'],0,'MovimientosTransaction');

                if($exist == 1)
                {
                    $next_id = Util::nextTicketNumber($campos['ticket'],0);
                    //DB::commit();
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
            /*
            if (isset($campos['ticket']))
            {
                $ticket_number = $campos['ticket'];
                if ($ticket_number != '')
                {
                    $already_exists = MovimientosTransaction::select('id')->where('ticket', $ticket_number)->first();

                    if ($already_exists)
                    {
                        $next_id = Util::nextAvailableTicketNumberMovements($campos['ticket']);
                        return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                    }
                }
            }
            else
            {
                $last_transaction = MovimientosTransaction::select('id', 'ticket')->orderBy('created_at', 'desc')->first();

                if ($last_transaction && $last_transaction->ticket)
                {
                    $next_token_number = sprintf("%08d", $last_transaction->ticket + env('TICKET_INCREMENT_FACTOR', 17));
                    $already_exists    = MovimientosTransaction::select('id')->where('ticket', $next_token_number)->first();

                    if ($already_exists)
                    {
                        $ticket_number = Util::nextAvailableTicketNumberMovements($next_token_number);
                    }
                }
                else
                {
                    $ticket_number = env('TICKET_START_POINT_MOVEMENT', '00000017');
                }
            } */

            // Save MovimientosTransaction
            $movimientos_trans = new MovimientosTransaction;
            $movimientos_trans->fill($campos);

            $movimientos_trans->ticket                  = $ticket_number;
            $movimientos_trans->account_id              = $campos['account'];
            $movimientos_trans->monto                   = str_replace(',', '', $campos['monto']);
            $movimientos_trans->instrument_id           = $campos['instrument'];
            $movimientos_trans->fecha_transaccion       = Carbon::createFromFormat('d/m/Y', $campos['fecha_transaccion'])->format('Y-m-d');
            $movimientos_trans->fecha_valor             = Carbon::createFromFormat('d/m/Y', $campos['fecha_valor'])->format('Y-m-d');
            $movimientos_trans->movimientos_descripcion = $campos['movimientos_descripcion'];
            $movimientos_trans->movimientos_tipo_id     = $campos['movimientos_tipo'];
            $movimientos_trans->operation_category      = isset($campos['operation_category']) ? $campos['operation_category'] : 0;
            $movimientos_trans->reference_ticket        = '';
            if(isset($campos['reference_ticket']) && $campos['reference_ticket'] != '')
            {
                $movement_exists = MovimientosTransaction::where(['ticket' => $campos['reference_ticket'], 'account_id' => $campos['account']])->first();
                if($movement_exists)
                {
                    $movimientos_trans->reference_ticket = $campos['reference_ticket'];
                }
            }
            
            if ($movimientos_trans->save())
            {
                return redirect('movimientos_transactions')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
            }
            else
            {
                return redirect('movimientos_transactions')->with('msg', __('sistema.save_fail_msg'))->with('type', 'error');
            }
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
        $current_lang = HelperUtil::get_currentlang();

        $instruments       = Instrument::where('active', 1)->orderBy('instrument_' . $current_lang)->pluck('instrument_' . $current_lang, 'id')->toArray();
        $movimientos_tipos = MovimientosTipo::orderBy('type_' . $current_lang)->pluck('type_' . $current_lang, 'id')->toArray();
        //$movimientos_desc  = MovimientosDescripcion::orderBy('description_' . $current_lang)->pluck('description_' . $current_lang, 'id')->toArray();
        $accounts          = Account::select('id', 'account_number')->orderBy('account_number')->get();
        $movimientos_trans = MovimientosTransaction::find($id);

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.movimientos_transactions.edit')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('movimientos_tipos', $movimientos_tipos)
                        //->with('movimientos_desc', $movimientos_desc)
                        ->with('accounts', $accounts)
                        ->with('instruments', $instruments)
                        ->with('movimientos_trans', $movimientos_trans);
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

        $rules     = array(
            'account'                 => 'required',
            'monto'                   => 'required',
            'fecha_transaccion'       => 'required',
            'fecha_valor'             => 'required',
            'instrument'              => 'required',
            'movimientos_tipo'        => 'required',
            'movimientos_descripcion' => 'required',
        );
        $messages  = array(
            'account.required'                 => __('sistema.movimientos_transaction.req_account_number'),
            'monto.required'                   => __('sistema.movimientos_transaction.req_monto'),
            'fecha_transaccion.required'       => __('sistema.movimientos_transaction.req_fecha_transaccion'),
            'fecha_valor.required'             => __('sistema.movimientos_transaction.req_fecha_valor'),
            'instrument.required'              => __('sistema.movimientos_transaction.req_instrument'),
            'movimientos_tipo.required'        => __('sistema.movimientos_transaction.req_movimientos_tipo'),
            'movimientos_descripcion.required' => __('sistema.movimientos_transaction.req_movimientos_descripcion'),
        );
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails())
        {
            return redirect('movimientos_transactions/' . $id . '/edit')->withInput()->withErrors($validator);
        }
        else
        {

            // Update MovimientosTransaction
            $movimientos_trans = MovimientosTransaction::find($id);

            if (!$movimientos_trans)
            {
                abort(404);
            }

            if ($campos['ticket'] != $movimientos_trans->ticket)
            {
                $exist = Util::checkTicketNumber($campos['ticket'],$movimientos_trans->id,'MovimientosTransaction');

                if($exist == 1)
                {
                    //$ticket_counter = \App\Models\TicketCounter::select('counter')->find(1);
                    $next_id = Util::nextTicketNumber($campos['ticket'],0);
                
                    //DB::rollback();
                    return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                }
            }

            /*if ($campos['ticket'] != $movimientos_trans->ticket)
            {
                $already_exists = MovimientosTransaction::select('id')->where('id', '<>', $movimientos_trans->id)
                                ->where('ticket', $campos['ticket'])->first();

                if ($already_exists)
                {
                    $next_id = Util::nextAvailableTicketNumberMovements($campos['ticket']);
                    return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                }
            }*/

            $movimientos_trans->fill($campos);

            $movimientos_trans->account_id              = $campos['account'];
            $movimientos_trans->monto                   = str_replace(',', '', $campos['monto']);
            $movimientos_trans->instrument_id           = $campos['instrument'];
            $movimientos_trans->fecha_transaccion       = Carbon::createFromFormat('d/m/Y', $campos['fecha_transaccion'])->format('Y-m-d');
            $movimientos_trans->fecha_valor             = Carbon::createFromFormat('d/m/Y', $campos['fecha_valor'])->format('Y-m-d');
            $movimientos_trans->movimientos_descripcion = $campos['movimientos_descripcion'];
            $movimientos_trans->movimientos_tipo_id     = $campos['movimientos_tipo'];
            $movimientos_trans->operation_category      = isset($campos['operation_category']) ? $campos['operation_category'] : 0;
            
            if ($movimientos_trans->save())
            {
                return redirect('movimientos_transactions')->with('msg', __('sistema.update_success_msg'))->with('type', 'success');
            }
            else
            {
                return redirect('movimientos_transactions')->with('msg', __('sistema.update_fail_msg'))->with('type', 'success');
            }
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
        MovimientosTransaction::find($id)->delete();
        return redirect('movimientos_transactions')->with('msg', __('sistema.remove_success_msg'))->with('type', 'success');
    }

    public function check_ticket_info(Request $request)
    {
        $ref_ticket = $request->has('ref') ? $request->ref : '';
        $account_id = $request->has('account_id') ? $request->account_id : '';

        if ($ref_ticket != '' && $account_id != '')
        {
            $movement_exists = MovimientosTransaction::where(['ticket' => $ref_ticket, 'account_id' => $account_id])->first();
            if (!$movement_exists)
            {
                return response()->json(['flag' => 0, 'message' => __('sistema.movimientos_transaction.ref_ticket_not_found')], 200);
            }
            
            $all_other_credits = MovimientosTransaction::where('reference_ticket', $ref_ticket)                    
                    ->where('movimientos_transactions.operation_category', 1)                    
                    ->sum('monto');
            
            $all_debits = MovimientosTransaction::where('reference_ticket', $ref_ticket)                    
                    ->where('movimientos_transactions.operation_category', 0)                    
                    ->sum('monto');

            $all_credits = $movement_exists->monto + $all_other_credits;
            
            return response()->json(['flag' => 1, 'data' => ['all_credit' => number_format($all_credits, 2, '.', ''), 'all_debits' => number_format($all_debits, 2, '.', ''), 'balance' => number_format(($all_credits - $all_debits), 2, '.', '')]], 200);
        }
        else
        {
            return response()->json(['flag' => 0, 'message' => __('sistema.movimientos_transaction.ref_ticket_not_found')], 200);
        }
    }
}

<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransactionType;
use App\Models\Item;
use App\Models\Instrument;
use App\Models\Leverage;
use App\Models\CommissionFee;
use App\Models\Account;
use App\Models\AccountTransaction;
use Yajra\DataTables\Facades\DataTables;
use App\Support\Util;
use App\Util\HelperUtil;
use Validator;
use Carbon\Carbon;
use DB;

class TransactionController extends Controller
{
    /*
     * Constructor de la clase que instancia el middleware auth
     */
    /* public function __construct()
      {
      $this->middleware('auth');
      $this->middleware('seguridad')->only('index');
      } */

    //Funcion para DataTable
    public function dataaaccounttransactions(Request $request, $id = null)
    {

        $account_id = $request->has('account_id') ? $request->account_id : null;
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();
        $broker_id = $request->has('broker_id') ? $request->broker_id : '';

        if ($id)
        {
            $account_id = HelperUtil::decode($id);
        }

        $account_transaction = AccountTransaction::select('account_transactions.*', 'accounts.account_number', DB::raw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) as client_name'))
                ->leftJoin('accounts', 'accounts.id', '=', 'account_transactions.account_id')
                ->leftJoin('account_clients', 'account_clients.account_id', '=', 'account_transactions.account_id')
                ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                ->groupBy('account_transactions.id');

        if ($account_id)
        {
            $account_transaction->where('account_transactions.account_id', $account_id);
        }
        
        if($broker_id == '')
        {            
            $account_transaction->whereIn('accounts.broker_id', $assigned_brokers_id);
        }
        else
        {
            if(in_array($broker_id, $assigned_brokers_id))
            {
                $account_transaction->where('accounts.broker_id', $broker_id);
            }
            else
            {
                $account_transaction->where('accounts.broker_id', null);
            }
        }        
        
        return DataTables::of($account_transaction)
                        ->addColumn('action', function ($account_transaction)
                        {

                            $botones = '<a href="' . url('transactions/' . HelperUtil::encode($account_transaction->id) . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';

                            $botones .= '<form action="' . url('transactions/' . $account_transaction->id) . '" id="borra_Frm' . $account_transaction->id . '" method="POST" class="pull-left">' . csrf_field() . ' ' . method_field('DELETE') . '<button type="button" onclick="confirmaDel(' . $account_transaction->id . ',\'' . $account_transaction->ticket . '\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>';

                            return $botones;
                        })
                        ->editColumn('created_at', function ($account_transaction)
                        {
                            return $account_transaction->created_at->format('d/m/Y H:i');
                        })
                        ->editColumn('opening_date', function ($account_transaction)
                        {
                            return Carbon::parse($account_transaction->opening_date)->format('d/m/Y');
                        })
                        ->editColumn('closing_date', function ($account_transaction)
                        {
                            return Carbon::parse($account_transaction->closing_date)->format('d/m/Y');
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
        $lstMenus = Util::generateMenu($user->perfil_id);
        $assigned_brokers_id = collect($user->assigned_brokers)->pluck('id')->toArray();
        
        $accounts = Account::select('id', 'account_number')
                                ->whereIn('broker_id', $assigned_brokers_id)
                                ->orderBy('account_number')
                                ->get();

        return view('catalogos.transactions.index')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('accounts', $accounts);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function account_transactions_list($id)
    {
        $decoded_id = HelperUtil::decode($id);
        $account    = Account::find($decoded_id);

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('catalogos.transactions.index')
                        ->with('account', $account)
                        ->with('account_id', $id)
                        ->with('elmenu', ['elmenu' => $lstMenus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        $lstMenus = Util::generateMenu($user->perfil_id);


        $current_lang      = HelperUtil::get_currentlang();
        $assigned_brokers_id = collect($user->assigned_brokers)->pluck('id')->toArray();
        
        $accounts = Account::select('id', 'account_number')->whereIn('broker_id', $assigned_brokers_id)->orderBy('account_number')->get();
        $items             = Item::where('active', 1)->orderBy('item_' . $current_lang)->pluck('item_' . $current_lang, 'id')->toArray();
        $instruments       = Instrument::where('active', 1)->orderBy('instrument_' . $current_lang)->pluck('instrument_' . $current_lang, 'id')->toArray();
        $leverages         = Leverage::orderBy('label')->pluck('label', 'id')->toArray();
        $transaction_types = TransactionType::orderBy('type_' . $current_lang)->pluck('type_' . $current_lang, 'id')->toArray();
        // $transaction_types = TransactionType::orderBy('type_en')->pluck('type_en', 'id')->toArray();
        $commission_fees   = CommissionFee::orderBy('commission_fee')->where('active', 1)->pluck('commission_fee', 'id')->toArray();
    

        /* Generate token/ticket numebr */
        $ticket_counter = \App\Models\TicketCounter::select('counter')->find(1);
        $token_number = Util::nextTicketNumber($ticket_counter->counter + 17,0);


        /* Generate token/ticket numebr */
        /*$last_transaction = AccountTransaction::select('id', 'ticket')->orderBy('created_at', 'desc')->first();

        if ($last_transaction)
        {
            $next_token_number = sprintf("%08d", $last_transaction->ticket + env('TICKET_INCREMENT_FACTOR', 17));
            $already_exists    = AccountTransaction::select('id')->where('ticket', $next_token_number)->first();

            if ($already_exists)
            {
                $token_number = Util::nextAvailableTicketNumber($next_token_number);
            }
            else
            {
                $token_number = $next_token_number;
            }
        }
        else
        {
            $token_number = env('TICKET_START_POINT', '00000017');
        } */

        return view('catalogos.transactions.create')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('accounts', $accounts)
                        ->with('items', $items)
                        ->with('instruments', $instruments)
                        ->with('token_number', $token_number)
                        ->with('leverages', $leverages)
                        ->with('commission_fees', $commission_fees)
                        ->with('transaction_types', $transaction_types);
    }

    public function create_transaction($id)
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);

        $decoded_id = HelperUtil::decode($id);
        $account    = Account::find($decoded_id);

        $current_lang = HelperUtil::get_currentlang();

        $items             = Item::where('active', 1)->orderBy('item_' . $current_lang)->pluck('item_' . $current_lang, 'id')->toArray();
        $instruments       = Instrument::where('active', 1)->orderBy('instrument_' . $current_lang)->pluck('instrument_' . $current_lang, 'id')->toArray();
        $leverages         = Leverage::orderBy('label')->pluck('label', 'id')->toArray();
        $transaction_types = TransactionType::orderBy('type_' . $current_lang)->pluck('type_' . $current_lang, 'id')->toArray();
        $commission_fees   = CommissionFee::orderBy('commission_fee')->where('active', 1)->pluck('commission_fee', 'id')->toArray();

        return view('catalogos.transactions.new')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('account_id', $id)
                        ->with('account', $account)
                        ->with('items', $items)
                        ->with('instruments', $instruments)
                        ->with('leverages', $leverages)
                        ->with('commission_fees', $commission_fees)
                        ->with('transaction_types', $transaction_types);
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


        try
        {
            DB::beginTransaction();
            $account_transaction = new AccountTransaction;

            //$account = Account::where('account_number',$campos['account_number'])->first();
            $account = Account::where('id', $campos['account_number'])->first();

            $previous_transaction = AccountTransaction::where('account_id', $account->id)->orderBy('created_at', 'desc')->first();

            $account_transaction->account_id          = $account->id;
            $account_transaction->transaction_type_id = $campos['type'];
            $account_transaction->instrument_id       = $campos['instrument'];
            $account_transaction->item_id             = $campos['item'];
            //$account_transaction->initial_capital = str_replace( ',', '', $campos['initial_capital']);
            $account_transaction->initial_capital     = $previous_transaction ? $previous_transaction->final_capital_client : $account->opening_amount;

            $ticket_counter = \App\Models\TicketCounter::select('counter')->find(1);
            $next_id = Util::nextTicketNumber($ticket_counter->counter + 17,0);

            if (isset($campos['ticket']))
            {

                $ticket_number = $campos['ticket'];

                $exist = Util::checkTicketNumber($campos['ticket'],0,'AccountTransaction');

                if($exist == 1)
                {
                    $next_id = Util::nextTicketNumber($campos['ticket'],0);

                    DB::rollback();
                    
                    return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                }
            }else{
                
                $ticket_number = $next_id;
            }

            //dd($ticket_number,$next_id);
/*
            if (isset($campos['ticket']))
            {

                $ticket_number = $campos['ticket'];

                $exist = Util::checkTicketNumber($campos['ticket'],0,'AccountTransaction');

                if($exist == 1)
                {
                    DB::rollback();
                    
                    return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                }


                $ticket_number = $campos['ticket'];
                if ($ticket_number != '')
                {
                    $already_exists = AccountTransaction::select('id')->where('ticket', $ticket_number)->first();



                    if ($already_exists)
                    {
                        $next_id = Util::nextAvailableTicketNumber($campos['ticket']);
                        DB::rollback();
                        return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                    }
                } 
            }
            else
            {
                //$last_transaction = AccountTransaction::select('id', 'ticket')->orderBy('created_at', 'desc')->first();

                $ticket_number = $next_id;

                //$last_transaction = AccountTransaction::max('ticket');
                if ($last_transaction)
                {
                    $next_token_number = sprintf("%08d", $last_transaction->ticket + env('TICKET_INCREMENT_FACTOR', 17));
                    $already_exists    = AccountTransaction::select('id')->where('ticket', $next_token_number)->first();

                    if ($already_exists)
                    {
                        $ticket_number = Util::nextAvailableTicketNumber($next_token_number);
                    }
                }
                else
                {
                    $ticket_number = env('TICKET_START_POINT', '00000017');
                }
            } */

            if($next_id == $ticket_number)
            {
                \App\Models\TicketCounter::where('id',1)->update(['counter' => DB::raw('counter + 17')]);

            }


            $account_transaction->ticket               = $ticket_number;
            $account_transaction->opening_date         = Carbon::createFromFormat('d/m/Y', $campos['opening_date'])->format('Y-m-d');
            $account_transaction->closing_date         = Carbon::createFromFormat('d/m/Y', $campos['closing_date'])->format('Y-m-d');
            $account_transaction->opening_time         = $campos['opening_time'];
            $account_transaction->closing_time         = $campos['closing_time'];
            $account_transaction->opening_price        = str_replace(',', '', $campos['opening_price']);
            $account_transaction->closing_price        = str_replace(',', '', $campos['closing_price']);
            $account_transaction->conversion_opening   = str_replace(',', '', $campos['conversion_opening']);
            $account_transaction->conversion_closing   = str_replace(',', '', $campos['conversion_closing']);
            $account_transaction->leverage_id          = $campos['leverage'];
            $account_transaction->spread               = str_replace(',', '', $campos['spread']);
            $account_transaction->financial_exhibition = str_replace(',', '', $campos['financial_exhibition']);
            $account_transaction->commission_fee_id    = str_replace(',', '', $campos['commission_fee']);
            $account_transaction->stop_loss            = str_replace(',', '', $campos['stop_loss']);
            $account_transaction->commission           = str_replace(',', '', $campos['commission']);
            $account_transaction->contracts            = str_replace(',', '', $campos['contracts']);
            $account_transaction->gross_profit         = str_replace(',', '', $campos['gross_profit']);
            $account_transaction->facial_value         = str_replace(',', '', $campos['facial_value']);
            $account_transaction->net_result           = str_replace(',', '', $campos['net_result']);
            $account_transaction->warranty             = str_replace(',', '', $campos['warranty']);
//            $account_transaction->final_capital_client = str_replace( ',', '', $campos['final_capital_client']);
            $account_transaction->final_capital_client = $account_transaction->initial_capital + ($account_transaction->net_result);

            $account_transaction->save();
            DB::commit();
            //$encoded_id = HelperUtil::encode($account->id);
            return redirect('transactions')->with('msg', __('sistema.save_success_msg'))->with('type', 'success');
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

        $decoded_id  = HelperUtil::decode($id);
        $transaction = AccountTransaction::find($decoded_id);
        $account     = Account::find($transaction->account_id);

        $current_lang = HelperUtil::get_currentlang();

        $items               = Item::where('active', 1)->pluck('item_' . $current_lang, 'id')->toArray();
        $instruments         = Instrument::where('active', 1)->pluck('instrument_' . $current_lang, 'id')->toArray();
        $leverages           = Leverage::pluck('label', 'id')->toArray();
        $leverage_calc_value = Leverage::find($transaction->leverage_id);
        $transaction_types = TransactionType::orderBy('type_' . $current_lang)->pluck('type_' . $current_lang, 'id')->toArray();
        // $transaction_types   = TransactionType::orderBy('type_en')->pluck('type_en', 'id')->toArray();
        $commission_fees     = CommissionFee::where('active', 1)->pluck('commission_fee', 'id')->toArray();

        return view('catalogos.transactions.edit')
                        ->with('elmenu', ['elmenu' => $lstMenus])
                        ->with('account_id', HelperUtil::encode($account->id))
                        ->with('account', $account)
                        ->with('transaction', $transaction)
                        ->with('items', $items)
                        ->with('instruments', $instruments)
                        ->with('leverages', $leverages)
                        ->with('leverage_calc_value', $leverage_calc_value)
                        ->with('commission_fees', $commission_fees)
                        ->with('transaction_types', $transaction_types);
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
            $account_transaction = AccountTransaction::find($id);
            $account             = Account::where('account_number', $campos['account_number'])->first();

            //$account_transaction->account_id = $account->id;
            $account_transaction->transaction_type_id = $campos['type'];
            $account_transaction->instrument_id       = $campos['instrument'];
            $account_transaction->item_id             = $campos['item'];
//            $account_transaction->initial_capital = 0;
            //str_replace( ',', '', $campos['initial_capital']);
            if ($campos['ticket'] != $account_transaction->ticket)
            {
                $exist = Util::checkTicketNumber($campos['ticket'],$account_transaction->id,'AccountTransaction');

                if($exist == 1)
                {

                    //$ticket_counter = \App\Models\TicketCounter::select('counter')->find(1);
                    $next_id = Util::nextTicketNumber($campos['ticket'],0);
                
                    DB::commit();
                    return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                }
                /*
                $already_exists = AccountTransaction::select('id')->where('id', '<>', $account_transaction->id)
                                ->where('ticket', $campos['ticket'])->first();

                if ($already_exists)
                {
                    $next_id = Util::nextAvailableTicketNumber($campos['ticket']);
                    DB::rollback();
                    return redirect()->back()->withErrors(__('sistema.transaction.duplicate_ticket') . __('sistema.transaction.next_ticket', ['next' => $next_id]) . __('sistema.transaction.accept_btn_html', ['btn_id' => $next_id]))->withInput();
                }
                */
            }
            $account_transaction->ticket               = $campos['ticket'];
            $account_transaction->opening_date         = Carbon::createFromFormat('d/m/Y', $campos['opening_date'])->format('Y-m-d');
            $account_transaction->closing_date         = Carbon::createFromFormat('d/m/Y', $campos['closing_date'])->format('Y-m-d');
            $account_transaction->opening_time         = $campos['opening_time'];
            $account_transaction->closing_time         = $campos['closing_time'];
            $account_transaction->opening_price        = str_replace(',', '', $campos['opening_price']);
            $account_transaction->closing_price        = str_replace(',', '', $campos['closing_price']);
            $account_transaction->conversion_opening   = str_replace(',', '', $campos['conversion_opening']);
            $account_transaction->conversion_closing   = str_replace(',', '', $campos['conversion_closing']);
            $account_transaction->leverage_id          = $campos['leverage'];
            $account_transaction->spread               = str_replace(',', '', $campos['spread']);
            $account_transaction->financial_exhibition = str_replace(',', '', $campos['financial_exhibition']);
            $account_transaction->commission_fee_id    = str_replace(',', '', $campos['commission_fee']);
            $account_transaction->stop_loss            = str_replace(',', '', $campos['stop_loss']);
            $account_transaction->commission           = str_replace(',', '', $campos['commission']);
            $account_transaction->contracts            = str_replace(',', '', $campos['contracts']);
            $account_transaction->gross_profit         = str_replace(',', '', $campos['gross_profit']);
            $account_transaction->facial_value         = str_replace(',', '', $campos['facial_value']);
            $account_transaction->net_result           = str_replace(',', '', $campos['net_result']);
            $account_transaction->warranty             = str_replace(',', '', $campos['warranty']);
            $account_transaction->final_capital_client = $account_transaction->initial_capital + ($account_transaction->net_result);
            //str_replace( ',', '', $campos['final_capital_client']);

            $account_transaction->save();

            DB::commit();

//            $encoded_id = HelperUtil::encode($account->id);
//            return redirect('account_transactions/'.$encoded_id)->with('msg',__('sistema.update_success_msg'))->with('type','success');
            return redirect('transactions')->with('msg', __('sistema.update_success_msg'))->with('type', 'success');
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage())->withInput();
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
        $account_transaction = AccountTransaction::find($id);
//        $account_id = $account_transaction->account_id;
//        $encoded_id = HelperUtil::encode($account_id);
        $account_transaction->delete();
//        return redirect('account_transactions/'.$encoded_id)->with('msg',__('sistema.remove_success_msg'))->with('type','success');
        return redirect('transactions')->with('msg', __('sistema.remove_success_msg'))->with('type', 'success');
    }

}

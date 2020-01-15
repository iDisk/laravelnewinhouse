<?php

namespace App\Http\Controllers;

use App\Support\Util;
use App\Models\Account;
use App\Models\UserActionLog;
use Illuminate\Http\Request;

class UserActionLogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('seguridad')->only('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lstMenus   = Util::generateMenu(auth()->user()->perfil_id);
        $start_date = $request->has('from_date') ? $request->from_date : date('Y-m-d');
        $upto_date  = $request->has('upto_date') ? $request->upto_date : date('Y-m-d');
        $broker_id = $request->has('broker_id') ? $request->broker_id : '';
        //dd($request->all(), $start_date, $upto_date, 'asd');
        if($broker_id == '')
        {
            $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();
        }
        else
        {
            $assigned_brokers_id = [$broker_id];
        }
        
        $accounts = Account::select('accounts.id', 'accounts.account_number', 'clients.user_id')
                                ->leftJoin('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                                ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                                ->whereIn('accounts.broker_id', $assigned_brokers_id)
                                ->groupBy('accounts.id')
                                ->orderBy('account_number')
                                ->get();
        
        $user_ids = $accounts->pluck('user_id')->toArray();
        
        $today_history = UserActionLog::whereIn('user_id', $user_ids)
                ->whereBetween('created_at', [$start_date . ' 00:00:00', $upto_date . ' 23:59:59'])
                ->orderBy('created_at', 'desc')
                ->get();
        
        $history_arr   = [];

        if (count($today_history) > 0)
        {
            foreach ($today_history as $history)
            {
                $history_arr[$history->created_at->format('d-m-Y')][] = $history;
            }
        }
        
        //dd($start_date, $upto_date);
        
        return view('timeline')
                ->with('elmenu', ['elmenu' => $lstMenus])
                ->with('history', $history_arr)
                ->with('broker_selected_id', $broker_id)
                ->with('start_date', $start_date)
                ->with('upto_date', $upto_date);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserActionLog $userActionLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function edit(UserActionLog $userActionLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserActionLog $userActionLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserActionLog $userActionLog)
    {
        //
    }

}

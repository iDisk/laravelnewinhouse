<?php

namespace App\Http\Controllers\Web;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::select('id', 'account_number')->orderBy('account_number')->get();
        $view     = \View::make('reports.trade.partial.send', compact('accounts'));
        return response()->json(['flag' => 1, 'data' => $view->render()], 200);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Account $account)
    {
        return response()->json($account, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function check_trade_investment($account_id,$instrument_id)
    {
        try
        {
            $trade_investment = \App\Models\TradeInvestment::where(['account_id' => $account_id, 'is_opening' => 1,'instrument_id' => $instrument_id])->first();
            if ($trade_investment)
            {
                return response()->json(['flag' => 1, 'message' => 'success', 'data' => 0, 'mindate' => $trade_investment->fecha], 200);
            }
            else
            {
                return response()->json(['flag' => 1, 'message' => 'success', 'data' => 1, 'mindate' => date('Y-m-d')], 200);
            }
        }
        catch (\Exception $ex)
        {
            return response()->json(['flag' => 0, 'message' => $ex->getMessage()], 200);
        }
    }

}

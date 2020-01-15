<?php

namespace App\Http\Controllers\UserWeb;

use DB;
use Validator;
use Dompdf\Dompdf;
use App\Models\Account;
use App\Util\HelperUtil;
use Illuminate\Http\Request;
use App\Models\AccountTransaction;
use App\Models\MovimientosTransaction;
use App\Http\Controllers\Controller;

class StatementController extends Controller
{

    public function download_statement_pdf(Request $request)
    {
        try
        {
            $campos = $request->all();

            $rules    = array(
                'account_id' => 'required',
                'from_date'  => 'required',
                'upto_date'  => 'required',
            );
            $messages = array(
                'account_id.required' => __('frontsistema.estado_de_cuenta.required.account_id'),
                'from_date.required'  => __('frontsistema.estado_de_cuenta.required.from_date'),
                'upto_date.required'  => __('frontsistema.estado_de_cuenta.required.upto_date')
            );

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails())
            {
                return redirect()->back()->withInput()->withErrors($validator);
            }
            else
            {
                $account = Account::find($campos['account_id']);

                if ($account->primary_client->user_id != auth()->user()->id)
                {
                    return redirect()->back()->withInput()->with('error', __('frontsistema.estado_de_cuenta.invalid_request'))->with('type', 'error');
                }

                $from_date = isset($campos['from_date']) ?
                    (date_format(date_create_from_format('d/m/Y', $campos['from_date']), 'Y-m-d') . ' 00:00:00') :
                    (date('Y-m-d', strtotime('-1 month')) . ' 00:00:00');
                
                $upto_date = isset($campos['upto_date']) ?
                    (date_format(date_create_from_format('d/m/Y', $campos['upto_date']), 'Y-m-d') . ' 23:59:59') :
                    (date('Y-m-d') . ' 23:59:59');
                
                return HelperUtil::generate_statement($account, $from_date, $upto_date, false, true);
            }
        }
        catch (\Exception $ex)
        {
            dd($ex->getMessage());
            return redirect()->back()->withInput()->with('error', $ex->getMessage())->with('type', 'error');
        }
    }

}

<?php

namespace App\Http\Controllers\Web;

use DB;
use Mail;
use File;
use Dompdf\Dompdf;
use Carbon\Carbon;
use App\Support\Util;
use App\Models\Account;
use App\Util\HelperUtil;
use Illuminate\Http\Request;
use App\Models\AccountTransaction;
use App\Http\Controllers\Controller;
use App\Models\MovimientosTransaction;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('seguridad')->only('index');
    }

    public function show_trade_report()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);        
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();

        $accounts = Account::select('id', 'account_number')
                                ->whereIn('broker_id', $assigned_brokers_id)
                                ->orderBy('account_number')
                                ->get();        
        return view('reports.trade.index', compact('accounts'))
                        ->with('elmenu', ['elmenu' => $lstMenus]);
    }

    public function show_trade_report_history()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();

        $accounts = Account::select('id', 'account_number')
                                ->whereIn('broker_id', $assigned_brokers_id)
                                ->orderBy('account_number')
                                ->get();
        
        return view('reports.trade.history', compact('accounts'))
                        ->with('elmenu', ['elmenu' => $lstMenus]);
    }

    public function generate_trade_report_old(Request $request)
    {
        try
        {
            $campos  = $request->all();
            $account = \App\Models\Account::find($campos['account_select']);

            $from_date = isset($campos['from_date']) ? ($campos['from_date'] . ' 00:00:00') : (date('Y-m-d', strtotime('-30 days')) . ' 00:00:00');
            $upto_date = isset($campos['upto_date']) ? ($campos['upto_date'] . ' 23:59:59') : (date('Y-m-d') . ' 23:59:59');

            /*
              $month = isset($campos['month']) ? sprintf("%02d", $campos['month']) : '01';
              $year  = isset($campos['year']) ? $campos['year'] : '2016';

              $start_date = "$year-$month-01 00:00:00";
              $upto_date  = date("Y-m-t", strtotime($start_date)) . ' 23:59:59';
             */
            $transactions = AccountTransaction::where('account_id', $account->id)
                            ->whereBetween('created_at', [$from_date, $upto_date])
                            ->orderBy('account_transactions.created_at')->get();
            //->whereRaw("YEAR(created_at) = $year AND MONTH(created_at) = $month ")->get();

            $first_transaction    = $transactions->first();
            $previous_transaction = null;
            if ($first_transaction)
            {
                $previous_transaction = AccountTransaction::where('id', '<', $first_transaction->id)->orderBy('id', 'desc')->first();
            }

            $moment_report = MovimientosTransaction::select(['movimientos_transactions.*', 'accounts.account_number',
                        'clients.first_name', 'clients.middle_name', 'clients.surname1', 'clients.surname2',
                        'movimientos_tipos.type_en', 'movimientos_tipos.type_es'])
                    ->whereBetween('movimientos_transactions.fecha_transaccion', [substr($from_date, 0, -9), substr($upto_date, 0, -9)])
                    ->leftJoin('accounts', 'accounts.id', '=', 'movimientos_transactions.account_id')
                    ->leftJoin('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                    ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                    ->join('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                    //->join('movimientos_descripcions', 'movimientos_descripcions.id', '=', 'movimientos_transactions.movimientos_descripcion_id')
                    ->where(['clients.client_type' => 1, 'movimientos_transactions.account_id' => $account->id])
                    ->orderBy('movimientos_transactions.fecha_transaccion')
                    ->get();

            $temp2 = DataTables::of($moment_report)
                    ->addColumn('client_name', function($equity_report)
                    {
                        return trim($equity_report->first_name . ' ' . $equity_report->middle_name . ' ' . $equity_report->surname1);
                    })
                    ->addColumn('deposits_amount', function($equity_report) use($from_date, $upto_date)
                    {
                        $deposit_amount = MovimientosTransaction::where('account_id', $equity_report->account_id)
                                ->whereIn('movimientos_tipo_id', [2])
                                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                                ->sum('monto');
                        return number_format($deposit_amount, 2, '.', '');
                    })
                    ->addColumn('withdrawals_amount', function($equity_report) use($from_date, $upto_date)
                    {
                        $withdrawals_amount = MovimientosTransaction::where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => 1])
                                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                                ->sum('monto');
                        return number_format($withdrawals_amount, 2, '.', '');
                    })
                    ->addColumn('commission_amount', function($equity_report) use($from_date, $upto_date)
                    {
                        $commission_amount = AccountTransaction::where(['account_id' => $equity_report->account_id])
                                ->whereBetween('created_at', [$from_date, $upto_date])
                                ->sum('commission');
                        return number_format($commission_amount, 2, '.', '');
                    })
                    ->addColumn('credit_amount', function($equity_report) use($from_date, $upto_date)
                    {
                        $deposit_amount = MovimientosTransaction::where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.credit_code')])
                                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                                ->sum('monto');
                        return number_format($deposit_amount, 2, '.', '');
                    })
                    ->addColumn('expenses_amount', function($equity_report) use($from_date, $upto_date)
                    {
                        $deposit_amount = MovimientosTransaction::where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.debit_code')])
                                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                                ->sum('monto');
                        return number_format($deposit_amount, 2, '.', '');
                    })
                    ->addColumn('profil_loss_amount', function($equity_report) use($from_date, $upto_date)
                    {
                        $pnl_amount = AccountTransaction::where(['account_id' => $equity_report->account_id])
                                ->whereBetween('created_at', [$from_date, $upto_date])
                                ->sum('gross_profit');
                        return number_format($pnl_amount, 2, '.', '');
                    })
                    ->make(true);

            $moment_report_data2 = json_decode($temp2->getContent(), true);

            $combos = [];

            if (!empty($transactions))
            {
                foreach ($transactions as $transaction)
                {
                    $timestamp             = strtotime($transaction->created_at);
                    $transaction->trs_type = 1;
                    if (array_key_exists($timestamp, $combos))
                    {
                        do
                        {
                            $timestamp = $timestamp + 1;
                        }
                        while (!array_key_exists($timestamp, $combos));
                    }
                    $combos[$timestamp] = $transaction;
                }
            }

            if (!empty($moment_report_data2['data']))
            {
                foreach ($moment_report_data2['data'] as $moment_data)
                {
                    $movement_date           = $moment_data['fecha_transaccion'] . substr($moment_data['created_at'], 10, 9);
                    $timestamp               = strtotime($movement_date);
                    $moment_data['trs_type'] = 2;
                    if (array_key_exists($timestamp, $combos))
                    {
                        do
                        {
                            $timestamp = $timestamp + 1;
                        }
                        while (!array_key_exists($timestamp, $combos));
                    }
                    $combos[$timestamp] = $moment_data;
                }
            }
            ksort($combos);

            $settings = \App\Models\Setting::where('broker_id', $account->broker_id)->first();

            $data = [
                'combos'               => array_values($combos),
                'transactions'         => $transactions,
                //'moment_report'        => isset($moment_report_data['data']) ? $moment_report_data['data'] : [],
                'moment_transaction'   => $moment_report_data2['data'],
                'account'              => $account,
                'info'                 => [
                    'from_date' => $from_date,
                    'upto_date' => $upto_date
                ],
                'previous_transaction' => $previous_transaction,
                'last_transaction'     => $transactions->last(),
                'settings'             => $settings
            ];

            $html   = \View::make('reports.trade.report', compact('data'));
            //die($html->render());
            //Extra start
            /*
              $pdf = \App::make('dompdf.wrapper');
              $pdf->loadHTML($html->render());
              $pdf->setPaper('A4', 'landscape');
              return $pdf->stream();
             */
            //Extra END
            // instantiate and use the dompdf class
            $dompdf = new Dompdf();
            $dompdf->set_option("isPhpEnabled", true);
            $dompdf->loadHtml($html->render());

            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

//            $font         = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
//            $dompdf->getCanvas()->page_text(770, 575, "Page: {PAGE_NUM} / {PAGE_COUNT}", $font, 8, array(0, 0, 0));

            $today     = date('Y_m_d');
            $file_name = 'statement_' . $account->account_number . '_' . date('Ymd', strtotime($from_date)) . '_' . date('Ymd', strtotime($upto_date)) . '.pdf';

            $folder_path = storage_path('trade_reports/temp/' . $today);
            File::makeDirectory($folder_path, 0777, true, true);

            $folder_path2 = storage_path('trade_reports/temp/' . $today . '/encrypted');
            File::makeDirectory($folder_path2, 0777, true, true);

            $file_to_save           = $folder_path . '/' . $file_name;
            $file_to_save_encrypted = $folder_path2 . '/' . $file_name;

            //save the pdf file on the server
            file_put_contents($file_to_save, $dompdf->output());
            $primary_client = $account->primary_client;

            $pdf_protection = $primary_client->dob ? (date('Ymd', strtotime($primary_client->dob))) : $account->account_number;

            $dompdf->getCanvas()->get_cpdf()->setEncryption($pdf_protection, '', []);
            file_put_contents($file_to_save_encrypted, $dompdf->output());

            /*
             * 
              $today            = date('Y_m_d');
              $file_name        = $account->account_number . '_trade_report_' . date('Y_m_d_h_i_s') . '.pdf';
              $folder_path      = storage_path('trade_reports/' . $today);
              File::makeDirectory($folder_path, 0777, true, true);
              $file_to_save     = $folder_path . '/' . $file_name;
              //save the pdf file on the server
              file_put_contents($file_to_save, $dompdf->output());
             * 
             */
            /*
              //Make record of this event
              $report_generated = \App\Models\StatementHistory::create([
              'type'         => 'trade',
              'account_id'   => $account->id,
              'file_path'    => 'trade_reports/' . $today . '/' . $file_name,
              'from_period'  => $from_date,
              'upto_period'  => $upto_date,
              'generated_by' => 'admin'
              ]);
              if ($report_generated)
              {
              return redirect('reporte/trade')->with('msg', __('sistema.trade_report.generate_success', ['period' => date('d/m/Y', strtotime($report_generated->from_period)) . " - " . date('d/m/Y', strtotime($report_generated->upto_period)), 'account' => $account->account_number]))->with('type', 'success');
              }
              else
              {
              return redirect('reporte/trade')->with('msg', 'Something went wrong.')->with('type', 'error');
              }
             */

            //print the pdf file to the screen for saving
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Type: application/force-download");
            header('Content-Disposition: attachment; filename=' . urlencode(basename($file_to_save)));
            // header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_to_save));
            ob_clean();
            flush();
            readfile($file_to_save);
            exit;
        }
        catch (\Exception $ex)
        {
            dd($ex->getMessage());
            return redirect()->back()->withInput()->with('type', 'error')->with('message', $ex->getMessage());
        }
    }

    public function generate_trade_report(Request $request)
    {
        try
        {
            $campos  = $request->all();
            $account = \App\Models\Account::find($campos['account_select']);
            $from_date = isset($campos['from_date']) ? ($campos['from_date'] . ' 00:00:00') : (date('Y-m-d', strtotime('-30 days')) . ' 00:00:00');
            $upto_date = isset($campos['upto_date']) ? ($campos['upto_date'] . ' 23:59:59') : (date('Y-m-d') . ' 23:59:59');            
            return HelperUtil::generate_statement($account, $from_date, $upto_date, false, true);
        }
        catch (\Exception $ex)
        {
            return redirect()->back()->withInput()->with('type', 'error')->with('message', $ex->getMessage());
        }
    }

    public function show_equity_report()
    {
        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('reports.equity.index')->with('elmenu', ['elmenu' => $lstMenus]);
    }

    public function data_equity_report(Request $request)
    {
        $equity_report = MovimientosTransaction::select(['movimientos_transactions.*', 'accounts.account_number',
                    'clients.first_name', 'clients.middle_name', 'clients.surname1', 'clients.surname2']);

        $from_date = $request->has('start_date') ? ($request->start_date . ' 00:00:00' ) : '2018-01-01 00:00:00';
        $upto_date = $request->has('end_date') ? ($request->end_date . ' 23:59:59' ) : date('Y-m-d H:i:s');

        $broker_id = $request->has('broker_id') ? $request->broker_id : '';
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();        
        
        $equity_report->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                ->leftJoin('accounts', 'accounts.id', '=', 'movimientos_transactions.account_id')
                ->leftJoin('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                ->where('clients.client_type', 1)
                ->groupBy('accounts.id');

        if($broker_id == '')
        {
            $equity_report->whereIn('accounts.broker_id', $assigned_brokers_id);
        }
        else
        {
            if(in_array($broker_id, $assigned_brokers_id))
            {
                $equity_report->where('accounts.broker_id', $broker_id);
            }
            else
            {
                $equity_report->where('accounts.broker_id', null);
            }
        }        
        
        $deposit_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 1)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $retiros_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 2)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $creditos_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 3)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $expenses_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 4)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $commission_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 5)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $pnl_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 6)
                ->pluck('movimientos_tipos.id')->toArray();
                
        return DataTables::of($equity_report)
                        ->addColumn('client_name', function($equity_report)
                        {
                            return trim($equity_report->first_name . ' ' . $equity_report->middle_name . ' ' . $equity_report->surname1);
                        })
                        ->addColumn('deposits_amount', function($equity_report) use($from_date, $upto_date, $deposit_type_ids)
                        {
                            $deposit_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                                    ->where('account_id', $equity_report->account_id)
                                    ->whereIn('movimientos_tipo_id', $deposit_type_ids)
                                    ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                                    ->first();

                            $total_deposit_amount = $deposit_amount_positive->total_amount;
                            return number_format($total_deposit_amount, 2, '.', '');
                        })
                        ->addColumn('withdrawals_amount', function($equity_report) use($from_date, $upto_date,$retiros_type_ids)
                        {
                            $withdrawals_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                                    ->where('account_id', $equity_report->account_id)
                                    ->whereIn('movimientos_tipo_id', $retiros_type_ids)
                                    ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                                    ->first();

                            $total_withdrawal_amount = $withdrawals_amount_positive->total_amount;
                            return number_format($total_withdrawal_amount, 2, '.', '');
                        })
                        ->addColumn('commission_amount', function($equity_report) use($from_date, $upto_date, $commission_type_ids)
                        {
                            $commission_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                                    ->where('account_id', $equity_report->account_id)
                                    ->whereIn('movimientos_tipo_id', $commission_type_ids)
                                    ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                                    ->first();

                            $commission_amount = $commission_amount_positive->total_amount;
                            return number_format($commission_amount, 2, '.', '');
                        })
                        ->addColumn('credit_amount', function($equity_report) use($from_date, $upto_date, $creditos_type_ids)
                        {
                            $credit_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                                    ->where('account_id', $equity_report->account_id)
                                    ->whereIn('movimientos_tipo_id', $creditos_type_ids)
                                    ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                                    ->first();

                            $credit_amount = $credit_amount_positive->total_amount;
                            return number_format($credit_amount, 2, '.', '');
                        })
                        ->addColumn('expenses_amount', function($equity_report) use($from_date, $upto_date, $expenses_type_ids)
                        {
                            $expense_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                                    ->where('account_id', $equity_report->account_id)
                                    ->whereIn('movimientos_tipo_id', $expenses_type_ids)
                                    ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                                    ->first();

                            $expense_amount = $expense_amount_positive->total_amount;
                            return number_format($expense_amount, 2, '.', '');
                        })
                        ->addColumn('profil_loss_amount', function($equity_report) use($from_date, $upto_date, $pnl_type_ids)
                        {
                            $pnl_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                                    ->where('account_id', $equity_report->account_id)
                                    ->whereIn('movimientos_tipo_id', $pnl_type_ids)
                                    ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])                                    
                                    ->first();
                            $pnl_amount          = $pnl_amount_positive->total_amount;
                            return number_format($pnl_amount, 2, '.', '');
                        })
                        ->addColumn('action', function ($equity_report) use($from_date, $upto_date)
                        {
                            return '<a target="_blank" href="' . url('reporte/equity/' . $equity_report->account_id) . '?from_date=' . substr($from_date, 0, -9) . '&upto_date=' . substr($upto_date, 0, -9)
                                    . '" class="btn btn-xs btn-info waves-effect waves-light m-r-5"><i class="fa fa-eye"></i> ' . __('sistema.btn_view') . '</a> ';
                        })
                        ->filterColumn('account_number', function($query, $keyword){
                            return $query->orWhere('accounts.account_number', 'like', '%' . $keyword . '%');
                        })
                        ->filterColumn('balance_amount', function($query, $keyword){
                            
                        })
                        ->filterColumn('client_name', function($query, $keyword)
                        {
                            return $query->whereRaw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) like "' . '%' . $keyword . '%"');
                        })
                        ->make(true);
    }

    public function generate_trade_table(Request $request)
    {
        try
        {
            $campos  = $request->all();
            $account = \App\Models\Account::find($campos['account_select']);

            $from_date = isset($campos['from_date']) ? ($campos['from_date'] . ' 00:00:00') : (date('Y-m-d', strtotime('-30 days')) . ' 00:00:00');
            $upto_date = isset($campos['upto_date']) ? ($campos['upto_date'] . ' 23:59:59') : (date('Y-m-d') . ' 23:59:59');

            $from_date_base = substr($from_date, 0, -9);
            $upto_date_base = substr($upto_date, 0, -9);

            //$month = isset($campos['month']) ? $campos['month'] : '1';
            //$year  = isset($campos['year']) ? $campos['year'] : '2016';

            $transactions = \App\Models\AccountTransaction::where('account_id', $account->id)
                            ->whereBetween('created_at', [$from_date, $upto_date])
                            ->orderBy('account_transactions.created_at')->get();

            $equity_report = MovimientosTransaction::select(['movimientos_transactions.*', 'accounts.account_number',
                        'clients.first_name', 'clients.middle_name', 'clients.surname1', 'clients.surname2',
                        'movimientos_tipos.type_' . session('language')])
                    ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date_base, $upto_date_base])
                    ->leftJoin('accounts', 'accounts.id', '=', 'movimientos_transactions.account_id')
                    ->leftJoin('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                    ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                    ->join('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                    //->join('movimientos_descripcions', 'movimientos_descripcions.id', '=', 'movimientos_transactions.movimientos_descripcion_id')
                    ->where(['clients.client_type' => 1, 'movimientos_transactions.account_id' => $account->id])
                    ->groupBy('movimientos_transactions.id')
                    ->get();

            $temp = DataTables::of($equity_report)
                    ->addColumn('client_name', function($equity_report)
                    {
                        return trim($equity_report->first_name . ' ' . $equity_report->middle_name . ' ' . $equity_report->surname1);
                    })
                    ->addColumn('deposits_amount', function($equity_report) use($from_date_base, $upto_date_base)
                    {
                        $deposit_amount = MovimientosTransaction::where('account_id', $equity_report->account_id)
                                ->whereIn('movimientos_tipo_id', [2])
                                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date_base, $upto_date_base])
                                ->sum('monto');
                        return number_format($deposit_amount, 2, '.', '');
                    })
                    ->addColumn('withdrawals_amount', function($equity_report) use($from_date_base, $upto_date_base)
                    {
                        $withdrawals_amount = MovimientosTransaction::where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => 1])
                                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date_base, $upto_date_base])
                                ->sum('monto');
                        return number_format($withdrawals_amount, 2, '.', '');
                    })
                    ->addColumn('commission_amount', function($equity_report) use($from_date_base, $upto_date_base)
                    {
                        $commission_amount = AccountTransaction::where(['account_id' => $equity_report->account_id])
                                ->whereBetween('created_at', [$from_date_base, $upto_date_base])
                                ->sum('commission');
                        return number_format($commission_amount, 2, '.', '');
                    })
                    ->addColumn('credit_amount', function($equity_report) use($from_date_base, $upto_date_base)
                    {
                        $deposit_amount = MovimientosTransaction::where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.credit_code')])
                                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date_base, $upto_date_base])
                                ->sum('monto');
                        return number_format($deposit_amount, 2, '.', '');
                    })
                    ->addColumn('expenses_amount', function($equity_report) use($from_date_base, $upto_date_base)
                    {
                        $deposit_amount = MovimientosTransaction::where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.debit_code')])
                                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date_base, $upto_date_base])
                                ->sum('monto');
                        return number_format($deposit_amount, 2, '.', '');
                    })
                    ->addColumn('profil_loss_amount', function($equity_report) use($from_date_base, $upto_date_base)
                    {
                        $pnl_amount = AccountTransaction::where(['account_id' => $equity_report->account_id])
                                ->whereBetween('created_at', [$from_date_base, $upto_date_base])
                                ->sum('gross_profit');
                        return number_format($pnl_amount, 2, '.', '');
                    })
                    ->make(true);

            $moment_report_data = json_decode($temp->getContent(), true);

            $moments = $moment_report_data['data'];

            $combos = [];
            
            if (!empty($transactions))
            {
                foreach ($transactions as $transaction)
                {
                    $timestamp             = strtotime($transaction->created_at);
                    $transaction->trs_type = 1;
                    if (array_key_exists($timestamp, $combos))
                    {                        
                        $timestamp = $timestamp + 1;                       
                    }
                    $combos[$timestamp] = $transaction;
                }
            }

            if (!empty($moments))
            {
                foreach ($moments as $moment_data)
                {
                    $movement_date           = $moment_data['fecha_transaccion'] . substr($moment_data['created_at'], 10, 9);
                    $timestamp               = strtotime($movement_date);
                    $moment_data['trs_type'] = 2;
                    if (array_key_exists($timestamp, $combos))
                    {
                        $timestamp = $timestamp + 1;
                    }
                    $combos[$timestamp] = $moment_data;
                }
            }
            ksort($combos);

            //return response()->json($combos,200);
            $html = \View::make('reports.trade.table', compact('combos', 'transactions'));

            return response()->json(['flag' => 1, 'message' => 'success', 'data' => $html->render()], 200);
        }
        catch (\Exception $ex)
        {
            return response()->json(['flag' => 0, 'message' => $ex->getMessage()], 500);
        }
    }

    public function send_report(Request $request)
    {
        try
        {
            $campos        = $request->only('statementIdsStr');
            $statement_ids = explode(',', $campos['statementIdsStr']);
            $count         = 0;
            if (empty($statement_ids))
            {
                return redirect()->back()->withInput()->with('msg', __("sistema.statement_select"))->with('type', 'error');
            }
            else
            {
                foreach ($statement_ids as $statement_id)
                {
                    $statment_history = \App\Models\StatementHistory::find($statement_id);

                    if ($statment_history)
                    {
                        $from_date     = $statment_history->from_period;
                        $account       = $statment_history->account;
                        $file_name_arr = explode("/", $statment_history->file_path);
                        $file_name     = $file_name_arr[2];

                        $settings = \App\Models\Setting::where('broker_id', $account->broker_id)->first();

                        $file_to_save_encrypted = storage_path('/' . $file_name_arr[0] . '/' . $file_name_arr[1] . '/encrypted/' . $file_name_arr['2']);
                        
                        $result = File::exists($file_to_save_encrypted);
                        
                        if(!$result)
                        {
                            $file_to_save_encrypted = storage_path('/' . $statment_history->file_path);
                            $result = File::exists($file_to_save_encrypted);
                            if(!$result)
                            {
                                return redirect()->back()->withInput()->with('msg', __('sistema.statement_select_file_lost'))->with('type', 'error');
                            }
                        }
                        
                        $period = date('d/m/Y', strtotime($statment_history->from_period)) . ' to ' . date('d/m/Y', strtotime($statment_history->upto_period));

                        if ($account)
                        {
                            $primary_client = $account->primary_client;
                            if ($primary_client)
                            {
                                Mail::send('emails.trade_report', ['user_name' => $primary_client->full_name, 'period' => $period, 'settings' => $settings], function ($m) use($primary_client, $period, $file_to_save_encrypted, $file_name, $settings)
                                {
                                    $m->from($settings->admin_email, $settings->admin_name);
                                    $m->to($primary_client->email1, $primary_client->full_name);
                                    $m->subject('PWM - Trade Report for ' . $period);
                                    $m->attach($file_to_save_encrypted, [
                                        'as'   => $file_name,
                                        'mime' => 'application/pdf'
                                    ]);
                                });
                                $count++;
                            }
                        }
                    }
                }
            }
            return redirect()->back()->with('msg', __('sistema.email_statement_sent', ['count' => $count]))->with('type', 'success');
        }
        catch (\Exception $ex)
        {
            dd($ex->getMessage());
            return redirect()->back()->withInput()->with('msg', $ex->getMessage())->with('type', 'error');
        }
        //dispatch(new SendTradeReport($campos['account_selected'], $campos['month'], $campos['year']));
        //return response()->json(['flag' => 1, 'data' => [], 'message' => __('sistema.trade_report.email_sent')], 200);
    }

    public function show_equity_details(Request $request, $account_id)
    {
        $campos    = $request->all();
        $from_date = isset($campos['from_date']) ? ($campos['from_date'] . ' 00:00:00') : (date('Y-m-d', strtotime('-30 days')) . ' 00:00:00');
        $upto_date = isset($campos['upto_date']) ? ($campos['upto_date'] . ' 23:59:59') : (date('Y-m-d') . ' 23:59:59');

        $from_date_base = substr($from_date, 0, -9);
        $upto_date_base = substr($upto_date, 0, -9);        
        
        $transactions = AccountTransaction::where('account_id', $account_id)
                        ->whereBetween('created_at', [$from_date, $upto_date])->get();

        $movimientos_trans = MovimientosTransaction::select('movimientos_transactions.*', 'accounts.account_number', 'clients.first_name', 'clients.surname1')
                ->join('accounts', 'accounts.id', '=', 'movimientos_transactions.account_id')
                ->join('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                ->join('clients', 'clients.id', '=', 'account_clients.client_id')
                ->where('clients.client_type', 1)
                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date_base, $upto_date_base])
                ->where('movimientos_transactions.account_id', $account_id);


        $temp = DataTables::of($movimientos_trans)
                ->addColumn('action', function ($movimientos_trans)
                {
                    $botones = '<a href="' . url('movimientos_transactions/' . $movimientos_trans->id . '/edit') . '" class="btn btn-xs btn-info waves-effect waves-light pull-left m-r-5"><i class="fa fa-edit"></i> ' . __('sistema.btn_edit') . '</a> ';

                    $botones .= '<form action="' . url('movimientos_transactions/' . $movimientos_trans->id) . '" id="borra_Frm' . $movimientos_trans->id . '" method="POST" class="pull-left">' . csrf_field() . ' ' . method_field('DELETE') . '<button type="button" onclick="confirmaDel(' . $movimientos_trans->id . ',\'' . $movimientos_trans->account_number . '\');" class="btn btn-xs btn-danger"><span class="fa fa-trash"></span> </button></form>&nbsp;';

                    return $botones;
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
                ->filterColumn('first_name', function($query, $keyword)
                {
                    return $query->where('clients.first_name', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('surname1', function($query, $keyword)
                {
                    return $query->where('clients.surname1', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('account_number', function($query, $keyword)
                {
                    return $query->where('accounts.account_number', 'like', '%' . $keyword . '%');
                })
                ->addColumn('m_type', function($query){
                    $tipo = $query->movimiento_tipo;
                    if($tipo)
                    {
                        $type = 'type_' . session('language');
                        return $tipo->$type;
                    }
                    return '-';
                })
                ->addColumn('equity', function($query){
                    $tipo = $query->movimiento_tipo;
                    
                    if($tipo)
                    {
                        $equity = $tipo->category;
                        if($equity)
                        {
                            $type = 'category_' . session('language');
                            return $equity->$type;
                        }                                                
                    }
                    return '-';
                })
                ->make(true);
        
        $moment_report_data = json_decode($temp->getContent(), true);

        $deposit_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 1)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $retiros_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 2)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $creditos_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 3)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $expenses_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 4)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $commission_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 5)
                ->pluck('movimientos_tipos.id')->toArray();
        
        $pnl_type_ids = \App\Models\MovimientosTipo::select('movimientos_tipos.id')
                ->join('movimientos_tipo_categories', 'movimientos_tipo_categories.id', '=', 'movimientos_tipos.movimientos_tipo_category_id')
                ->where('movimientos_tipo_categories.id', 6)
                ->pluck('movimientos_tipos.id')->toArray();        
        
        $moment_report = MovimientosTransaction::select(['movimientos_transactions.*', 'accounts.account_number',
                    'clients.first_name', 'clients.middle_name', 'clients.surname1', 'clients.surname2'])
                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                ->leftJoin('accounts', 'accounts.id', '=', 'movimientos_transactions.account_id')
                ->leftJoin('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                ->where(['clients.client_type' => 1, 'movimientos_transactions.account_id' => $account_id])
                ->groupBy('accounts.id')
                ->get();
        
        $temp2 = DataTables::of($moment_report)
                ->addColumn('client_name', function($equity_report)
                {
                    return trim($equity_report->first_name . ' ' . $equity_report->middle_name . ' ' . $equity_report->surname1);
                })
                ->addColumn('deposits_amount', function($equity_report) use($from_date, $upto_date, $deposit_type_ids)
                {
                    $deposit_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                            ->where('account_id', $equity_report->account_id)
                            ->whereIn('movimientos_tipo_id', $deposit_type_ids)
                            ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                            ->first();

                    $total_deposit_amount = $deposit_amount_positive->total_amount;
                    return number_format($total_deposit_amount, 2, '.', '');
                })
                ->addColumn('withdrawals_amount', function($equity_report) use($from_date, $upto_date, $retiros_type_ids)
                {
                    $withdrawals_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                            ->where('account_id', $equity_report->account_id)
                            ->whereIn('movimientos_tipo_id', $retiros_type_ids)
                            ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                            ->first();

                    $total_withdrawal_amount = $withdrawals_amount_positive->total_amount;
                    return number_format($total_withdrawal_amount, 2, '.', '');
                })
                ->addColumn('commission_amount', function($equity_report) use($from_date, $upto_date, $commission_type_ids)
                {
                    $commission_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                            ->where('account_id', $equity_report->account_id)
                            ->whereIn('movimientos_tipo_id', $commission_type_ids)
                            ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                            ->first();

                    $commission_amount = $commission_amount_positive->total_amount;
                    return number_format($commission_amount, 2, '.', '');
                })
                ->addColumn('credit_amount', function($equity_report) use($from_date, $upto_date, $creditos_type_ids)
                {
                    $credit_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                            ->where('account_id', $equity_report->account_id)
                            ->whereIn('movimientos_tipo_id', $creditos_type_ids)
                            ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                            ->first();

                    $credit_amount = $credit_amount_positive->total_amount;
                    return number_format($credit_amount, 2, '.', '');
                })
                ->addColumn('expenses_amount', function($equity_report) use($from_date, $upto_date, $expenses_type_ids)
                {
                    $expense_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                            ->where('account_id', $equity_report->account_id)
                            ->whereIn('movimientos_tipo_id', $expenses_type_ids)
                            ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                            ->first();

                    $expense_amount = $expense_amount_positive->total_amount;
                    return number_format($expense_amount, 2, '.', '');
                })
                ->addColumn('profil_loss_amount', function($equity_report) use($from_date, $upto_date, $pnl_type_ids)
                {
                    $pnl_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                            ->where('account_id', $equity_report->account_id)
                            ->whereIn('movimientos_tipo_id', $pnl_type_ids)
                            ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                            ->first();
                    $pnl_amount          = $pnl_amount_positive->total_amount;
                    return number_format($pnl_amount, 2, '.', '');
                })
                ->make(true);

        $moment_report_data = json_decode($temp->getContent(), true);

        $moment_report_data2 = json_decode($temp2->getContent(), true);

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('reports.equity.details', ['moments' => $moment_report_data['data'], 'moments2' => $moment_report_data2['data']])->with('elmenu', ['elmenu' => $lstMenus]);
    }

    public function dataTradereportHistory(Request $request)
    {
        $campos = $request->all();

//        $from_date = isset($campos['start_date']) ? ($campos['start_date'] . ' 00:00:00') : (date('Y-m-d', strtotime('-30 days')) . ' 00:00:00');
//        $upto_date = isset($campos['end_date']) ? ($campos['end_date'] . ' 23:59:59') : (date('Y-m-d') . ' 23:59:59');

        $from_date_basic = isset($campos['start_date']) ? $campos['start_date'] : date('Y-m-d', strtotime('-30 days'));
        $upto_date_basic = isset($campos['end_date']) ? $campos['end_date'] : date('Y-m-d');

        $account_id = isset($campos['account_id']) ? $campos['account_id'] : null;
        $type       = isset($campos['report_type']) ? $campos['report_type'] : 'trade';

        $condicion  = 'type = ? AND (from_period >= ? AND upto_period <= ?)';
        //$parametros = [$from_date_basic, $upto_date_basic, $from_date_basic, $upto_date_basic, $type];
        $parametros = [$type, $from_date_basic, $upto_date_basic];

        $broker_id = $request->has('broker_id') ? $request->broker_id : '';
        $assigned_brokers_id = collect(auth()->user()->assigned_brokers)->pluck('id')->toArray();        
        
        $history = \App\Models\StatementHistory::select(['statement_histories.*', 'accounts.account_number', DB::raw('(CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2)) as client_name'), 'accounts.opt_notification'])
//                ->whereBetween('statement_histories.created_at', [$from_date, $upto_date])
                ->whereRaw($condicion, $parametros)
                //, $upto_date])
//                ->where('type', $type)
                ->leftJoin('accounts', 'accounts.id', '=', 'account_id')
                ->leftJoin('account_clients', 'account_clients.account_id', '=', 'statement_histories.account_id')
                ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id');

        if ($account_id)
        {
            $history->where('statement_histories.account_id', $account_id);
        }

        if($broker_id == '')
        {
            $history->whereIn('accounts.broker_id', $assigned_brokers_id);
        }
        else
        {
            if(in_array($broker_id, $assigned_brokers_id))
            {
                $history->where('accounts.broker_id', $broker_id);
            }
            else
            {
                $history->where('accounts.broker_id', null);
            }
        }
        
        $history->groupBy('statement_histories.id');

        return DataTables::of($history)
                        ->addColumn('for_period', function($history)
                        {
                            return $history->from_period . ' - ' . $history->upto_period;
                        })
                        ->filterColumn('account_number', function($query, $keyword)
                        {
                            $query->where('accounts.account_number', 'like', '%' . $keyword . '%');
                        })
                        ->filterColumn('client_name', function($query, $keyword)
                        {
                            return $query->whereRaw('CONCAT_WS(" ", clients.first_name, clients.middle_name, clients.surname1, clients.surname2) like "' . '%' . $keyword . '%"');
                        })
                        ->addColumn('action', function ($history)
                        {
                            $botones = '<a target="_blank" href="' . url('reporte/trade/history/' . $history->account_id) . '/details/?from_date=' . $history->from_period . '&upto_date=' . $history->upto_period
                                    . '" class="btn btn-xs btn-info waves-effect waves-light m-r-5"><i class="fa fa-eye"></i> ' . __('sistema.btn_view') . '</a> ';
                            $botones .= '<a href="' . url('reporte/trade/history/' . $history->id) . '" class="btn btn-xs btn-success waves-effect waves-light"><i class="fa fa-download"></i> ' . __('sistema.btn_download') . '</a>';
                            return $botones;
                        })
                        ->make(true);
    }

    public function download_trade_report($report_id)
    {
        $statement = \App\Models\StatementHistory::find($report_id);

        if (!$statement)
        {
            abort(404);
        }
        $file_to_download = storage_path($statement->file_path);

        if (!file_exists($file_to_download))
        {
            return redirect('items')->with('msg', __('sistema.save_success_msg'))->with('type', 'error');
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Type: application/force-download");
        header('Content-Disposition: attachment; filename=' . urlencode(basename($file_to_download)));
        // header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_to_download));
        ob_clean();
        flush();
        readfile($file_to_download);
        exit;
    }

    public function show_trade_report_history_details(Request $request, $account_id)
    {
        $campos    = $request->all();
        $from_date = isset($campos['from_date']) ? ($campos['from_date'] . ' 00:00:00') : (date('Y-m-d', strtotime('-30 days')) . ' 00:00:00');
        $upto_date = isset($campos['upto_date']) ? ($campos['upto_date'] . ' 23:59:59') : (date('Y-m-d') . ' 23:59:59');

        $transactions = AccountTransaction::where('account_id', $account_id)
                        ->whereBetween('created_at', [$from_date, $upto_date])->get();

        $movimientos_trans = MovimientosTransaction::select(['movimientos_transactions.*', 'accounts.account_number', 'clients.first_name', 'clients.surname1',
                    'movimientos_tipos.type_' . session('language')])
                ->leftJoin('accounts', 'accounts.id', '=', 'movimientos_transactions.account_id')
                ->leftJoin('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                ->join('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                //->join('movimientos_descripcions', 'movimientos_descripcions.id', '=', 'movimientos_transactions.movimientos_descripcion_id')
                ->where('clients.client_type', 1)
                ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
                ->where('movimientos_transactions.account_id', $account_id)
                ->groupBy('movimientos_transactions.id');

        $temp               = DataTables::of($movimientos_trans)
                ->make(true);
        /*
          $moment_report = MovimientosTransaction::select(['movimientos_transactions.*', 'accounts.account_number',
          'clients.first_name', 'clients.middle_name', 'clients.surname1', 'clients.surname2'])
          ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
          ->leftJoin('accounts', 'accounts.id', '=', 'movimientos_transactions.account_id')
          ->leftJoin('account_clients', 'account_clients.account_id', '=', 'accounts.id')
          ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
          ->where(['clients.client_type' => 1, 'movimientos_transactions.account_id' => $account_id])
          ->groupBy('accounts.id')
          ->get();

          $temp2 = DataTables::of($moment_report)
          ->addColumn('client_name', function($equity_report)
          {
          return trim($equity_report->first_name . ' ' . $equity_report->middle_name . ' ' . $equity_report->surname1);
          })
          ->addColumn('deposits_amount', function($equity_report) use($from_date, $upto_date)
          {
          $deposit_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
          ->where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.deposit_code')])
          ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
          ->first();

          $total_deposit_amount = $deposit_amount_positive->total_amount;
          return number_format($total_deposit_amount, 2, '.', '');
          })
          ->addColumn('withdrawals_amount', function($equity_report) use($from_date, $upto_date)
          {
          $withdrawals_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
          ->where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.withdrawal_code')])
          ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
          ->first();

          $total_withdrawal_amount = $withdrawals_amount_positive->total_amount;
          return number_format($total_withdrawal_amount, 2, '.', '');
          })
          ->addColumn('commission_amount', function($equity_report) use($from_date, $upto_date)
          {
          $commission_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
          ->where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.comission_code')])
          ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
          ->first();

          $commission_amount = $commission_amount_positive->total_amount;
          return number_format($commission_amount, 2, '.', '');
          })
          ->addColumn('credit_amount', function($equity_report) use($from_date, $upto_date)
          {
          $credit_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
          ->where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.credit_code')])
          ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
          ->first();

          $credit_amount = $credit_amount_positive->total_amount;
          return number_format($credit_amount, 2, '.', '');
          })
          ->addColumn('expenses_amount', function($equity_report) use($from_date, $upto_date)
          {
          $expense_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
          ->where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.expense_code')])
          ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
          ->first();

          $expense_amount = $expense_amount_positive->total_amount;
          return number_format($expense_amount, 2, '.', '');
          })
          ->addColumn('profil_loss_amount', function($equity_report) use($from_date, $upto_date)
          {
          $pnl_amount_positive = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
          ->where(['account_id' => $equity_report->account_id, 'movimientos_tipo_id' => config('starter.pl_code')])
          ->whereBetween('movimientos_transactions.fecha_transaccion', [$from_date, $upto_date])
          ->first();
          $pnl_amount          = $pnl_amount_positive->total_amount;
          return number_format($pnl_amount, 2, '.', '');
          })
          ->make(true);

          $moment_report_data2 = json_decode($temp2->getContent(), true);

         */
        $moment_report_data = json_decode($temp->getContent(), true);
        $combo              = [];

        if (!empty($transactions))
        {
            foreach ($transactions as $transaction)
            {
                $timestamp             = strtotime($transaction->created_at);
                $transaction->trs_type = 1;
                if (array_key_exists($timestamp, $combo))
                {
                    do
                    {
                        $timestamp = $timestamp + 1;
                    }
                    while (!array_key_exists($timestamp, $combo));
                }
                $combo[$timestamp] = $transaction;
            }
        }

        if (!empty($moment_report_data['data']))
        {
            foreach ($moment_report_data['data'] as $moment_data)
            {
                $movement_date           = $moment_data['fecha_transaccion'] . substr($moment_data['created_at'], 10, 9);
                $timestamp               = strtotime($movement_date);
                $moment_data['trs_type'] = 2;
                if (array_key_exists($timestamp, $combo))
                {
                    do
                    {
                        $timestamp = $timestamp + 1;
                    }
                    while (!array_key_exists($timestamp, $combo));
                }
                $combo[$timestamp] = $moment_data;
            }
        }
        ksort($combo);

        $lstMenus = Util::generateMenu(auth()->user()->perfil_id);
        return view('reports.trade.details', [
                    'combos'       => $combo,
//                    'moments2'     => $moment_report_data2['data'],
                    'transactions' => $transactions
                ])->with('elmenu', ['elmenu' => $lstMenus]);
    }

}

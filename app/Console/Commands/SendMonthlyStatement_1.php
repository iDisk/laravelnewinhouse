<?php

namespace App\Console\Commands;

use Log;
use Mail;
use File;
use Dompdf\Dompdf;
use App\Models\Account;
use Illuminate\Console\Command;
use App\Models\AccountTransaction;
use App\Models\MovimientosTransaction;
use Yajra\DataTables\Facades\DataTables;

class SendMonthlyStatement1 extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade_report_old:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates and send Trade Report Monthly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try
        {
            Account::select(['id', 'broker_id', 'account_number', 'account_type', 'opening_amount', 'opt_notification'])->chunk(100, function ($accounts)
            {
                foreach ($accounts as $account)
                {
                    session(['language' => 'en']);
                    $primary_client = $account->primary_client;

                    $from_date = date('Y-m-01', strtotime("-1 month")) . ' 00:00:00';
                    $upto_date = date('Y-m-t', strtotime("-1 month")) . ' 23:59:59';

                    //$from_date = '2019-03-01 00:00:00';
                    //$upto_date = '2019-03-31 23:59:59';

                    $transactions = AccountTransaction::where('account_id', $account->id)
                                    ->whereBetween('created_at', [$from_date, $upto_date])
                                    ->orderBy('account_transactions.created_at')->get();
                    //->whereRaw("YEAR(created_at) = $year AND MONTH(created_at) = $month ")->get();
                    if(count($transactions) > 0)
                    {
                        $first_transaction    = $transactions->first();
                        $previous_transaction = null;
                        if ($first_transaction)
                        {
                            $previous_transaction = AccountTransaction::where('id', '<', $first_transaction->id)->orderBy('id', 'desc')->first();
                        }

                        $settings = \App\Models\Setting::where('broker_id', $account->broker_id)->first();

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

                        if (count($transactions) > 0)
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

                        $html = \View::make('reports.trade.report', compact('data'));


                        // instantiate and use the dompdf class
                        $dompdf = new Dompdf();
                        $dompdf->set_option("isPhpEnabled", true);
                        $dompdf->loadHtml($html->render());

                        // (Optional) Setup the paper size and orientation
                        $dompdf->setPaper('A4', 'landscape');

                        // Render the HTML as PDF
                        $dompdf->render();

                        $today                  = date('Y_m_d');
                        $file_name              = 'statement_' . $account->account_number . '_' . date('Ymd', strtotime($from_date)) . '_' . date('Ymd', strtotime($upto_date)) . '.pdf';
                        $folder_path            = storage_path('trade_reports/' . $today);
                        $folder_path2           = storage_path('trade_reports/' . $today . '/encrypted');
                        File::makeDirectory($folder_path, 0777, true, true);
                        File::makeDirectory($folder_path2, 0777, true, true);
                        $file_to_save           = $folder_path . '/' . $file_name;
                        $file_to_save_encrypted = $folder_path . '/encrypted/' . $file_name;

                        //save the pdf file on the server
                        file_put_contents($file_to_save, $dompdf->output());

                        $pdf_protection = $primary_client->dob ? (date('Ymd', strtotime($primary_client->dob))) : $account->account_number;
                        $dompdf->getCanvas()->get_cpdf()->setEncryption($pdf_protection, '', []);
                        file_put_contents($file_to_save_encrypted, $dompdf->output());


                        //Make record of this event
                        $statment_history = \App\Models\StatementHistory::create([
                                    'type'         => 'trade',
                                    'account_id'   => $account->id,
                                    'file_path'    => 'trade_reports/' . $today . '/' . $file_name,
                                    'from_period'  => $from_date,
                                    'upto_period'  => $upto_date,
                                    'generated_by' => 'system'
                        ]);

                        if ($account->opt_notification)
                        {
                            /*
                            $period = date('d/m/Y', strtotime($statment_history->from_period)) . ' to ' . date('d/m/Y', strtotime($statment_history->upto_period));

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
                            Log::info('Email Sent (STR):' . $account->id . ' for ' . date("F, Y", strtotime($from_date)));
                            */
                        }
                    }
                }
            });
            Log::info('Cron Success at ' . date('Y-m-d H:i:s'));
        }
        catch (\Exception $ex)
        {
            Log::error('Error while auto-generation of trade report : ' . $ex->getMessage());
        }
    }

}

<?php

namespace App\Jobs;

use Log;
use Mail;
use File;
use Dompdf\Dompdf;
use App\Models\Account;
use Illuminate\Bus\Queueable;
use App\Models\AccountTransaction;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTradeReport implements ShouldQueue
{

    use Dispatchable,
        InteractsWithQueue,
        Queueable,
        SerializesModels;

    private $account_ids;
    private $month;
    private $year;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($account_ids, $month, $year)
    {
        $this->account_ids = $account_ids;
        $this->month       = $month;
        $this->year        = $year;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Send Trade Report params :', [$this->account_ids, $this->month, $this->year]);

        try
        {
            foreach ($this->account_ids as $account_id)
            {
                $account = Account::find($account_id);

                if ($account)
                {

                    $primary_client = $account->primary_client;

                    $start_date = "$this->year-$this->month-01 00:00:00";
                    $upto_date  = date("Y-m-t", strtotime($start_date)) . ' 23:59:59';

                    $transactions = AccountTransaction::where('account_id', $account->id)
                                    ->whereRaw("YEAR(created_at) = $this->year AND MONTH(created_at) = $this->month ")->get();

                    $first_transaction    = $transactions->first();
                    $previous_transaction = null;
                    if ($first_transaction)
                    {
                        $previous_transaction = AccountTransaction::where('id', '<', $first_transaction->id)->orderBy('id', 'desc')->first();
                    }
                    $data = [
                        'transactions'         => $transactions,
                        'account'              => $account,
                        'info'                 => [
                            'from_date' => $start_date,
                            'upto_date' => $upto_date
                        ],
                        'previous_transaction' => $previous_transaction,
                        'last_transaction'     => $transactions->last()
                    ];

                    $html = \View::make('reports.trade.report', compact('data'));

                    // instantiate and use the dompdf class
                    $dompdf = new Dompdf();
                    $dompdf->loadHtml($html->render());

                    // (Optional) Setup the paper size and orientation
                    $dompdf->setPaper('A4', 'landscape');

                    // Render the HTML as PDF
                    $dompdf->render();

                    $font = $dompdf->getFontMetrics()->get_font("helvetica", "bold");
                    $dompdf->getCanvas()->page_text(770, 575, "Page: {PAGE_NUM} / {PAGE_COUNT}", $font, 8, array(0, 0, 0));

                    $pdf_protection = $primary_client->dob ? (date('Ymd', strtotime($primary_client->dob))) : $account->account_number;

                    $dompdf->getCanvas()->get_cpdf()->setEncryption($pdf_protection, '', []);

                    $file_name    = 'trade_report_' . date('Y_m_d_h_i_s') . '.pdf';
                    $folder_path  = storage_path('trade_reports/temp/');
                    File::makeDirectory($folder_path, 0777, true, true);
                    $file_to_save = $folder_path . $file_name;
                    //save the pdf file on the server
                    file_put_contents($file_to_save, $dompdf->output());


                    Mail::send('emails.trade_report', ['user_name' => $primary_client->full_name, 'start_date' => $start_date], function ($m) use($primary_client, $start_date, $file_to_save, $file_name)
                    {
                        $m->from('admin@atrix.com', 'Admin Atrix');
                        $m->to($primary_client->email1, $primary_client->full_name);
                        if ($primary_client->email2)
                        {
                            $m->cc($primary_client->email2, $primary_client->full_name);
                        }
                        $m->subject('PWM - Trade Report for ' . date("F, Y", strtotime($start_date)));
                        $m->attach($file_to_save, [
                            'as'   => $file_name,
                            'mime' => 'application/pdf'
                        ]);
                    });

                    Log::info('Email Sent (STR):' . $account_id);
                }
                else
                {
                    Log::warning('Account not found (STR): ' . $account_id);
                }
            }
        }
        catch (\Exception $ex)
        {
            Log::error('Error during send trade report : ' . $ex->getMessage(), [$this->account_ids, $this->month, $this->year]);
        }
    }

}

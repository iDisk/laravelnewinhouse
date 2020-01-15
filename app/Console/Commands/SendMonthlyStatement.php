<?php

namespace App\Console\Commands;

use Log;
use Mail;
use File;
use Dompdf\Dompdf;
use App\Models\Account;
use App\Util\HelperUtil;
use Illuminate\Console\Command;
use App\Models\AccountTransaction;
use App\Models\MovimientosTransaction;
use Yajra\DataTables\Facades\DataTables;

class SendMonthlyStatement extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade_report:send';

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
            $from_date = date('Y-m-01', strtotime("-1 month")) . ' 00:00:00';
            $upto_date = date('Y-m-t', strtotime("-1 month")) . ' 23:59:59';
            
            $from_date = '2019-11-01';
            $upto_date = '2019-11-30';

            Account::select(['id', 'broker_id', 'account_number', 'account_type', 'opening_amount', 'opt_notification'])->chunk(100, function ($accounts) use($from_date, $upto_date)
            {
                foreach ($accounts as $account)
                {
                    session(['language' => 'es']);
                    $primary_client = $account->primary_client;

                    $transactions = AccountTransaction::select('id')
                                    ->where('account_id', $account->id)
                                    ->whereBetween('created_at', [$from_date, $upto_date])
                                    ->orderBy('account_transactions.created_at')
                                    ->get();
                    
                    if(count($transactions) > 0)
                    {
                        HelperUtil::generate_statement($account, $from_date, $upto_date, true, false);
                    }
                }
            });
            Log::info('Cron Success at ' . date('Y-m-d H:i:s'));
        }
        catch (\Exception $ex)
        {
            die($ex->getMessage());
            Log::error('Error while auto-generation of trade report : ' . $ex->getMessage());
        }
    }

}

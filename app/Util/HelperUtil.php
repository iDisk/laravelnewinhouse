<?php

namespace App\Util;

use DB;
use AWS;
use Log;
use File;
use Lang;
use Dompdf\Dompdf;
use App\Models\Client;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\TradeInvestment;
use App\Models\AccountTransaction;
use App\Models\MovimientosTransaction;
use App\Models\Instrument;
use Mail;
use App\Mail\NotificationMail;

class HelperUtil
{

    public static function get_currentlang()
    {
        $current_lang = Lang::locale();
        if (in_array($current_lang, ['es', 'en']))
        {
            return $current_lang;
        }
        else
        {
            return 'en';
        }
    }

    public static function send_sms($telefono_celular)
    {
        //Send SMS with confirmation code
        $sms                     = AWS::createClient('sns');
        $six_digit_random_number = mt_rand(100000, 999999);

        $message = __('sistema.otp_text') . ' ' . $six_digit_random_number;

        Log::info('SMS Sent : ' . $telefono_celular . ' => ' . $message);

        if (env('ALLOW_SMS', false))
        {
            $sms->publish([
                'Message'           => $message,
                'PhoneNumber'       => $telefono_celular,
                'MessageAttributes' => [
                    'AWS.SNS.SMS.SMSType' => [
                        'DataType'    => 'String',
                        'StringValue' => 'Transactional',
                    ]
                ],
            ]);
        }
        return $six_digit_random_number;
    }

    /**
     * Generate a Random String
     *
     */
    static function RandomString($length)
    {
        $characters    = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $LenCaracteres = strlen($characters) - 1;
        $randstring    = '';
        for ($i = 0; $i < $length; $i++)
        {
            $randstring .= $characters[rand(0, $LenCaracteres)];
        }
        return $randstring;
    }

    /**
     * Encode given number
     *
     */
    public static function encode($id)
    {
        $firstStr = self::RandomString(5);
        $lastStr  = self::RandomString(5);
        $id_str   = (string) $id;
        $offset   = rand(0, 9);
        $encoded  = chr(65 + $offset);
        $len      = strlen($id_str);
        for ($i = 0; $i < $len; $i++)
        {
            $encoded .= chr(65 + $id_str[$i] + $offset);
        }
        $encoded = $firstStr . $encoded . $lastStr;
        return $encoded;
    }

    /**
     * Decode given number
     *
     */
    public static function decode($encoded)
    {
        $encoded = substr($encoded, 5);
        $encoded = substr($encoded, 0, -5);
        $offset  = ord($encoded[0]) - 65;
        $encoded = substr($encoded, 1);
        for ($i = 0, $len = strlen($encoded); $i < $len; ++$i)
        {
            $encoded[$i] = ord($encoded[$i]) - $offset - 65;
        }
        return (int) $encoded;
    }

    /**
     * Returns numbers of notifications
     * 
     */
    public static function unread_notification_count()
    {
        try
        {
            if (auth()->user())
            {
                $user_id      = auth()->user()->id;
                $unread_count = Notification::where(['user_id' => $user_id, 'is_read' => 0])->count();
                return $unread_count;
            }
            return 0;
        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }

    /**
     *
     * Get broker setting details
     */
    public static function broker_setting()
    {

        $user_id = auth()->user()->id;

        $client = Client::where('user_id', $user_id)->first();
        $broker = $client->broker;

        $settings = null;

        if ($broker)
        {
            $settings = $broker->setting;
        }
        return $settings;
    }

    /**
     *
     * Get broker setting details
     */
    public static function broker_setting_using_domain($request)
    {
        $broker = \App\Models\Broker::where('broker_url','like', '%' . $request->server("HTTP_HOST") . '%')->first();
        //return $broker;
        $settings = null;

        if ($broker)
        {
            $settings = $broker->setting;
        }
        return $settings;
    }

    /**
     * 
     * Get Opening balance transactions
     */
    public static function get_transactions_opening_balance($account_id, $upto_date)
    {
        try
        {
            $transactions = AccountTransaction::where('account_id', $account_id)->where('created_at', '<', $upto_date)->sum('net_result');
            return $transactions;
        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }

    /**
     * 
     * Get Opening balance
     */
    public static function get_movement_opening_balance($account_id, $upto_date)
    {
        try
        {
            $movements = MovimientosTransaction::select([
                        DB::raw('IFNULL(SUM(CASE WHEN operation_category = 1 THEN monto ELSE 0 END),0) AS positive_val'),
                        DB::raw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto ELSE 0 END),0) AS negative_val')
                    ])
                    ->where('account_id', $account_id)
                    ->where('fecha_transaccion', '<', $upto_date)
                    ->first();

            $total = 0;

            if ($movements)
            {
                $positive_val = isset($movements->positive_val) ? $movements->positive_val : 0;
                $negative_val = isset($movements->negative_val) ? $movements->negative_val : 0;
                $total        = $positive_val - $negative_val;
            }
            return $total;
        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }

    /**
     * 
     * Get Opening balance
     */
    public static function get_investment_opening_balance($account_id, $upto_date, $instrument_id)
    {
        try
        {
            $investments = TradeInvestment::select([
                                DB::raw('IFNULL(SUM(CASE WHEN tipo = "cr" THEN monto ELSE 0 END),0) AS positive_val'),
                                DB::raw('IFNULL(SUM(CASE WHEN tipo = "dr" THEN monto ELSE 0 END),0) AS negative_val')
                            ])
                            ->where(['account_id' => $account_id, 'instrument_id' => $instrument_id])
                            ->where('fecha', '<', $upto_date)->first();

            $total = 0;

            if ($investments)
            {
                $positive_val = isset($investments->positive_val) ? $investments->positive_val : 0;
                $negative_val = isset($investments->negative_val) ? $investments->negative_val : 0;
                $total        = $positive_val - $negative_val;
            }
            return $total;
        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }

    /**
     * 
     * Get Opening balance
     */
    public static function get_instrument_name($instrument_id)
    {
        $instrument = \App\Models\Instrument::find($instrument_id);

        if ($instrument)
        {
            $lang = self::get_currentlang();
            return $lang == 'es' ? $instrument->instrument_es : $instrument->instrument_en;
        }
        else
        {
            return '-';
        }
    }

    /**
     * 
     * Check Opening balance
     */
    public static function check_opening_balance($account_id, $from_date, $upto_date)
    {
        $instrument = \App\Models\TradeInvestment::where('account_id', $account_id)
                ->whereBetween('fecha', [substr($from_date, 0, -9), substr($upto_date, 0, -9)])
                ->where('');

        return $account_id . ' => ' . substr($upto_date, 0, -9);
    }

    /**
     * 
     * Get total for Derivados ETIM CFDS FX ETFS
     */
    public static function get_derivados_balance($account_id, $upto_date)
    {
        try
        {
            $instrument_id = array('1');

            $transaction_total = AccountTransaction::select(DB::raw('IFNULL(SUM(net_result),0) AS total_amount'))
                        ->where('account_id', $account_id)
                        ->whereIn('instrument_id', $instrument_id)
                        ->whereDate('created_at', '<=', $upto_date)
                        ->first();
            /*
            $movimientos_total = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto WHEN operation_category = 1 THEN - monto END),0) AS total_amount')
                    ->where('account_id', $account_id)
                    ->whereIn('instrument_id', $instrument_id)
                    ->where('fecha_transaccion', '<=', $upto_date)
                    ->first(); */

            $total = 0;

            //$total = $transaction_total->total_amount + $movimientos_total->total_amount;
            $total = $transaction_total->total_amount;

            return $total;
        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }

    /**
     * 
     * Get total for trade investment on the basis of instruments
     */
    public static function get_trade_investment_instruments_amount($account_id, $upto_date)
    {
        $instruments_amount = array();

        try
        {

            $transactions = AccountTransaction::select('instrument_id',DB::raw('IFNULL(SUM(net_result),0) AS total_amount'))
                        ->where('account_id', $account_id)
                        ->whereDate('created_at', '<=', $upto_date)
                        ->groupBy('instrument_id')
                        ->get();

            if($transactions){
                foreach ($transactions as $key => $value) 
                {
                    $instruments_amount[$value->instrument_id] = $value->total_amount;
                }
            }


            /*$investments = TradeInvestment::select([
                                'instrument_id',
                                DB::raw('IFNULL(SUM(CASE WHEN tipo = "cr" THEN monto ELSE 0 END),0) AS positive_val'),
                                DB::raw('IFNULL(SUM(CASE WHEN tipo = "dr" THEN monto ELSE 0 END),0) AS negative_val')
                            ])
                            ->where('account_id',$account_id)
                            ->where('fecha', '<=', $upto_date)
                            ->groupBy('instrument_id')
                            ->get();

            if($investments){
                foreach ($investments as $key => $value) 
                {
                    $instruments_amount[$value->instrument_id] = $value->positive_val - $value->negative_val;
                }
            }*/

            return $instruments_amount;

        }
        catch (\Exception $ex)
        {
            return $instruments_amount;
        }
    }

    /**
     * 
     * Get total for movement operation on the basis movement type
     */
    public static function get_movement_operation_type_amount($account_id, $upto_date)
    {
        $movimientos_tipo_category_id = array('1','2','3','4','5','6');

        $movimientos_transaction =array();

        try
        {

            $movimientos = MovimientosTransaction::select('movimientos_tipos.movimientos_tipo_category_id',DB::raw('IFNULL(SUM(CASE WHEN movimientos_transactions.operation_category = 1 THEN movimientos_transactions.monto WHEN movimientos_transactions.operation_category = 0 THEN - movimientos_transactions.monto END),0) AS total_amount'))
                    ->join('movimientos_tipos','movimientos_tipos.id','movimientos_transactions.movimientos_tipo_id')
                    ->where('movimientos_transactions.account_id', $account_id)
                    ->where('movimientos_transactions.fecha_transaccion', '<=', $upto_date)
                    ->whereIn('movimientos_tipos.movimientos_tipo_category_id', $movimientos_tipo_category_id)
                    ->groupBy('movimientos_tipos.movimientos_tipo_category_id')
                    ->get();

            if($movimientos){
                foreach ($movimientos as $key => $value) {
                    $movimientos_transaction[$value->movimientos_tipo_category_id] = $value->total_amount;
                }
            }

            return $movimientos_transaction;
        }
        catch (\Exception $ex)
        {
            return $movimientos_transaction;
        }
        
    }

    /**
     * 
     * Get total for trade investment
     */
    public static function get_trade_investment_amount($account_id, $upto_date)
    {
        $total = 0;

        try
        {
            $investments = TradeInvestment::select([
                        DB::raw('IFNULL(SUM(CASE WHEN tipo = "cr" THEN monto ELSE 0 END),0) AS positive_val'),
                        DB::raw('IFNULL(SUM(CASE WHEN tipo = "dr" THEN monto ELSE 0 END),0) AS negative_val')
                    ])
                    ->where('account_id',$account_id)
                    ->where('fecha', '<=', $upto_date)
                    ->first();

            if ($investments)
            {
                $positive_val = isset($investments->positive_val) ? $investments->positive_val : 0;
                $negative_val = isset($investments->negative_val) ? $investments->negative_val : 0;
                $total        = $positive_val - $negative_val;
            }
            return $total;
        }
        catch (\Exception $ex)
        {
            return $total;
        }
    }

    /**
     * 
     * Get Opening balance
     */
    public static function get_movement_opening_equity_balance($account_id, $upto_date,$tipo_category_id)
    {
        try
        {
            $movements = MovimientosTransaction::select([
                        DB::raw('IFNULL(SUM(CASE WHEN operation_category = 1 THEN monto ELSE 0 END),0) AS positive_val'),
                        DB::raw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto ELSE 0 END),0) AS negative_val')
                    ])
                    ->join('movimientos_tipos','movimientos_tipos.id','movimientos_transactions.movimientos_tipo_id')
                    ->where('account_id', $account_id)
                    ->where('fecha_transaccion', '<', $upto_date)
                    ->whereIn('movimientos_tipos.movimientos_tipo_category_id', $tipo_category_id)
                    ->first();

            $total = 0;

            if ($movements)
            {
                $positive_val = isset($movements->positive_val) ? $movements->positive_val : 0;
                $negative_val = isset($movements->negative_val) ? $movements->negative_val : 0;
                $total        = $positive_val - $negative_val;
            }
            return $total;
        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }

    /**
     * 
     * Get Opening balance transactions
     */
    public static function get_transactions_opening_instrument_balance($account_id, $upto_date,$instrument_id)
    {
        try
        {
            $transactions = AccountTransaction::where('account_id', $account_id)
                ->where('created_at', '<', $upto_date)
                ->where('instrument_id',$instrument_id)
                ->sum('net_result');
            return $transactions;
        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }


    /**
     * 
     * Function to get the current saldo of the given account
     */
    public static function get_current_saldo_amount($account_id, $upto_date = null, $format = true)
    {
        $trade_amount = self::get_trade_investment_amount($account_id, ($upto_date) ? $upto_date : date("Y-m-d"));
        $movement_amount = self::get_movement_opening_balance($account_id, ($upto_date) ? date("Y-m-d", strtotime($upto_date . '+1 day')) : date("Y-m-d", strtotime('+1 day')));
        $transaction_amount = self::get_transactions_opening_balance($account_id, ($upto_date) ? date("Y-m-d", strtotime($upto_date . '+1 day')) : date("Y-m-d", strtotime('+1 day')));
        $total = $trade_amount + $movement_amount + $transaction_amount;        
        if($format)
        {
            return number_format($total, 2);
        }
        return $total;
    }
    
    /**
     * 
     * Function to get saldo_actual in amplie su financiamiento
     */
    public static function amplie_saldo_actual($user_id)
    {
        $credit_requests = \App\Models\ClientRequest::where(['user_id' => $user_id, 'request_status_id' => 2])
                ->whereIn('request_type_id', [4, 5])->orderBy('created_at', 'desc')->get();

        $saldo_actual            = $linea_de_credito_actual = 0;
        $last_approved_data = null;

        if ($credit_requests && count($credit_requests) > 0)
        {
            $last_request = $credit_requests->first();

            if ($last_request)
            {
                $json_last               = json_decode($last_request->text, true);
                $last_approved_data = $last_request->created_at;
                //$linea_de_credito_actual = isset($json_last['credit_amount']) ? (isset($json_last['credit_amount']) ? $json_last['credit_amount']['value'] : 0) : 0;
            }

            foreach ($credit_requests as $credit)
            {
                $json_current            = json_decode($credit->text, true);
                $saldo_actual += isset($json_current['credit_amount']) ? (isset($json_current['credit_amount']) ? $json_current['credit_amount']['value'] : 0) : 0;
            }
        }
        return ['saldo_actual' => number_format($saldo_actual, 2, '.', ','), 'linea_de_credito_actual' => number_format($linea_de_credito_actual, 2, '.', ','), 'last_approved_data' => $last_approved_data];
    }


    public static function generate_statement($account, $from_date, $upto_date, $store_file = true, $webview = true)
    {
        $transactions = AccountTransaction::where('account_id', $account->id)
                        ->whereBetween('created_at', [$from_date, $upto_date])
                        ->orderBy('account_transactions.created_at')->get();

        $opening_balance_transactions = self::get_transactions_opening_balance($account->id, $from_date);

        $closing_balance_transactions = AccountTransaction::where('account_id', $account->id)
                        ->whereBetween('created_at', [$from_date, $upto_date])
                        ->orderBy('account_transactions.created_at')->sum('net_result');

        $moment_report = MovimientosTransaction::select(['movimientos_transactions.*', 'accounts.account_number',
                    'clients.first_name', 'clients.middle_name', 'clients.surname1', 'clients.surname2',
                    'movimientos_tipos.type_en', 'movimientos_tipos.type_es'])
                ->whereBetween('movimientos_transactions.fecha_transaccion', [substr($from_date, 0, -9), substr($upto_date, 0, -9)])
                ->leftJoin('accounts', 'accounts.id', '=', 'movimientos_transactions.account_id')
                ->leftJoin('account_clients', 'account_clients.account_id', '=', 'accounts.id')
                ->leftJoin('clients', 'clients.id', '=', 'account_clients.client_id')
                ->join('movimientos_tipos', 'movimientos_tipos.id', '=', 'movimientos_transactions.movimientos_tipo_id')
                ->where(['clients.client_type' => 1, 'movimientos_transactions.account_id' => $account->id])
                ->orderBy('movimientos_transactions.fecha_transaccion')
                ->get();

        $opening_balance_movements = self::get_movement_opening_balance($account->id, substr($from_date, 0, -9));

        $closing_balance_movements_tmp = MovimientosTransaction::select([
                    DB::raw('IFNULL(SUM(CASE WHEN operation_category = 0 THEN monto ELSE 0 END),0) AS positive_val'),
                    DB::raw('IFNULL(SUM(CASE WHEN operation_category = 1 THEN monto ELSE 0 END),0) AS negative_val')
                ])
                ->where('account_id', $account->id)
                ->whereBetween('movimientos_transactions.fecha_transaccion', [substr($from_date, 0, -9), substr($upto_date, 0, -9)])
                ->first();

        $closing_balance_movements = 0;

        if ($closing_balance_movements_tmp)
        {
            $positive_val              = isset($closing_balance_movements_tmp->positive_val) ? $closing_balance_movements_tmp->positive_val : 0;
            $negative_val              = isset($closing_balance_movements_tmp->negative_val) ? $closing_balance_movements_tmp->negative_val : 0;
            $closing_balance_movements = $positive_val - $negative_val;
        }

        $settings = Setting::where('broker_id', $account->broker_id)->first();

        $trade_investements = TradeInvestment::where('account_id', $account->id)
                ->whereBetween('fecha', [substr($from_date, 0, -9), substr($upto_date, 0, -9)])
                ->orderBy('fecha')
                ->get();


        $trade_categories = TradeInvestment::where('account_id', $account->id)->where('fecha', '<=', substr($from_date, 0, -9))->groupBy('instrument_id')->pluck('instrument_id')->toArray();

        $trading_investments = [];

        if (!empty($trade_categories) && count($trade_categories) > 0)
        {
            foreach ($trade_categories as $cat)
            {
                $trading_investments[$cat] = [];
            }
        }

        if ($trade_investements && count($trade_investements) > 0)
        {
            foreach ($trade_investements as $t_investment)
            {
                if (array_key_exists($t_investment->instrument_id, $trading_investments))
                {
                    $trading_investments[$t_investment->instrument_id][] = $t_investment;
                }
                else
                {
                    $trading_investments[$t_investment->instrument_id] = [$t_investment];
                }
            }
        }

        ksort($trading_investments);

        //Summary
        //$derivados_amount                = self::get_derivados_balance($account->id, substr($from_date, 0, -9));
        //$trade_investment_instrument_amt = self::get_trade_investment_instruments_amount($account->id, substr($from_date, 0, -9));        
        //$trade_investment_amt            = self::get_trade_investment_amount($account->id, substr($from_date, 0, -9));

        $trade_tradeinvestment_movement  = self::get_trade_n_trade_investment_n_movement($account->id, substr($upto_date, 0, -9));
        $movement_operation_type_amt     = self::get_movement_operation_type_amount($account->id, substr($upto_date, 0, -9));                
        $trade_n_tradeinvestment_amt     = self::get_trade_n_trade_investment($account->id, substr($upto_date, 0, -9));
        $financiamientos_activos_amt     = self::getFinanciamientos_activosTotal($account->id, substr($upto_date, 0, -9));
        
        //dd($account->id,$upto_date,substr($upto_date, 0, -9),$trade_n_tradeinvestment_amt);
        
        $data = [
            'transactions'                   => $transactions,
            'movement_transaction'           => $moment_report,
            'trading_investments'            => $trading_investments,
            'trade_invest_count'             => count($trade_categories),
            'account'                        => $account,
            'info'                           => [
                'from_date' => $from_date,
                'upto_date' => $upto_date
            ],
            'settings'                       => $settings,
            'opening_balance_transactions'   => $opening_balance_transactions,
            'closing_balance_transactions'   => $closing_balance_transactions,
            'saldo_transactions'             => $opening_balance_transactions + $closing_balance_transactions,
            'opening_balance_movements'      => $opening_balance_movements,
            'closing_balance_movements'      => $closing_balance_movements,
            'saldo_movements'                => $opening_balance_movements + $closing_balance_movements,
            //'derivados_amount'                => $derivados_amount,
            //'trade_investment_instrument_amt' => $trade_investment_instrument_amt,
            'movement_operation_type_amt'    => $movement_operation_type_amt,
            //'trade_investment_amt'            => $trade_investment_amt,
            'trade_n_tradeinvestment_amt'    => $trade_n_tradeinvestment_amt,
            'trade_tradeinvestment_movement' => $trade_tradeinvestment_movement,
            'financiamientos_activos_amt'    => $financiamientos_activos_amt,
            'webview'                        => $webview
        ];

        $html = \View::make('reports.statement', compact('data'));
        //die($html->render());
        //Extra start
        //$dompdf = \App::make('dompdf.wrapper');
        //$dompdf->loadHTML($html->render());
        //$dompdf->setPaper('A4', 'landscape');

        $dompdf = new Dompdf();
        $dompdf->set_option("isPhpEnabled", true);
        $dompdf->loadHtml($html->render());
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        //$file_to_save = $account->account_number . '_' .date('Ymd', strtotime($campos['from_date'])) . '_' . date('Ymd', strtotime($campos['upto_date'])) . '_' . date('YmdHis') . '.pdf';
        $file_to_save = 'statement_' . $account->account_number . '_' . date('Ymd', strtotime($from_date)) . '_' . date('Ymd', strtotime($upto_date)) . '.pdf';

        if ($store_file)
        {
            $today       = date('Y_m_d');
            $folder_path = storage_path('trade_reports/' . $today);
            File::makeDirectory($folder_path, 0777, true, true);

            $folder_path2 = storage_path('trade_reports/' . $today . '/encrypted');
            File::makeDirectory($folder_path2, 0777, true, true);

            $file_to_save_simple    = $folder_path . '/' . $file_to_save;
            $file_to_save_encrypted = $folder_path2 . '/' . $file_to_save;
            
            //save the pdf file on the server
            file_put_contents($file_to_save_simple, $dompdf->output());
            $primary_client = $account->primary_client;

            $pdf_protection = $primary_client->dob ? (date('Ymd', strtotime($primary_client->dob))) : $account->account_number;
            
            $dompdf->getCanvas()->get_cpdf()->setEncryption($pdf_protection, '', []);
            file_put_contents($file_to_save_encrypted, $dompdf->output());
            
            //header('Content-Description: File Transfer');
            //header('Content-Type: application/octet-stream');
            //header("Content-Type: application/force-download");
            //header('Content-Disposition: attachment; filename=' . urlencode(basename($file_to_save)));
            //header('Expires: 0');
            //header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            //header('Pragma: public');
            //header('Content-Length: ' . filesize($file_to_save));
            //ob_clean();
            //flush();
            //readfile($file_to_save);
            //exit;
            
            //Make record of this event
            $statment_history = \App\Models\StatementHistory::create([
                        'type'         => 'trade',
                        'account_id'   => $account->id,
                        'file_path'    => 'trade_reports/' . $today . '/' . $file_to_save,
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
            return true;
        }
        else
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header("Content-Type: application/force-download");
            header('Content-Disposition: attachment; filename=' . urlencode(basename($file_to_save)));
            return $dompdf->output();
        }
    }
    /**
     * 
     * Function to get Transacions. Total from trade and trade investment
     */
    public static function get_trade_n_trade_investment($account_id,$upto_date)
    {
        $total = 0;
        try
        {
            $transactions = AccountTransaction::where('account_id', $account_id)
                ->where('created_at', '<=', $upto_date)
                ->sum('net_result');

            if($transactions){
                $total = $transactions;
            }

            $investments = TradeInvestment::select([
                        DB::raw('IFNULL(SUM(CASE WHEN tipo = "cr" THEN monto ELSE 0 END),0) AS positive_val'),
                        DB::raw('IFNULL(SUM(CASE WHEN tipo = "dr" THEN monto ELSE 0 END),0) AS negative_val')
                    ])
                    ->where('account_id',$account_id)
                    ->where('fecha', '<=', $upto_date)
                    ->first();

            if ($investments)
            {
                $positive_val = isset($investments->positive_val) ? $investments->positive_val : 0;
                $negative_val = isset($investments->negative_val) ? $investments->negative_val : 0;
                $total        = $total + ($positive_val - $negative_val);
            }
            return $total;
        }
        catch (\Exception $ex)
        {
            return $total;
        }
    }

    /**
     * 
     * Function to get Transacions. Total from trade and trade investment
     */
    public static function get_trade_n_trade_investment_n_movement($account_id,$upto_date)
    {

        $final_array[] = array();

        try
        {

            $movimientos = MovimientosTransaction::select('movimientos_transactions.instrument_id',DB::raw('IFNULL(SUM(CASE WHEN movimientos_transactions.operation_category = 1 THEN movimientos_transactions.monto WHEN movimientos_transactions.operation_category = 0 THEN - movimientos_transactions.monto END),0) AS total_amount'))
                    ->where('movimientos_transactions.account_id', $account_id)
                    ->where('movimientos_transactions.fecha_transaccion', '<=', $upto_date)
                    ->groupBy('movimientos_transactions.instrument_id')
                    ->pluck('total_amount','instrument_id');
                    

            $transactions = AccountTransaction::select('instrument_id',DB::raw('IFNULL(SUM(net_result),0) AS total_amount'))
                        ->where('account_id', $account_id)
                        ->whereDate('created_at', '<=', $upto_date)
                        ->groupBy('instrument_id')
                        ->pluck('total_amount','instrument_id');


            $trade_investments = TradeInvestment::select('instrument_id',DB::raw('IFNULL(SUM(CASE WHEN tipo = "cr" THEN monto WHEN tipo = "dr" THEN - monto END),0) AS total_amount'))
                    ->where('account_id',$account_id)
                    ->where('fecha', '<=', $upto_date)
                    ->groupBy('instrument_id')
                    ->pluck('total_amount','instrument_id');


            $instruments = Instrument::select('id')->get();

            foreach ($instruments as $instrument) {

                $total  = 0;

                if(isset($movimientos[$instrument->id])){
                    $total = $total + $movimientos[$instrument->id];
                }
                if(isset($transactions[$instrument->id])){
                    $total = $total + $transactions[$instrument->id];
                }
                if(isset($trade_investments[$instrument->id])){
                    $total = $total + $trade_investments[$instrument->id];
                }

                $final_array[$instrument->id] = $total;
            }

            return $final_array;

        }
        catch (\Exception $ex)
        {
            return $final_array;
        }
    }

    /**
     * 
     * Function to get all Transacions for instrument.
     */
    public static function get_all_transaction_instrument($account_id, $instrument_id)
    {
        try
        {
            $movimientos = MovimientosTransaction::select(DB::raw('IFNULL(SUM(CASE WHEN movimientos_transactions.operation_category = 1 THEN movimientos_transactions.monto WHEN movimientos_transactions.operation_category = 0 THEN - movimientos_transactions.monto END),0) AS total_amount'))
                    ->where('movimientos_transactions.account_id', $account_id)
                    ->where('movimientos_transactions.instrument_id',$instrument_id)
                    ->first();

            $transactions = AccountTransaction::select(DB::raw('IFNULL(SUM(net_result),0) AS total_amount'))
                        ->where('account_id', $account_id)
                        ->where('instrument_id',$instrument_id)
                        ->first();

            $trade_investments = TradeInvestment::select(DB::raw('IFNULL(SUM(CASE WHEN tipo = "cr" THEN monto WHEN tipo = "dr" THEN - monto END),0) AS total_amount'))
                    ->where('account_id',$account_id)
                    ->where('instrument_id',$instrument_id)
                    ->first();

            $total  = 0;

            if(isset($movimientos)){
                $total = $total + $movimientos->total_amount;
            }
            if(isset($transactions)){
                $total = $total + $transactions->total_amount;
            }

            if(isset($trade_investments)){
                $total = $total + $trade_investments->total_amount;
            }

            return $total; 

        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }
    
    public static function event_notification($client_request)
    {
        //dd($client_request);
        try
        {            
            $user = $client_request->user;
            $client = $user->client;

            $broker_name = null;
            $broker_email = null;
            $client_email = null;

            if ($client)
            {
                $client_email = $client->email1;
                $broker_data = $client->broker;

                if($broker_data){
                    $broker_name = $client->broker->broker;
                    $broker_email = $broker_data->setting->support_team_email;
                }
            }

            //dd($broker_name, $broker_email, $client_email);

            $parameters_json = [
                'FIRMA_DEL_BROKER' => $broker_name,
                'MESSAGE' => $client_request->comments                        
            ];            

            switch ($client_request->request_type_id)
            {
                case 1:
                    $short_message = 'change_of_custody';
                    $template_name = 'change_custody';
                    $subject      = __('sistema.notifications.short_message.change_of_custody');

                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'change_of_custody_approved';
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.change_of_custody_approved');
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'change_of_custody_rejected';
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.change_of_custody_rejected');
                    }
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                break;
                case 3:
                
                    $short_message = 'administration_de_cuentas';
                    $template_name = 'administration_de_cuentas';
                    $subject      = __('sistema.notifications.short_message.administration_de_cuentas');

                    $json_decode = json_decode($client_request->text, true);

                    if(isset($json_decode['tfamodify_limit']))
                    {
                        $parameters_json['TFAMODIFY_LIMIT'] = $json_decode['tfamodify_limit']['value'];
                    }
                    if(isset($json_decode['ttpmodify_limit']))
                    {
                        $parameters_json['TTPMODIFY_LIMIT'] = $json_decode['ttpmodify_limit']['value'];
                    }
                    if(isset($json_decode['timodify_limit']))
                    {
                        $parameters_json['TIMODIFY_LIMIT'] = $json_decode['timodify_limit']['value'];
                    }

                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'administration_de_cuentas_approved';
                        $subject      = __('sistema.notifications.short_message.administration_de_cuentas_approved');
                        $parameters_json['ESTATUS'] = 'approved';
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'administration_de_cuentas_rejected';
                        $subject      = __('sistema.notifications.short_message.administration_de_cuentas_rejected');
                        $parameters_json['ESTATUS'] = 'rejected';
                    }

                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                    break;                    
                case 4:
                    $short_message = 'request_financing';
                    $template_name = 'request_financing';
                    $subject      = __('sistema.notifications.short_message.request_financing');

                    $json_decode = json_decode($client_request->text, true);
                    
                    $parameters_json['MONTO'] = isset($json_decode['credit_amount']) ? $json_decode['credit_amount']['value'] : 0;
                    
                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'request_financing_approved';
                        //$template_name = 'request_financing_approved';                        
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.request_financing_approved');

                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'request_financing_rejected';
                        //$template_name = 'request_financing_rejected';
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.request_financing_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    break;
                case 5:
                    $short_message = 'funding_extension';
                    $template_name = 'funding_extension';
                    $subject      = __('sistema.notifications.short_message.funding_extension');


                    $json_decode = json_decode($client_request->text, true);
                    
                    $monto = isset($json_decode['credit_amount']) ? $json_decode['credit_amount']['value'] : 0;

                    $parameters_json['MONTO'] = $monto;
                    
                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'funding_extension_approved';
                        //$template_name = 'funding_extension_approved';                        
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.funding_extension_approved');
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'funding_extension_rejected';
                        //$template_name = 'funding_extension_rejected';
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.funding_extension_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                    break;
                case 6:

                    $short_message = 'refinanciamiento';
                    $template_name = 'refinanciamiento';
                    $subject      = __('sistema.notifications.short_message.refinanciamiento');

                    $json_decode = json_decode($client_request->text, true);

                    $i=1;
                    for($i; $i<=3; $i++){

                        $pay_amount = 'payment_amount'.$i;
                        $pay_date = 'payment_date'.$i;

                        if(isset($json_decode[$pay_amount]) || isset($json_decode[$pay_date]))
                        {
                            $parameters_json['REFINANCIAMIENTO_ARR'][$i]['MONTO'] = isset($json_decode[$pay_amount]) ? $json_decode[$pay_amount]['value'] : 0;
                            $parameters_json['REFINANCIAMIENTO_ARR'][$i]['FECHA'] = isset($json_decode[$pay_date]) ? $json_decode[$pay_date]['value'] : '-';
                        }
                    }

                    //dd($parameters_json,json_encode($parameters_json));
                    
                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'refinanciamiento_approved';
                        //$template_name = 'refinanciamiento_approved';                        
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.refinanciamiento_approved');
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'refinanciamiento_rejected';
                        //$template_name = 'refinanciamiento_rejected';
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.refinanciamiento_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                    break;
                case 7:
                    $short_message = 'close_financing';
                    $template_name = 'close_financing';
                    $subject      = __('sistema.notifications.short_message.close_financing');

                    $json_decode = json_decode($client_request->text, true);
                    
                    if($client_request->request_status_id == 1){
                        
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'close_financing_approved';                        
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.close_financing_approved');

                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'close_financing_rejected';                        
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.close_financing_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    break;
                case 8:

                    $short_message = 'entre_mis_cuentas';
                    $template_name = 'entre_mis_cuentas';
                    $subject      = __('sistema.notifications.short_message.entre_mis_cuentas');

                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['FROM_ACCOUNT'] = '-';
                    if(isset($json_decode['from_account'])){
                        $acc_arr = explode('-', $json_decode['from_account']['value']);
                        $acc_arr[0] = str_repeat('X', strlen($acc_arr[0]) - 4) . substr($acc_arr[0], -4);
                        $parameters_json['FROM_ACCOUNT'] = implode('-', $acc_arr);
                    }
                    //$parameters_json['FROM_ACCOUNT'] = isset($json_decode['from_account']) ? $json_decode['from_account']['value'] : '-';

                    

                    $parameters_json['CURRENCY'] = isset($json_decode['currency']) ? $json_decode['currency']['value'] : '-';
                    $parameters_json['CURRENCY_SYMBOL'] = isset($json_decode['currency_symbol']) ? $json_decode['currency_symbol']['value'] : '';
                    $parameters_json['AMOUNT'] = isset($json_decode['amount']) ? $json_decode['amount']['value'] : 0;
                    $parameters_json['APPLICATION_DATE'] = isset($json_decode['application_date']) ? $json_decode['application_date']['value'] : '-';

                    $parameters_json['PAYMENT_ACCOUNT'] = '-';
                    if(isset($json_decode['payment_account'])){
                        $acc_arr = explode('-', $json_decode['payment_account']['value']);
                        $acc_arr[0] = str_repeat('X', strlen($acc_arr[0]) - 4) . substr($acc_arr[0], -4);
                        $parameters_json['PAYMENT_ACCOUNT'] = implode('-', $acc_arr);
                    }
                    //$parameters_json['PAYMENT_ACCOUNT'] = isset($json_decode['payment_account']) ? $json_decode['payment_account']['value'] : '-';

                    
                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'entre_mis_cuentas_approved';                        
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.entre_mis_cuentas_approved');

                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'entre_mis_cuentas_rejected';                        
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.entre_mis_cuentas_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                break;
                case 9:

                    $short_message = 'transferencias_internacionales';
                    $template_name = 'transferencias_internacionales';
                    $subject      = __('sistema.notifications.short_message.transferencias_internacionales');

                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['ACCOUNT'] = '-';
                    if(isset($json_decode['ti_account'])){
                        $acc_arr = explode('-', $json_decode['ti_account']['value']);
                        $acc_arr[0] = str_repeat('X', strlen($acc_arr[0]) - 4) . substr($acc_arr[0], -4);
                        $parameters_json['ACCOUNT'] = implode('-', $acc_arr);
                    }
                    //$parameters_json['ACCOUNT'] = isset($json_decode['ti_account']) ? $json_decode['ti_account']['value'] : '-';
                    $parameters_json['SHORT_FUND_ACCOUNT'] = '-';
                    if(isset($json_decode['ti_shortage_funds_account'])){
                        $acc_arr = explode('-', $json_decode['ti_shortage_funds_account']['value']);
                        $acc_arr[0] = str_repeat('X', strlen($acc_arr[0]) - 4) . substr($acc_arr[0], -4);
                        $parameters_json['SHORT_FUND_ACCOUNT'] = implode('-', $acc_arr);
                    }
                    //$parameters_json['SHORT_FUND_ACCOUNT'] = isset($json_decode['ti_shortage_funds_account']) ? $json_decode['ti_shortage_funds_account']['value'] : '-';
                    $parameters_json['BENEFICIARY'] = '';
                    if(isset($json_decode['ti_beneficiary'])){
                        $acc_arr = explode('-', $json_decode['ti_beneficiary']['value']);
                        $acc_arr[0] = str_repeat('X', strlen($acc_arr[0]) - 4) . substr($acc_arr[0], -4);
                        $parameters_json['BENEFICIARY'] = implode('-', $acc_arr);
                    }
                    //$parameters_json['BENEFICIARY'] = isset($json_decode['ti_beneficiary']) ? $json_decode['ti_beneficiary']['value'] : '';
                    $parameters_json['AMOUNT'] = isset($json_decode['ti_amount']) ? $json_decode['ti_amount']['value'] : 0;
                    $parameters_json['CARGO'] = isset($json_decode['ti_cargo']) ? $json_decode['ti_cargo']['value'] : '-';
                    $parameters_json['VALUE_DATE'] = isset($json_decode['ti_value_date']) ? $json_decode['ti_value_date']['value'] : '-';
                    $parameters_json['EXECUTION_DATE'] = isset($json_decode['ti_execution_date']) ? $json_decode['ti_execution_date']['value'] : '-';
                    $parameters_json['TRANSFER_DETAIL1'] = isset($json_decode['ti_transfer_details1']) ? $json_decode['ti_transfer_details1']['value'] : '-';
                    $parameters_json['TRANSFER_DETAIL2'] = isset($json_decode['ti_transfer_details2']) ? $json_decode['ti_transfer_details2']['value'] : '-';

                    if(isset($json_decode['ti_send_receipt']))
                    {
                        $parameters_json['SEND_RECEIPT'] = $json_decode['ti_send_receipt']['value'];
                    }

                    $i=1;
                    for($i; $i<=5; $i++){

                        $document = 'document'.$i;

                        if(isset($json_decode[$document]))
                        {
                            $parameters_json['DOCUMENT_ARR'][$i]['PATH'] = isset($json_decode[$document]) ? $json_decode[$document]['path'] : '-';
                            $parameters_json['DOCUMENT_ARR'][$i]['NAME'] = isset($json_decode[$document]) ? $json_decode[$document]['original_file_name'] : '-';
                        }
                    }

                    
                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'transferencias_internacionales_approved';                        
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.transferencias_internacionales_approved');

                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'transferencias_internacionales_rejected';                        
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.transferencias_internacionales_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                break;
                case 16:

                    $short_message = 'diversifique';
                    $template_name = 'diversifique';
                    $subject      = __('sistema.notifications.short_message.diversifique');

                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['FROM_ACCOUNT'] = '-';

                    if(isset($json_decode['from_account'])){
                        $acc_arr = explode('-', $json_decode['from_account']['value']);
                        $acc_arr[0] = str_repeat('X', strlen($acc_arr[0]) - 4) . substr($acc_arr[0], -4);
                        $parameters_json['FROM_ACCOUNT'] = implode('-', $acc_arr);
                    }
                    //$parameters_json['FROM_ACCOUNT'] = isset($json_decode['from_account']) ? $json_decode['from_account']['value'] : '-';
                    $parameters_json['PRODUCT_HIRE'] = isset($json_decode['product_hire']) ? $json_decode['product_hire']['value'] : '-';
                    $parameters_json['EXPIRATION_DATE'] = isset($json_decode['expiration_date']) ? $json_decode['expiration_date']['value'] : '-';
                    $parameters_json['AMOUNT'] = isset($json_decode['amount']) ? $json_decode['amount']['value'] : '-';
                    $parameters_json['APPLICATION_DATE'] = isset($json_decode['application_date']) ? $json_decode['application_date']['value'] : '-';
                    $parameters_json['INSTRUCTION'] = isset($json_decode['instruction']) ? $json_decode['instruction']['value'] : '-';
                    
                    
                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'diversifique_approved';
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.diversifique_approved');
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'diversifique_rejected';
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.diversifique_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                break;
                case 20:

                    $short_message = 'datos_personales';
                    $template_name = 'datos_personales';
                    $subject      = __('sistema.notifications.short_message.datos_personales');

                    /*
                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['FROM_ACCOUNT'] = isset($json_decode['from_account']) ? $json_decode['from_account']['value'] : '-';
                    */
                    
                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'datos_personales_approved';
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.datos_personales_approved');
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'datos_personales_rejected';
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.datos_personales_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                break;
                case 22:

                    $short_message = 'control_de_acceso';
                    $template_name = 'control_de_acceso';
                    $subject      = __('sistema.notifications.short_message.control_de_acceso');

                    /*
                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['FROM_ACCOUNT'] = isset($json_decode['from_account']) ? $json_decode['from_account']['value'] : '-';
                    */
                    
                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'control_de_acceso_approved';
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.control_de_acceso_approved');
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'control_de_acceso_rejected';
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.control_de_acceso_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                break;
                case 24:

                    $short_message = 'ajuste_de_permisos';
                    $template_name = 'ajuste_de_permisos';
                    $subject      = __('sistema.notifications.short_message.ajuste_de_permisos');

                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['FULL_NAME'] = isset($json_decode['full_name']) ? $json_decode['full_name']['value'] : '-';
                    $parameters_json['TYPE_NUMBER'] = isset($json_decode['type_number']) ? $json_decode['type_number']['value'] : '-';
                    $parameters_json['DATE_OF_BIRTH'] = isset($json_decode['date_of_birth']) ? $json_decode['date_of_birth']['value'] : '-';
                    $parameters_json['PLACE_OF_BIRTH'] = isset($json_decode['place_of_birth']) ? $json_decode['place_of_birth']['value'] : '-';
                    $parameters_json['ADDRESS'] = isset($json_decode['address']) ? $json_decode['address']['value'] : '-';
                    $parameters_json['COUNTRY'] = isset($json_decode['country']) ? $json_decode['country']['value'] : '-';
                    $parameters_json['STATE'] = isset($json_decode['state']) ? $json_decode['state']['value'] : '-';
                    $parameters_json['COUNTY'] = isset($json_decode['county']) ? $json_decode['county']['value'] : '-';
                    $parameters_json['PHONE_1'] = isset($json_decode['phone_1']) ? $json_decode['phone_1']['value'] : '-';
                    $parameters_json['PHONE_2'] = isset($json_decode['phone_2']) ? $json_decode['phone_2']['value'] : '';
                    $parameters_json['EMAIL'] = isset($json_decode['email']) ? $json_decode['email']['value'] : '';

                    if(isset($json_decode['permission_account_access'])){
                        $parameters_json['PERMISSION_ACCOUNT_ACCESS'] = $json_decode['permission_account_access']['value'];
                    }
                    if(isset($json_decode['permission_transfer_btwn_accounts'])){
                        $parameters_json['PERMISSION_TRANSFR_BTW_ACCOUNT'] = $json_decode['permission_transfer_btwn_accounts']['value'];
                    }
                    if(isset($json_decode['permission_telephone_orders'])){
                        $parameters_json['PERMISSION_TELEPHONE_ORDERS'] = $json_decode['permission_telephone_orders']['value'];
                    }
                    if(isset($json_decode['permission_international_transfer'])){
                        $parameters_json['PERMISSION_INTERNATIONAL_TRANSFER'] = $json_decode['permission_international_transfer']['value'];
                    }
                    if(isset($json_decode['permission_written_orders'])){
                        $parameters_json['PERMISSION_WIRITTEN_ORDERS'] = $json_decode['permission_written_orders']['value'];
                    }

                    $i=1;
                    for($i; $i<=5; $i++){

                        $document = 'document'.$i;

                        if(isset($json_decode[$document]))
                        {
                            $parameters_json['DOCUMENT_ARR'][$i]['PATH'] = isset($json_decode[$document]) ? $json_decode[$document]['path'] : '-';
                            $parameters_json['DOCUMENT_ARR'][$i]['NAME'] = isset($json_decode[$document]) ? $json_decode[$document]['original_file_name'] : '-';
                        }
                    }

                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'ajuste_de_permisos_approved';
                        $subject      = __('sistema.notifications.short_message.ajuste_de_permisos_approved');
                        $parameters_json['ESTATUS'] = 'approved';
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'ajuste_de_permisos_rejected';
                        $subject      = __('sistema.notifications.short_message.ajuste_de_permisos_rejected');
                        $parameters_json['ESTATUS'] = 'rejected';
                    }

                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                break;                      
                
                case 27:


                    $short_message = 'envio_de_documentacion';
                    $template_name = 'envio_de_documentacion';
                    $subject      = __('sistema.notifications.short_message.envio_de_documentacion');

                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['DOCUMENT_TYPE'] = isset($json_decode['document_type']) ? $json_decode['document_type']['value'] : '-';
                    
                    if(isset($json_decode['documents']))
                    {
                        foreach ($json_decode['documents'] as $key => $value) 
                        {
                            $parameters_json['DOCUMENT_ARR'][$key]['PATH'] = isset($value['document']) ? $value['document']['path'] : '-';
                            $parameters_json['DOCUMENT_ARR'][$key]['NAME'] = isset($value['document']) ? $value['document']['original_file_name'] : '-';
                        }
                    }                    

                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'envio_de_documentacion_approved';
                        $subject      = __('sistema.notifications.short_message.envio_de_documentacion_approved');
                        $parameters_json['ESTATUS'] = 'approved';
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'envio_de_documentacion_rejected';
                        $subject      = __('sistema.notifications.short_message.envio_de_documentacion_rejected');
                        $parameters_json['ESTATUS'] = 'rejected';
                    }

                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                break;

                case 28:

                    $short_message = 'alta_de_cuentas';
                    $template_name = 'alta_de_cuentas';
                    $subject      = __('sistema.notifications.short_message.alta_de_cuentas');

                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['TYPE_OF_RECIPIENT'] = isset($json_decode['adc_type_of_recipient']) ? $json_decode['adc_type_of_recipient']['value'] : '';
                    $parameters_json['DESTINATION'] = isset($json_decode['adc_destination']) ? $json_decode['adc_destination']['value'] : '';
                    $parameters_json['TYPE_OF_ACCOUNT'] = isset($json_decode['adc_type_of_account']) ? $json_decode['adc_type_of_account']['value'] : '';
                    $parameters_json['ACCOUNT_NAME'] = isset($json_decode['adc_account_name']) ? $json_decode['adc_account_name']['value'] : '';

                    $parameters_json['ACCOUNT_NUMBER'] = '';
                    if(isset($json_decode['adc_account_number'])){
                        $parameters_json['ACCOUNT_NUMBER'] = str_repeat('X', strlen($json_decode['adc_account_number']['value']) - 3) . substr($json_decode['adc_account_number']['value'], -3);
                    }
                    //$parameters_json['ACCOUNT_NUMBER'] = isset($json_decode['adc_account_number']) ? $json_decode['adc_account_number']['value'] : '';
                    $parameters_json['CURRENCY'] = isset($json_decode['adc_currency']) ? $json_decode['adc_currency']['value'] : '';

                    $parameters_json['TELEPHONE'] = isset($json_decode['adc_telephone']) ? $json_decode['adc_telephone']['value'] : '';
                    $parameters_json['ADDRESS'] = isset($json_decode['adc_address']) ? $json_decode['adc_address']['value'] : '';
                    $parameters_json['COUNTRY'] = isset($json_decode['adc_country']) ? $json_decode['adc_country']['value'] : '';
                    $parameters_json['STATE'] = isset($json_decode['adc_state']) ? $json_decode['adc_state']['value'] : '';
                    $parameters_json['CITY'] = isset($json_decode['adc_city']) ? $json_decode['adc_city']['value'] : '';
                    $parameters_json['DEST_BANK_COUNTRY'] = isset($json_decode['adc_dest_bank_country']) ? $json_decode['adc_dest_bank_country']['value'] : '';
                    $parameters_json['DEST_ACCOUNT_NUMBER'] = isset($json_decode['adc_dest_account_number']) ? $json_decode['adc_dest_account_number']['value'] : '';
                    $parameters_json['DEST_SWIFT'] = isset($json_decode['adc_dest_swift']) ? $json_decode['adc_dest_swift']['value'] : '';
                    $parameters_json['DEST_BANK_NAME'] = isset($json_decode['adc_dest_bank_name']) ? $json_decode['adc_dest_bank_name']['value'] : '';
                    $parameters_json['DEST_BANK_ADDRESS'] = isset($json_decode['adc_dest_bank_address']) ? $json_decode['adc_dest_bank_address']['value'] : '';
                    $parameters_json['INT_BANK_COUNTRY'] = isset($json_decode['adc_int_bank_country']) ? $json_decode['adc_int_bank_country']['value'] : '';
                    $parameters_json['DEST_INT_ACCOUNT_NUMBER'] = '';
                    if(isset($json_decode['adc_dest_int_account_number'])){
                        $parameters_json['DEST_INT_ACCOUNT_NUMBER'] = str_repeat('X', strlen($json_decode['adc_dest_int_account_number']['value']) - 3) . substr($json_decode['adc_dest_int_account_number']['value'], -3);
                    }
                    //$parameters_json['DEST_INT_ACCOUNT_NUMBER'] = isset($json_decode['adc_dest_int_account_number']) ? $json_decode['adc_dest_int_account_number']['value'] : '';
                    $parameters_json['DEST_INT_SWIFT'] = isset($json_decode['adc_dest_int_swift']) ? $json_decode['adc_dest_int_swift']['value'] : '';
                    $parameters_json['DEST_INT_BANK_NAME'] = isset($json_decode['adc_dest_int_bank_name']) ? $json_decode['adc_dest_int_bank_name']['value'] : '';
                    $parameters_json['DEST_INT_BANK_ADDRESS'] = isset($json_decode['adc_dest_int_bank_address']) ? $json_decode['adc_dest_int_bank_address']['value'] : '';

                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'alta_de_cuentas_approved';
                        $subject      = __('sistema.notifications.short_message.alta_de_cuentas_approved');
                        $parameters_json['ESTATUS'] = 'approved';
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'alta_de_cuentas_rejected';
                        $subject      = __('sistema.notifications.short_message.alta_de_cuentas_rejected');
                        $parameters_json['ESTATUS'] = 'rejected';
                    }

                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                break; 

                case 29:

                    $short_message = 'baja_de_cuentas';
                    $template_name = 'baja_de_cuentas';
                    $subject      = __('sistema.notifications.short_message.baja_de_cuentas');

                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['NUM_DE_CUENTA'] = '-';
                    if(isset($json_decode['bdc_num_de_cuenta'])){
                        $parameters_json['NUM_DE_CUENTA'] = str_repeat('X', strlen($json_decode['bdc_num_de_cuenta']['value']) - 3) . substr($json_decode['bdc_num_de_cuenta']['value'], -3);
                    }

                    //$parameters_json['NUM_DE_CUENTA'] = isset($json_decode['bdc_num_de_cuenta']) ? $json_decode['bdc_num_de_cuenta']['value'] : '-';
                    $parameters_json['TIPO_CUENTA'] = isset($json_decode['bdc_tipo_cuenta']) ? $json_decode['bdc_tipo_cuenta']['value'] : '-';
                    $parameters_json['DESCRIPTION_CUENTA'] = isset($json_decode['bdc_descripcion_cuenta']) ? $json_decode['bdc_descripcion_cuenta']['value'] : '-';
                    $parameters_json['DESTINATION'] = isset($json_decode['bdc_destination']) ? $json_decode['bdc_destination']['value'] : '-';
                    $parameters_json['BANCO'] = isset($json_decode['bdc_banco']) ? $json_decode['bdc_banco']['value'] : '-';
                    $parameters_json['DIVISA'] = isset($json_decode['bdc_divisa']) ? $json_decode['bdc_divisa']['value'] : '-';
                    $parameters_json['ACTION_ELIMINAR'] = isset($json_decode['bdc_action_eliminar']) ? $json_decode['bdc_action_eliminar']['value'] : '-';

                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'baja_de_cuentas_approved';
                        $subject      = __('sistema.notifications.short_message.baja_de_cuentas_approved');
                        $parameters_json['ESTATUS'] = 'approved';
                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'baja_de_cuentas_rejected';
                        $subject      = __('sistema.notifications.short_message.baja_de_cuentas_rejected');
                        $parameters_json['ESTATUS'] = 'rejected';
                    }

                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }

                break;

                case 42:
                
                    $short_message = 'entre_el_mis_broker';
                    $template_name = 'entre_el_mis_broker';
                    $subject      = __('sistema.notifications.short_message.entre_el_mis_broker');

                    $json_decode = json_decode($client_request->text, true);

                    $parameters_json['FROM_ACCOUNT'] = '-';
                    if(isset($json_decode['from_account'])){
                        $acc_arr = explode('-', $json_decode['from_account']['value']);
                        $acc_arr[0] = str_repeat('X', strlen($acc_arr[0]) - 4) . substr($acc_arr[0], -4);
                        $parameters_json['FROM_ACCOUNT'] = implode('-', $acc_arr);
                    }

                    //$parameters_json['FROM_ACCOUNT'] = isset($json_decode['from_account']) ? $json_decode['from_account']['value'] : '-';
                    $parameters_json['CURRENCY'] = isset($json_decode['currency']) ? $json_decode['currency']['value'] : '-';
                    $parameters_json['CURRENCY_SYMBOL'] = isset($json_decode['currency_symbol']) ? $json_decode['currency_symbol']['value'] : '';
                    $parameters_json['AMOUNT'] = isset($json_decode['amount']) ? $json_decode['amount']['value'] : 0;
                    $parameters_json['APPLICATION_DATE'] = isset($json_decode['application_date']) ? $json_decode['application_date']['value'] : '-';
                    $parameters_json['PAYMENT_ACCOUNT'] = '-';
                    if(isset($json_decode['payment_account'])){
                        $acc_arr = explode('-', $json_decode['payment_account']['value']);
                        $acc_arr[0] = str_repeat('X', strlen($acc_arr[0]) - 4) . substr($acc_arr[0], -4);
                        $parameters_json['PAYMENT_ACCOUNT'] = implode('-', $acc_arr);
                    }
                    //$parameters_json['PAYMENT_ACCOUNT'] = isset($json_decode['payment_account']) ? $json_decode['payment_account']['value'] : '-';

                    
                    if($client_request->request_status_id == 1){
                        $parameters_json['ESTATUS'] = 'request';
                    }
                    else if($client_request->request_status_id == 2){
                        $short_message = 'entre_el_mis_broker_approved';                        
                        $parameters_json['ESTATUS'] = 'approved';
                        $subject      = __('sistema.notifications.short_message.entre_el_mis_broker_approved');

                    }
                    else if($client_request->request_status_id == 3){
                        $short_message = 'entre_el_mis_broker_rejected';                        
                        $parameters_json['ESTATUS'] = 'rejected';
                        $subject      = __('sistema.notifications.short_message.entre_el_mis_broker_rejected');
                    }                    
                    
                    Notification::create([
                        'user_id'       => $user->id,
                        'short_message' => $short_message,
                        'parameters'    => json_encode($parameters_json),
                        'template_name' => $template_name,
                        'is_read'       => 0,
                    ]);

                    //send email
                    $current_lang = HelperUtil::get_currentlang();
                    //Mail to client
                    if($client_email)
                    {
                        Mail::to($client_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                    
                    //Mail to Broker
                    if(isset($broker_email) && $broker_email != '')
                    {
                        Mail::to($broker_email)->send(new NotificationMail('notifications.'. $current_lang .'.'. $template_name, $subject, $parameters_json));
                    }
                break;

                default:
            }
        }
        catch (\Exception $ex)
        {
            dd($ex->getMessage());
        }
    }

    public static function getFinanciamientos_activosTotal($account_id,$upto_date)
    {
        try
        {
            $movimientos_tpos = array('10', '1');

            $movimientos_total = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN movimientos_tipo_id = 10 THEN monto WHEN movimientos_tipo_id = 1 THEN - monto END),0) AS total_amount')
            ->where('account_id', $account_id)
            ->whereIn('movimientos_tipo_id', $movimientos_tpos)
            ->where('fecha_transaccion', '<=', $upto_date)
            ->first();

            //return 3;

            return $movimientos_total->total_amount;
        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }

    public static function getLineaDeCreditoTotal($account_id,$upto_date)
    {
        try
        {
            $movimientos_tpos = array('18');
            $movimientos_total = MovimientosTransaction::selectRaw('IFNULL(SUM(CASE WHEN movimientos_transactions.operation_category = 1 THEN movimientos_transactions.monto WHEN movimientos_transactions.operation_category = 0 THEN - movimientos_transactions.monto END),0) AS total_amount')
            ->where('account_id', $account_id)
            ->whereIn('movimientos_tipo_id', $movimientos_tpos)
            //->where('fecha_transaccion', '<=', $upto_date)
            ->first();

            return $movimientos_total->total_amount;
        }
        catch (\Exception $ex)
        {
            return 0;
        }
    }
}

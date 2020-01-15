<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountTransaction extends Model
{

    use SoftDeletes;

    public static function boot()
    {
        parent::boot();
        AccountTransaction::observe(new BaseObserver());
    }

    protected $fillable = [
        'account_id',
        'transaction_type_id',
        'instrument_id',
        'item_id',
        'leverage_id',
        'commission_fee_id',
        'ticket',
        'initial_capital',
        'opening_date',
        'closing_date',
        'opening_time',
        'closing_time',
        'opening_price',
        'closing_price',
        'conversion_opening',
        'conversion_closing',
        'spread',
        'financial_exhibition',
        'stop_loss',
        'commission',
        'contracts',
        'gross_profit',
        'facial_value',
        'net_result',
        'warranty',
        'final_capital_client',
    ];

    public function transaction_type()
    {
        return $this->belongsTo('App\Models\TransactionType');
    }

    public function instrument()
    {
        return $this->belongsTo('App\Models\Instrument');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\Item');
    }

    public function leverage()
    {
        return $this->belongsTo('App\Models\Leverage');
    }

    public function commission_fee()
    {
        return $this->belongsTo('App\Models\CommissionFee');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    protected $foreign_keys = [
        'account_id'          => [
            'model' => 'Account',
            'field' => 'account_number',
            'lang'  => false
        ],
        'transaction_type_id' => [
            'model' => 'TransactionType',
            'field' => 'type_',
            'lang'  => true
        ],
        'instrument_id'       => [
            'model' => 'Instrument',
            'field' => 'instrument_',
            'lang'  => true
        ],
        'item_id'             => [
            'model' => 'Item',
            'field' => 'item_',
            'lang'  => true
        ],
        'leverage_id'         => [
            'model' => 'Leverage',
            'field' => 'label',
            'lang'  => false
        ],
        'commission_fee_id'   => [
            'model' => 'CommissionFee',
            'field' => 'commission_fee',
            'lang'  => false
        ],
    ];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'account_id'           => __('sistema.client.acc_number'),
            'transaction_type_id'  => __('sistema.transaction.type'),
            'instrument_id'        => __('sistema.transaction.instrument'),
            'item_id'              => __('sistema.transaction.item'),
            'leverage_id'          => __('sistema.transaction.leverage'),
            'commission_fee_id'    => __('sistema.transaction.commission_fee'),
            'ticket'               => __('sistema.transaction.ticket'),
            'initial_capital'      => __('sistema.transaction.initial_capital'),
            'opening_date'         => __('sistema.transaction.opening_date'),
            'closing_date'         => __('sistema.transaction.closing_date'),
            'opening_time'         => __('sistema.transaction.opening_time'),
            'closing_time'         => __('sistema.transaction.closing_time'),
            'opening_price'        => __('sistema.transaction.opening_price'),
            'closing_price'        => __('sistema.transaction.closing_price'),
            'conversion_opening'   => __('sistema.transaction.conversion_opening'),
            'conversion_closing'   => __('sistema.transaction.conversion_closing'),
            'spread'               => __('sistema.transaction.spread'),
            'financial_exhibition' => __('sistema.transaction.financial_exhibition'),
            'stop_loss'            => __('sistema.transaction.stop_loss'),
            'commission'           => __('sistema.transaction.commission_fee'),
            'contracts'            => __('sistema.transaction.contracts'),
            'gross_profit'         => __('sistema.transaction.gross_profit'),
            'facial_value'         => __('sistema.transaction.facial_value'),
            'net_result'           => __('sistema.transaction.net_result'),
            'warranty'             => __('sistema.transaction.warranty'),
            'final_capital_client' => __('sistema.transaction.final_capital_client'),
        ];

        if ($key)
        {
            if (isset($arr[$key]))
            {
                return $arr[$key];
            }
            else
            {
                return $key;
            }
        }
        return $arr;
    }

}

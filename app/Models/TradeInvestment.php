<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class TradeInvestment extends Model
{

    public static function boot()
    {
        parent::boot();
        TradeInvestment::observe(new BaseObserver());
    }

    protected $fillable = [
        'account_id',
        'instrument_id',
        'ticket',
        'fecha',
        'tipo',
        'transaction',
        'fecha_vencimiento',
        'monto',
        'nav',
        'precio',
        'riesgo',
        'contratos',
        'exposicion',
        'is_opening'
    ];

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    protected $foreign_keys = [
        'account_id' => [
            'model' => 'Account',
            'field' => 'account_number',
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
            'account_id'        => __('sistema.client.acc_number'),
            'ticket'            => __('sistema.transaction.ticket'),
            'fecha'             => __('sistema.trade_investment.fecha'),
            'tipo'              => __('sistema.trade_investment.tipo'),
            'transaction'       => __('sistema.trade_investment.transaction'),
            'fecha_vencimiento' => __('sistema.trade_investment.fecha_vencimiento'),
            'monto'             => __('sistema.trade_investment.monto'),
            'nav'               => __('sistema.trade_investment.nav'),
            'precio'            => __('sistema.trade_investment.precio'),
            'riesgo'            => __('sistema.trade_investment.riesgo'),
            'contratos'         => __('sistema.trade_investment.contratos'),
            'exposicion'        => __('sistema.trade_investment.exposicion'),
            'is_opening'        => __('sistema.trade_investment.opening_balance'),
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

    public function instrument()
    {
        return $this->hasOne(Instrument::class, 'id', 'instrument_id');
    }

}

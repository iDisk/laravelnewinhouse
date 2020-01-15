<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class MovimientosTransaction extends Model
{

    public static function boot()
    {
        parent::boot();
        MovimientosTransaction::observe(new BaseObserver());
    }

    protected $fillable = [
        'account_id',
        'instrument_id',
        'monto',
        'fecha_transaccion',
        'fecha_valor',
        'movimientos_descripcion',
        'movimientos_tipo_id',
        'operation_category',
        'ticket',
        'reference_ticket'
    ];

    public function movimiento_tipo()
    {
        return $this->hasOne('App\Models\MovimientosTipo', 'id', 'movimientos_tipo_id');
    }

    protected $foreign_keys = [
        'account_id'          => [
            'model' => 'Account',
            'field' => 'account_number',
            'lang'  => false
        ],
        'instrument_id'       => [
            'model' => 'Instrument',
            'field' => 'instrument_',
            'lang'  => true
        ],
        'movimientos_tipo_id' => [
            'model' => 'MovimientosTipo',
            'field' => 'type_',
            'lang'  => true
        ],
    ];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'account_id'              => __('sistema.movimientos_transaction.account_number'),
            'instrument_id'           => __('sistema.movimientos_transaction.instruments'),
            'monto'                   => __('sistema.movimientos_transaction.monto'),
            'fecha_transaccion'       => __('sistema.movimientos_transaction.fecha_transaccion'),
            'fecha_valor'             => __('sistema.movimientos_transaction.fecha_valor'),
            'movimientos_descripcion' => __('sistema.movimientos_transaction.movimientos_descripcion'),
            'movimientos_tipo_id'     => __('sistema.movimientos_transaction.movimientos_tipo'),
            'operation_category'      => __('sistema.movimientos_transaction.category'),
            'ticket'                  => __('sistema.movimientos_transaction.ticket'),
            'reference_ticket'        => __('sistema.movimientos_transaction.reference_ticket'),
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

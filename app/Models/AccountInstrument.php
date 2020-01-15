<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountInstrument extends Model
{

    protected $fillable     = [
        'account_id',
        'instrument_id',
    ];
    protected $foreign_keys = [
        'account_id'    => [
            'model' => 'Account',
            'field' => 'account_number',
            'lang'  => false
        ],
        'instrument_id' => [
            'model' => 'Instrument',
            'field' => 'instrument_',
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
            'account_id'    => __('sistema.client.acc_number'),
            'instrument_id' => __('sistema.client.financial_service'),
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

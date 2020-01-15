<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class AccountFinancialService extends Model
{

    public static function boot()
    {
        parent::boot();
        AccountFinancialService::observe(new BaseObserver());
    }

    protected $fillable     = [
        'account_id',
        'financial_service_id',
    ];
    
    protected $foreign_keys = [
        'account_id'           => [
            'model' => 'Account',
            'field' => 'account_number',
            'lang'  => false
        ],
        'financial_service_id' => [
            'model' => 'FinancialService',
            'field' => 'service_',
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
            'account_id'           => __('sistema.client.acc_number'),
            'financial_service_id' => __('sistema.client.financial_service'),
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

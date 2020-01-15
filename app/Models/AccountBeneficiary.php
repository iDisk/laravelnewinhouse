<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class AccountBeneficiary extends Model
{

    public static function boot()
    {
        parent::boot();
        AccountBeneficiary::observe(new BaseObserver());
    }

    protected $fillable = [
        'account_id',
        'name',
        'percentage',
    ];
    
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
            'account_id' => __('sistema.client.acc_number'),
            'name'       => __('sistema.client.beneficiary_name'),
            'percentage' => __('sistema.client.beneficiary_percentage'),
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

<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class CommissionFee extends Model
{

    public static function boot()
    {
        parent::boot();
        CommissionFee::observe(new BaseObserver());
    }

    protected $fillable     = [
        'commission_fee',
        'active'
    ];
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'commission_fee' => __('sistema.transaction.commission_fee'),
            'active'         => __('sistema.users_status'),
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

<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class AccountReference extends Model
{

    public static function boot()
    {
        parent::boot();
        AccountReference::observe(new BaseObserver());
    }

    protected $fillable     = [
        'account_id',
        'name',
        'relationship',
        'telephone',
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
            'account_id'   => __('sistema.client.acc_number'),
            'name'         => __('sistema.client.reference1_name'),
            'relationship' => __('sistema.client.reference1_relationship'),
            'telephone'    => __('sistema.client.reference1_telephone'),
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

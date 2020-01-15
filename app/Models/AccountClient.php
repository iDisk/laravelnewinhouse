<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class AccountClient extends Model
{

    public static function boot()
    {
        parent::boot();
        AccountClient::observe(new BaseObserver());
    }

    protected $fillable     = [
        'account_id',
        'client_id'
    ];
    protected $foreign_keys = [
        'account_id' => [
            'model' => 'Account',
            'field' => 'account_number',
            'lang'  => false
        ],
        'client_id'  => [
            'model' => 'Client',
            'field' => 'first_name',
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
            'client_id'  => __('sistema.client.client_name'),
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

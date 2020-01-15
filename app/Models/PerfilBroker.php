<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class PerfilBroker extends Model
{

    public static function boot()
    {
        parent::boot();
        self::observe(new BaseObserver());
    }

    protected $fillable     = [
        'perfil_id', 'broker_id'
    ];
    protected $foreign_keys = [
        'perfil_id' => [
            'model' => 'Perfil',
            'field' => 'perfil',
            'lang'  => false
        ],
        'broker_id' => [
            'model' => 'Broker',
            'field' => 'broker',
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
            'perfil_id' => __('sistema.users_profile'),
            'broker_id' => __('sistema.broker.broker')
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

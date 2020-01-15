<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    public static function boot()
    {
        parent::boot();
        City::observe(new BaseObserver());
    }

    protected $fillable     = [
        'name', 'state_id',
    ];
    protected $foreign_keys = [
        'state_id' => [
            'model' => 'State',
            'field' => 'name',
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
            'name'     => __('sistema.client.entity_city'),
            'state_id' => __('sistema.client.entity_state'),
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

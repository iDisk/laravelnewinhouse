<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class BrokerClientMenu extends Model
{

    protected $fillable = [
        'client_menu_id', 'broker_id','order','parent'
    ];
    /*
    protected $foreign_keys = [
        'menu_id'   => [
            'model' => 'Menu',
            'field' => '',
            'lang'  => true
        ],
        'broker_id' => [
            'model' => 'Perfil',
            'field' => 'perfil',
            'lang'  => false
        ],
    ];
    */
/*
    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            '' => __(''),
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
    */

}

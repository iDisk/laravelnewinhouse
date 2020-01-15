<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class PerfilMenu extends Model
{

    public static function boot()
    {
        //parent::boot();
        //PerfilMenu::observe(new BaseObserver());
    }

    protected $fillable = [
        'menu_id', 'perfil_id',
    ];
    protected $foreign_keys = [
        'menu_id'   => [
            'model' => 'Menu',
            'field' => '',
            'lang'  => true
        ],
        'perfil_id' => [
            'model' => 'Perfil',
            'field' => 'perfil',
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

}

<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Leverage extends Model
{

    public static function boot()
    {
        parent::boot();
        Leverage::observe(new BaseObserver());
    }

    protected $fillable = [
        'label',
        'calc_value',
    ];
    
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'label'      => __('sistema.leverage.label'),
            'calc_value' => __('sistema.leverage.calc_value'),
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

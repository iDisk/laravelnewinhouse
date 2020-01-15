<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class MovimientosDescripcion extends Model
{

    public static function boot()
    {
        parent::boot();
        MovimientosDescripcion::observe(new BaseObserver());
    }

    protected $fillable = [
        'description_en', 'description_es'
    ];
    
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'description_en' => __('sistema.movimientos_desc.description_en'),
            'description_es' => __('sistema.movimientos_desc.description_es')            
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

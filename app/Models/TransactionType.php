<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{

    public static function boot()
    {
        parent::boot();
        TransactionType::observe(new BaseObserver());
    }

    protected $fillable = [
        'type_en', 'type_es'
    ];
    
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'type_en' => __('sistema.movimientos_tipo.type_en'),
            'type_es' => __('sistema.movimientos_tipo.type_es'),
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

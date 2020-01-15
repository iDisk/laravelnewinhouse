<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class FinancialService extends Model
{

    public static function boot()
    {
        parent::boot();
        FinancialService::observe(new BaseObserver());
    }

    protected $fillable = [
        'service_en', 'service_es'
    ];
    
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'service_en' => __('sistema.service.service_en'),
            'service_es' => __('sistema.service.service_es'),
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

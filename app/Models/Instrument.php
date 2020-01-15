<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{

    public static function boot()
    {
        parent::boot();
        Instrument::observe(new BaseObserver());
    }

    protected $fillable     = [
        'instrument_en',
        'instrument_es',
        'active'
    ];
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'instrument_en' => __('sistema.instrument.instrument_en'),
            'instrument_es' => __('sistema.instrument.instrument_es'),
            'active'        => __('sistema.users_status')
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

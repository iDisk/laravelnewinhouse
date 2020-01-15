<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    public static function boot()
    {
        parent::boot();
        Item::observe(new BaseObserver());
    }

    protected $fillable     = [
        'item_en',
        'item_es',
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
            'item_en' => __('sistema.item.item_en'),
            'item_es' => __('sistema.item.item_es'),
            'active'  => __('sistema.users_status')
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

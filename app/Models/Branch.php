<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    public static function boot()
    {
        parent::boot();
        Branch::observe(new BaseObserver());
    }

    protected $fillable = [
        'branch_en', 'branch_es', 'country_id', 'active'
    ];

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function getCountryCodeAttribute()
    {
        return $this->country->code;
    }

    protected $foreign_keys = [
        'country_id' => [
            'model' => 'Country',
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
            'branch_en'  => __('sistema.branches.branch_en'),
            'branch_es'  => __('sistema.branches.branch_es'),
            'country_id' => __('sistema.branches.country'),
            'active'     => __('sistema.users_status'),
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

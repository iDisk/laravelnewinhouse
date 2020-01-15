<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    public static function boot()
    {
        parent::boot();
        Country::observe(new BaseObserver());
    }

    protected $fillable = [
        'code', 'name', 'phonecode',
    ];

}

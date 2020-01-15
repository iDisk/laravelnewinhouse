<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{

    public static function boot()
    {
        parent::boot();
        State::observe(new BaseObserver());
    }

    protected $fillable = [
        'name', 'country_id',
    ];

}

<?php

namespace App\Models;

//use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class TicketCounter extends Model
{
/*
    public static function boot()
    {
        parent::boot();
        Item::observe(new BaseObserver());
    } */

    protected $fillable     = [
        'counter'
    ];
    
    /*protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }*/


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Push extends Model
{

    protected $fillable = ['user_id', 'device', 'token'];
    protected $table    = 'pushes';

}

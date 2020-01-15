<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientMenu extends Model
{

    //
    protected $fillable = [
        'menu','es','en','url', 'parent', 'active',
    ];

}

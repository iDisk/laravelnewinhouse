<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    //
    protected $fillable = [
        'menu', 'url', 'icon', 'parent', 'active', 'order',
    ];

}

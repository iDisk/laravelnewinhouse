<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserActionLog extends Model
{

    public function usuario()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function getUsuarioNameAttribute()
    {
        $usuario = $this->usuario;
        if ($usuario)
        {
            return $usuario->name;
        }
        return 'N/A';
    }

}

<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{

    public static function boot()
    {
        parent::boot();
        Perfil::observe(new BaseObserver());
    }

    protected $fillable = ['perfil'];

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }

    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'perfil' => __('sistema.users_profile'),
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
    
    public function brokers()
    {
        return $this->belongsToMany(Broker::class, 'perfil_brokers');
    }

}

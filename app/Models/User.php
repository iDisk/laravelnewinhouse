<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordToken;

class User extends Authenticatable
{

    use Notifiable;

    public static function boot()
    {
        parent::boot();
        User::observe(new BaseObserver());
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'perfil_id', 'status', 'password_changed','last_login_at','current_login_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function perfiles()
    {
        return $this->belongsTo(Perfil::class, 'perfil_id');
    }

    public function getisActiveAttribute()
    {
        return $this->status ? true : false;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    protected $foreign_keys = [
        'perfil_id' => [
            'model' => 'Perfil',
            'field' => 'perfil',
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
            'name'      => __('sistema.frm_user.field_name'),
            'email'     => __('sistema.frm_user.field_email'),
            'password'  => __('sistema.frm_user.field_pass1'),
            'perfil_id' => __('sistema.frm_user.field_profile')
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

    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }
    
    public function getAssignedBrokersAttribute()
    {
        return $this->perfiles->brokers()->select('brokers.id', 'brokers.broker')->get()->toArray();
    }
}

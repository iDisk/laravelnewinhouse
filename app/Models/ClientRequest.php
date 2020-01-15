<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class ClientRequest extends Model
{

    public static function boot()
    {
        parent::boot();
        City::observe(new BaseObserver());
    }

    protected $fillable     = [
        'file_number', 'user_id', 'account_id', 'request_status_id', 'request_type_id', 'from', 'text','status','comments','request_send_date'
    ];
    protected $foreign_keys = [
        'user_id'           => [
            'model' => 'User',
            'field' => 'name',
            'lang'  => false
        ],
        'account_id'        => [
            'model' => 'Account',
            'field' => 'account_number',
            'lang'  => false
        ],
        'request_status_id' => [
            'model' => 'RequestStatus',
            'field' => 'status_',
            'lang'  => true
        ],
    ];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'file_number'       => __('sistema.client_request.file_number'),
            'user_id'           => __('sistema.client_request.user_name'),
            'account_id'        => __('sistema.client_request.account_id'),
            'request_status_id' => __('sistema.users_status'),
            'request_type_id'   => __('sistema.client_request.request_type'),
            'from'              => __('sistema.client_request.from'),
            'text'              => __('sistema.client_request.text'),
            'status'            => __('sistema.client_request.status'),
            'comments'          => __('sistema.client_request.comments'),
            'request_send_date' => __('sistema.client_request.request_send_date'),
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

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function current_status()
    {
        return $this->hasOne(RequestStatus::class, 'id', 'request_status_id');
    }

    public function getTipoAttribute()
    {
        return config('site.client_request_type.' . $this->request_type_id . '.' . session('language'));
    }

    public function getCategoryAttribute()
    {
        return config('site.contact_us_category.' . $this->category_id . '.' . session('language'));
    }

}

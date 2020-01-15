<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class ClientFile extends Model
{

    public static function boot()
    {
        parent::boot();
        ClientFile::observe(new BaseObserver());
    }

    protected $fillable     = [
        'client_id',
        'name',
        'file',
    ];
    protected $foreign_keys = [
        'client_id' => [
            'model' => 'Client',
            'field' => 'first_name',
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
            'client_id' => __('sistema.client.client_name'),
            'name'      => __('File name'),
            'file'      => __('File temp name'),
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

}

<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class SecurityImage extends Model
{

    public static function boot()
    {
        parent::boot();
        SecurityImage::observe(new BaseObserver());
    }

    protected $fillable     = [
        'image', 'order', 'active'
    ];
    
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'image'  => __('sistema.security_image.image'),
            'order'  => __('Order'),
            'active' => __('sistema.users_status'),
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

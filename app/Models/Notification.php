<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable     = [
        'user_id',
        'short_message',
        'parameters',
        'template_name',
        'is_read'
    ];
    protected $foreign_keys = [
        'user_id' => [
            'model' => 'User',
            'field' => 'name',
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
            'user_id'       => __('sistema.notifications.user_id'),
            'short_message' => __('sistema.notifications.short_message'),
            'parameters'    => __('sistema.notifications.parameters'),
            'template_name' => __('sistema.notifications.template_name'),
            'is_read'       => __('sistema.notifications.is_read')
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

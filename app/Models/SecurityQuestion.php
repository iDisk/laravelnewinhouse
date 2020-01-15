<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class SecurityQuestion extends Model
{

    public static function boot()
    {
        parent::boot();
        SecurityQuestion::observe(new BaseObserver());
    }

    protected $fillable = [
        'question_en', 'question_es', 'question_type', 'order', 'active'
    ];
    
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'question_en'   => __('sistema.security_question.questionen'),
            'question_es'   => __('sistema.security_question.questiones'),
            'question_type' => __('sistema.security_question.question_type'),
            'order'         => __('Order'),
            'active'        => __('sistema.users_status')
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSecurity extends Model
{

    protected $fillable = [
        'user_id',
        'security_image_id',
        'security_question1_id',
        'answer1',
        'security_question2_id',
        'answer2',
        'security_question3_id',
        'answer3',
        'image_phrase',
    ];

}

<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class NationalIdentityDoc extends Model
{

    public static function boot()
    {
        parent::boot();
        NationalIdentityDoc::observe(new BaseObserver());
    }

    protected $fillable     = [
        'national_identity_en', 'national_identity_es'
    ];
    
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'national_identity_en' => __('sistema.client.national_identity_number'),
            'national_identity_es' => __('sistema.client.national_identity_number')
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

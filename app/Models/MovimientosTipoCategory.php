<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientosTipoCategory extends Model
{

    protected $fillable = [
        'category_en', 'category_es'
    ];
    
    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'category_en' => __('sistema.equity_report.equity'),
            'category_es' => __('sistema.equity_report.equity')            
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

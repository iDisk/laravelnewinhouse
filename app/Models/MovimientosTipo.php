<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class MovimientosTipo extends Model
{

    public static function boot()
    {
        parent::boot();
        MovimientosTipo::observe(new BaseObserver());
    }

    protected $fillable     = [
        'type_en', 'type_es', 'movimientos_tipo_category_id'
    ];
    protected $foreign_keys = [
        'movimientos_tipo_category_id' => [
            'model' => 'MovimientosTipoCategory',
            'field' => 'category_',
            'lang'  => true,
        ]
    ];

    public function mapping($key = null)
    {
        $arr = [
            'type_en'                      => __('sistema.movimientos_tipo.type_en'),
            'type_es'                      => __('sistema.movimientos_tipo.type_es'),
            'movimientos_tipo_category_id' => __('sistema.equity_report.equity'),
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

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function category()
    {
        return $this->hasOne('App\Models\MovimientosTipoCategory', 'id', 'movimientos_tipo_category_id');
    }

}

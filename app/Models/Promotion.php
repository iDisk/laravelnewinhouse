<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{

    public static function boot()
    {
        parent::boot();
        Broker::observe(new BaseObserver());
    }

    protected $fillable = [
        'broker_id', 'promo_title_en', 'promo_title_es', 'short_description_en', 'short_description_es', 'long_description_en', 'long_description_es', 'promo_image', 'estatus'
    ];

    public function broker()
    {
        return $this->hasOne(Broker::class, 'id', 'broker_id');
    }

    public static function rules($id = null)
    {
        $rules = [
            'promotion_title_en'             => 'required',
            'promotion_title_es'             => 'required',
            'promotion_short_description_en' => 'required',
            'promotion_short_description_es' => 'required',
            'promotion_long_description_en'  => 'required',
            'promotion_long_description_es'  => 'required',
            'promo_image'                    => 'required'
        ];

        if ($id)
        {
            unset($rules['promo_image']);
        }

        return $rules;
    }

    public static function messages()
    {
        return array(
            'promotion_title_en.required'             => __('sistema.promotions.required.promo_title_en'),
            'promotion_title_es.required'             => __('sistema.promotions.required.promo_title_es'),
            'promotion_short_description_en.required' => __('sistema.promotions.required.short_description_en'),
            'promotion_short_description_es.required' => __('sistema.promotions.required.short_description_es'),
            'promotion_long_description_en.required'  => __('sistema.promotions.required.long_description_en'),
            'promotion_long_description_es.required'  => __('sistema.promotions.required.long_description_es'),
            'promo_image.required'                    => __('sistema.promotions.required.promo_image')
        );
    }

}

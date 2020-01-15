<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{

    protected $table    = 'request_status';
    protected $fillable = [
        'status_en', 'status_es', 'color_code', 'active'
    ];

    public static function rules($id = null)
    {
        $rules = [
            'status_en'  => 'required|unique:request_status',
            'status_es'  => 'required|unique:request_status',
            'color_code' => 'required'
        ];

        if ($id)
        {
            $rules['status_en'] = 'required|unique:request_status,id,' . $id;
            $rules['status_es'] = 'required|unique:request_status,id,' . $id;
        }

        return $rules;
    }

    public static function messages()
    {
        return [
            'status_en.required' => __('sistema.estatus.required.estatus_en'),
            'status_es.required' => __('sistema.estatus.required.estatus_es'),
            'color_code'         => __('sistema.estatus.required.color_code'),
            'status_en.unique'   => __('sistema.estatus.required.unique_estatus_en'),
            'status_es.unique'   => __('sistema.estatus.required.unique_estatus_es'),
        ];
    }

}

<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class BusinessDetail extends Model
{

    public static function boot()
    {
        parent::boot();
        BusinessDetail::observe(new BaseObserver());
    }

    protected $fillable = [
        'account_id', 'registered_name', 'business_type', 'authorised_signatories1', 'authorised_signatories2', 'registration_number',
        'incorporation_date', 'incorporation_place', 'address', 'country', 'state', 'city', 'county', 'zip_code', 'industry_type',
        'employees', 'webiste', 'telephone1', 'telephone2', 'telephone3', 'email1', 'email2', 'branch_id'
    ];

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    protected $foreign_keys = [
        'account_id' => [
            'model' => 'Account',
            'field' => 'account_number',
            'lang'  => false
        ],
        'country'    => [
            'model' => 'Country',
            'field' => 'name',
            'lang'  => false
        ],
        'state'      => [
            'model' => 'State',
            'field' => 'name',
            'lang'  => false
        ],
        'city'       => [
            'model' => 'City',
            'field' => 'name',
            'lang'  => false
        ],
        'branch_id'  => [
            'model' => 'Branch',
            'field' => 'branch_',
            'lang'  => true
        ],
    ];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'account_id'              => __('sistema.client.acc_number'),
            'registered_name'         => __('sistema.client.registered_name'),
            'business_type'           => __('sistema.client.type_of_entity'),
            'authorised_signatories1' => __('sistema.client.authorised_signatories1'),
            'authorised_signatories2' => __('sistema.client.authorised_signatories2'),
            'registration_number'     => __('sistema.client.registration_number'),
            'incorporation_date'      => __('sistema.client.incorporation_date'),
            'incorporation_place'     => __('sistema.client.incorporation_place'),
            'address'                 => __('sistema.client.entity_address'),
            'country'                 => __('sistema.client.entity_county'),
            'state'                   => __('sistema.client.entity_state'),
            'city'                    => __('sistema.client.entity_city'),
            'county'                  => __('sistema.client.entity_county'),
            'zip_code'                => __('sistema.client.entity_zip_code'),
            'industry_type'           => __('sistema.client.entity_industry_type'),
            'employees'               => __('sistema.client.entity_employees'),
            'webiste'                 => __('sistema.client.entity_webiste'),
            'telephone1'              => __('sistema.client.entity_telephone1'),
            'telephone2'              => __('sistema.client.entity_telephone2'),
            'telephone3'              => __('sistema.client.entity_telephone3'),
            'email1'                  => __('sistema.client.entity_email1'),
            'email2'                  => __('sistema.client.entity_email2'),
            'branch_id'               => __('sistema.branches.branches')
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

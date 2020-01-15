<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    public static function boot()
    {
        parent::boot();
        Client::observe(new BaseObserver());
    }

    protected $fillable = [
        'user_id', 'first_name', 'middle_name', 'surname1', 'surname2', 'national_identity_doc_id', 'national_identity_number',
        'dob', 'gender', 'birth_place', 'birth_country', 'nationality', 'address', 'country', 'state', 'city', 'zip_code', 'county',
        'company', 'industry_type', 'occupation', 'marrital_status', 'spouse_name', 'telephone1', 'telephone2', 'telephone3',
        'email1', 'email2', 'client_type', 'branch_id'
    ];

    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->middle_name . '  ' . $this->surname1 . ' ' . $this->surname2);
    }

    public function country_name()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country');
    }

    public function state_name()
    {
        return $this->hasOne('App\Models\State', 'id', 'state');
    }

    public function city_name()
    {
        return $this->hasOne('App\Models\City', 'id', 'city');
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }
    
    public function accounts()
    {
        return $this->belongsToMany('App\Models\Account', 'account_clients');
    }
    
    public function getPrimaryAccountAttribute()
    {
        $account = $this->accounts->first();
        return $account;
    }
    
    public function getBrokerAttribute()
    {
        $account = $this->accounts->first();
        if($account)
        {
            $broker = $account->broker;
            $broker->setting;
            return $broker;
        }
        return null;        
    }

    protected $foreign_keys = [
        'user_id'                  => [
            'model' => 'User',
            'field' => 'name',
            'lang'  => false
        ],
        'national_identity_doc_id' => [
            'model' => 'NationalIdentityDoc',
            'field' => 'national_identity_',
            'lang'  => true
        ],
        'birth_country'            => [
            'model' => 'Country',
            'field' => 'name',
            'lang'  => false
        ],
        'country'                  => [
            'model' => 'Country',
            'field' => 'name',
            'lang'  => false
        ],
        'state'                    => [
            'model' => 'State',
            'field' => 'name',
            'lang'  => false
        ],
        'city'                     => [
            'model' => 'City',
            'field' => 'name',
            'lang'  => false
        ],
        'branch_id'                => [
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
            'user_id'                  => __('User name'),
            'first_name'               => __('sistema.client.first_name'),
            'middle_name'              => __('sistema.client.middle_name'),
            'surname1'                 => __('sistema.client.surname1'),
            'surname2'                 => __('sistema.client.surname2'),
            'national_identity_doc_id' => __('sistema.client.national_identity_doc'),
            'national_identity_number' => __('sistema.client.national_identity_number'),
            'dob'                      => __('sistema.client.dob'),
            'gender'                   => __('sistema.client.gender'),
            'birth_place'              => __('sistema.client.birth_place'),
            'birth_country'            => __('sistema.client.birth_country'),
            'nationality'              => __('sistema.client.nationality'),
            'address'                  => __('sistema.client.address'),
            'country'                  => __('sistema.client.country'),
            'state'                    => __('sistema.client.state'),
            'city'                     => __('sistema.client.city'),
            'zip_code'                 => __('sistema.client.zip_code'),
            'county'                   => __('sistema.client.county'),
            'company'                  => __('sistema.client.company'),
            'industry_type'            => __('sistema.client.industry_type'),
            'occupation'               => __('sistema.client.occupation'),
            'marrital_status'          => __('sistema.client.marrital_status'),
            'spouse_name'              => __('sistema.client.spouse_name'),
            'telephone1'               => __('sistema.client.telephone1'),
            'telephone2'               => __('sistema.client.telephone2'),
            'telephone3'               => __('sistema.client.telephone3'),
            'email1'                   => __('sistema.client.email1'),
            'email2'                   => __('sistema.client.email2'),
            'client_type'              => __('Client Type'),
            'branch_id'                => __('sistema.branches.branches')
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

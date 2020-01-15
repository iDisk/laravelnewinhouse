<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    public static function boot()
    {
        parent::boot();
        Account::observe(new BaseObserver());
    }

    protected $fillable     = [
        'broker_id',
        'account_number',
        'account_type',
        'credit_capability',
        'opening_amount',
        'date_of_transfer',
        'sender_bank',
        'fund_country',
        'clearing_house',
        'custodian_bank',
        'credit_line_facility',
        'sales',
        'manager',
        'customer_care',
        'analyst',
        'other1',
        'other2',
        'other3',
        'other4',
        'copy_of_id',
        'utility_bill',
        'bank_statement',
        'bank_transfer_voucher',
        'application',
        'biometric_signature',
        'contract',
        'credit_line',
        'other_documents1',
        'other_documents2',
        'other_documents3',
        'other_compliance_requirement',
        'opt_notification',
        'transfer_internal_account',
        'transfer_third_party_account',
        'transfer_international_account'
    ];
    protected $foreign_keys = [
        'broker_id'     => [
            'model' => 'Broker',
            'field' => 'broker',
            'lang'  => false
        ],
        'fund_country'  => [
            'model' => 'Country',
            'field' => 'name',
            'lang'  => false
        ],
        'sales'         => [
            'model' => 'User',
            'field' => 'name',
            'lang'  => false
        ],
        'manager'       => [
            'model' => 'User',
            'field' => 'name',
            'lang'  => false
        ],
        'customer_care' => [
            'model' => 'User',
            'field' => 'name',
            'lang'  => false
        ],
        'analyst'       => [
            'model' => 'User',
            'field' => 'name',
            'lang'  => false
        ],
    ];

    public function clients()
    {
        return $this->belongsToMany('App\Models\Client', 'account_clients');
    }

    public function getPrimaryClientAttribute()
    {
        return $this->clients()->where('clients.client_type', 1)->first();
    }

    public function broker()
    {
        return $this->hasOne('App\Models\Broker', 'id', 'broker_id');
    }

    public function branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    public function business_details()
    {
        return $this->hasOne('App\Models\BusinessDetail');
    }

    public function mapping($key = null)
    {
        $arr = [
            'broker_id'                      => __('sistema.client.broker'),
            'account_number'                 => __('sistema.client.acc_number'),
            'account_type'                   => __('sistema.client.type_of_acc'),
            'credit_capability'              => __('sistema.client.credit_capability'),
            'opening_amount'                 => __('sistema.client.opening_amount'),
            'date_of_transfer'               => __('sistema.client.date_of_transfer'),
            'sender_bank'                    => __('sistema.client.sender_bank'),
            'fund_country'                   => __('sistema.client.fund_country'),
            'clearing_house'                 => __('sistema.client.clearing_house'),
            'custodian_bank'                 => __('sistema.client.custodian_bank'),
            'credit_line_facility'           => __('sistema.client.credit_line_facility'),
            'sales'                          => __('sistema.client.sales'),
            'manager'                        => __('sistema.client.manager'),
            'customer_care'                  => __('sistema.client.customer_care'),
            'analyst'                        => __('sistema.client.analyst'),
            'other1'                         => __('istema.client.other1'),
            'other2'                         => __('istema.client.other2'),
            'other3'                         => __('istema.client.other3'),
            'other4'                         => __('istema.client.other4'),
            'copy_of_id'                     => __('sistema.client.due_diligence'),
            'utility_bill'                   => __('sistema.client.utility_bill'),
            'bank_statement'                 => __('sistema.client.bank_statement'),
            'bank_transfer_voucher'          => __('sistema.client.bank_transfer_voucher'),
            'application'                    => __('sistema.client.application'),
            'biometric_signature'            => __('sistema.client.biometric_signature'),
            'contract'                       => __('sistema.client.contract'),
            'credit_line'                    => __('sistema.client.credit_line'),
            'other_documents1'               => __('sistema.client.other_documents1'),
            'other_documents2'               => __('sistema.client.other_documents2'),
            'other_documents3'               => __('sistema.client.other_documents3'),
            'other_compliance_requirement'   => __('sistema.client.other_compliance_requirement'),
            'opt_notification'               => __('sistema.client.opt_notification'),
            'transfer_internal_account'      => __('sistema.client.transfer_internal_account'),
            'transfer_third_party_account'   => __('sistema.client.transfer_third_party_account'),
            'transfer_international_account' => __('sistema.client.transfer_international_account')
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

}

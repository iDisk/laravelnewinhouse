<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{

    public static function boot()
    {
        parent::boot();
        Broker::observe(new BaseObserver());
    }

    protected $fillable = [
        'broker', 'description', 'color', 'code', 'broker_url', 'active'
    ];

    protected $hidden = [
        'pivot'
    ];    
    
    public function setting()
    {
        return $this->hasOne('App\Models\Setting');
    }

    protected $foreign_keys = [];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'broker'      => __('sistema.broker.broker'),
            'description' => __('sistema.broker.description'),
            'color'       => __('sistema.broker.account_color'),
            'code'        => __('sistema.broker.account_code'),
            'active'      => __('sistema.users_status')
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

    public static function rules($id = null)
    {
        $rules = array(
            'broker'                         => 'required|unique:brokers',
            'broker_url'                     => 'required|unique:brokers,broker_url',
            'color'                          => 'required',
            'code'                           => 'required',
            'description'                    => 'required',
            'company_statement_logo'         => 'required',
            'contact_number'                 => 'required',
            'website_url'                    => 'required',
            'admin_email'                    => 'required',
            'admin_name'                     => 'required',
            'statement_legend'               => 'required',
            'statement_legend_color'         => 'required',
            'template_id'                    => 'required',
            'transfer_commission_percentage' => 'required',
            'transfer_commission_amount'     => 'required',
            'processing_fees_percentage'     => 'required',
            'processing_fees_amount'         => 'required',
            'menu_orientation'               => 'required',
            'brand_color_primary'            => 'required',
            'brand_color_seconday'           => 'required',
            'font_color_primary'             => 'required',
            'font_color_secondary'           => 'required',
            
            'disclaimer_es'                        => 'required',
            'footer_privacy_policy_es'             => 'required',
            'footer_tnc_es'                        => 'required',
            'footer_privacy_notice_es'             => 'required',
            'international_transfer_disclaimer_es' => 'required',
            'financing_request_disclaimer_es'      => 'required',
            'financing_request_tnc_es'             => 'required',
            'expand_financing_disclaimer_es'       => 'required',
            'expand_financing_tnc_es'              => 'required',
            'refinancing_disclaimer_es'            => 'required',
            'access_control_tnc_es'                => 'required',
            'accounts_administration_tnc_es'       => 'required',
            'adjust_permission_tnc_es'             => 'required',
            'send_documentation_disclaimer_es'     => 'required',
            'account_registration_disclaimer_es'   => 'required',
            
            'disclaimer_en'                        => 'required',
            'footer_privacy_policy_en'             => 'required',
            'footer_tnc_en'                        => 'required',
            'footer_privacy_notice_en'             => 'required',
            'international_transfer_disclaimer_en' => 'required',
            'financing_request_disclaimer_en'      => 'required',
            'financing_request_tnc_en'             => 'required',
            'expand_financing_disclaimer_en'       => 'required',
            'expand_financing_tnc_en'              => 'required',
            'refinancing_disclaimer_en'            => 'required',
            'access_control_tnc_en'                => 'required',
            'accounts_administration_tnc_en'       => 'required',
            'adjust_permission_tnc_en'             => 'required',
            'send_documentation_disclaimer_en'     => 'required',
            'account_registration_disclaimer_en'   => 'required',
            'support_team_email'                   => 'required'

        );

        if ($id)
        {
            $rules['broker']     = 'required|unique:brokers,id,' . $id;
            $rules['broker_url'] = 'required|unique:brokers,broker_url,' . $id;
            unset($rules['company_statement_logo']);
        }

        return $rules;
    }

    public static function messages()
    {
        return array(
            'broker_url.required'               => __('sistema.broker.required.broker_url'),
            'broker_url.unique'                 => __('sistema.broker.required.unique_broker_url'),
            'broker.required'                   => __('sistema.configuration.required.broker'),
            'unique.required'                   => __('sistema.configuration.required.unique_broker'),
            'color.required'                    => __('sistema.configuration.required.account_color'),
            'code.required'                     => __('sistema.configuration.required.account_code'),
            'description.required'              => __('sistema.configuration.required.description'),
            'company_statement_logo'            => __('sistema.configuration.required.company_statement_logo'),
            'contact_number'                    => __('sistema.configuration.required.contact_number'),
            'website_url'                       => __('sistema.configuration.required.website_url'),
            'admin_email'                       => __('sistema.configuration.required.admin_email'),
            'admin_name'                        => __('sistema.configuration.required.admin_name'),
            'statement_legend'                  => __('sistema.configuration.required.statement_legend'),
            'statement_legend_color'            => __('sistema.configuration.required.statement_legend_color'),
            'template_id'                       => __('sistema.configuration.required.template_id'),
            
            'menu_orientation'                  => __('sistema.configuration.required.menu_orientation'),
            'brand_color_primary'               => __('sistema.configuration.required.brand_color_primary'),
            'brand_color_seconday'              => __('sistema.configuration.required.brand_color_seconday'),
            'font_color_primary'                => __('sistema.configuration.required.font_color_primary'),
            'font_color_secondary'              => __('sistema.configuration.required.font_color_secondary'),
            
            'disclaimer_es'                        => __('sistema.configuration.required.disclaimer_es'),
            'footer_privacy_policy_es'             => __('sistema.configuration.required.footer_privacy_policy_es'),
            'footer_tnc_es'                        => __('sistema.configuration.required.footer_tnc_es'),
            'footer_privacy_notice_es'             => __('sistema.configuration.required.footer_privacy_notice_es'),
            'international_transfer_disclaimer_es' => __('sistema.configuration.required.international_transfer_disclaimer_es'),
            'financing_request_disclaimer_es'      => __('sistema.configuration.required.financing_request_disclaimer_es'),
            'financing_request_tnc_es'             => __('sistema.configuration.required.financing_request_tnc_es'),
            'expand_financing_disclaimer_es'       => __('sistema.configuration.required.expand_financing_disclaimer_es'),
            'expand_financing_tnc_es'              => __('sistema.configuration.required.expand_financing_tnc_es'),
            'refinancing_disclaimer_es'            => __('sistema.configuration.required.refinancing_disclaimer_es'),
            'access_control_tnc_es'                => __('sistema.configuration.required.access_control_tnc_es'),
            'accounts_administration_tnc_es'       => __('sistema.configuration.required.accounts_administration_tnc_es'),
            'adjust_permission_tnc_es'             => __('sistema.configuration.required.adjust_permission_tnc_es'),
            'account_registration_disclaimer_es'   => __('sistema.configuration.required.account_registration_disclaimer_es'),
            
            'disclaimer_en'                        => __('sistema.configuration.required.disclaimer_en'),
            'footer_privacy_policy_en'             => __('sistema.configuration.required.footer_privacy_policy_en'),
            'footer_tnc_en'                        => __('sistema.configuration.required.footer_tnc_en'),
            'footer_privacy_notice_en'             => __('sistema.configuration.required.footer_privacy_notice_en'),
            'international_transfer_disclaimer_en' => __('sistema.configuration.required.international_transfer_disclaimer_en'),
            'financing_request_disclaimer_en'      => __('sistema.configuration.required.financing_request_disclaimer_en'),
            'financing_request_tnc_en'             => __('sistema.configuration.required.financing_request_tnc_en'),
            'expand_financing_disclaimer_en'       => __('sistema.configuration.required.expand_financing_disclaimer_en'),
            'expand_financing_tnc_en'              => __('sistema.configuration.required.expand_financing_tnc_en'),
            'refinancing_disclaimer_en'            => __('sistema.configuration.required.refinancing_disclaimer_en'),
            'access_control_tnc_en'                => __('sistema.configuration.required.access_control_tnc_en'),
            'accounts_administration_tnc_en'       => __('sistema.configuration.required.accounts_administration_tnc_en'),
            'adjust_permission_tnc_en'             => __('sistema.configuration.required.adjust_permission_tnc_en'),
            'account_registration_disclaimer_en'   => __('sistema.configuration.required.account_registration_disclaimer_en'),
            'support_team_email'                   => __('sistema.configuration.required.support_team_email')
        );
    }

}

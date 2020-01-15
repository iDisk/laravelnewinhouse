<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    public static function boot()
    {
        parent::boot();
        Setting::observe(new BaseObserver());
    }

    protected $fillable     = [
        'broker_id', 'company_statement_logo', 'contact_number',
        'transfer_commission_percentage',
        'transfer_commission_amount',
        'processing_fees_percentage',
        'processing_fees_amount',
        'website_url', 'admin_email', 'admin_name',
        'statement_legend', 'statement_legend_color', 'disclaimer_es', 'disclaimer_en', 'template_id',
        'menu_orientation', 'brand_color_primary', 'brand_color_seconday', 'font_color_primary',
        'font_color_secondary',
        'footer_privacy_policy_es',
        'footer_privacy_policy_en',
        'footer_tnc_es',
        'footer_tnc_en',
        'footer_privacy_notice_es',
        'footer_privacy_notice_en',
        'international_transfer_disclaimer_es',
        'international_transfer_disclaimer_en',
        'financing_request_disclaimer_es',
        'financing_request_disclaimer_en',
        'financing_request_tnc_es',
        'financing_request_tnc_en',
        'expand_financing_disclaimer_es',
        'expand_financing_disclaimer_en',
        'expand_financing_tnc_es',
        'expand_financing_tnc_en',
        'refinancing_disclaimer_es',
        'refinancing_disclaimer_en',
        'access_control_tnc_es',
        'access_control_tnc_en',
        'accounts_administration_tnc_es',
        'accounts_administration_tnc_en',
        'adjust_permission_tnc_es',
        'adjust_permission_tnc_en',
        'send_documentation_disclaimer_es',
        'send_documentation_disclaimer_en',
        'account_registration_disclaimer_es',
        'account_registration_disclaimer_en',
        'support_team_email'
    ];
    protected $foreign_keys = [
        'broker_id' => [
            'model' => 'Broker',
            'field' => 'broker',
            'lang'  => false
        ],
    ];

    public function getFkeys()
    {
        return $this->foreign_keys;
    }

    public function mapping($key = null)
    {
        $arr = [
            'broker_id'                            => __('sistema.broker.broker'),
            'company_statement_logo'               => __('sistema.configuration.statement_logo'),
            'contact_number'                       => __('sistema.configuration.contact_number'),
            'transfer_commission_percentage'       => __('sistema.configuration.transfer_commission_percentage'),
            'transfer_commission_amount'           => __('sistema.configuration.transfer_commission_amount'),
            'processing_fees_percentage'           => __('sistema.configuration.processing_fees_percentage'),
            'processing_fees_amount'               => __('sistema.configuration.processing_fees_amount'),
            'website_url'                          => __('sistema.configuration.website_url'),
            'admin_email'                          => __('sistema.configuration.admin_email'),
            'admin_name'                           => __('sistema.configuration.admin_name'),
            'statement_legend'                     => __('sistema.configuration.statement_legend'),
            'statement_legend_color'               => __('sistema.configuration.statement_legend_color'),
            'template_id'                          => __('sistema.configuration.template'),
            'menu_orientation'                     => __('sistema.configuration.menu_orientation'),
            'brand_color_primary'                  => __('sistema.configuration.brand_color_primary'),
            'brand_color_seconday'                 => __('sistema.configuration.brand_color_seconday'),
            'font_color_primary'                   => __('sistema.configuration.font_color_primary'),
            'font_color_secondary'                 => __('sistema.configuration.font_color_secondary'),            
            'disclaimer_es'                        => __('sistema.configuration.disclaimer_es'),
            'disclaimer_en'                        => __('sistema.configuration.disclaimer_en'),
            'footer_privacy_policy_es'             => __('sistema.configuration.footer_privacy_policy_es'),
            'footer_privacy_policy_en'             => __('sistema.configuration.footer_privacy_policy_en'),
            'footer_tnc_es'                        => __('sistema.configuration.footer_tnc_es'),
            'footer_tnc_en'                        => __('sistema.configuration.footer_tnc_en'),
            'footer_privacy_notice_es'             => __('sistema.configuration.footer_privacy_notice_es'),
            'footer_privacy_notice_en'             => __('sistema.configuration.footer_privacy_notice_en'),
            'international_transfer_disclaimer_es' => __('sistema.configuration.international_transfer_disclaimer_es'),
            'international_transfer_disclaimer_en' => __('sistema.configuration.international_transfer_disclaimer_en'),
            'financing_request_disclaimer_es'      => __('sistema.configuration.financing_request_disclaimer_es'),
            'financing_request_disclaimer_en'      => __('sistema.configuration.financing_request_disclaimer_en'),
            'financing_request_tnc_es'             => __('sistema.configuration.financing_request_tnc_es'),
            'financing_request_tnc_en'             => __('sistema.configuration.financing_request_tnc_en'),
            'expand_financing_disclaimer_es'       => __('sistema.configuration.expand_financing_disclaimer_es'),
            'expand_financing_disclaimer_en'       => __('sistema.configuration.expand_financing_disclaimer_en'),
            'expand_financing_tnc_es'              => __('sistema.configuration.expand_financing_tnc_es'),
            'expand_financing_tnc_en'              => __('sistema.configuration.expand_financing_tnc_en'),
            'refinancing_disclaimer_es'            => __('sistema.configuration.refinancing_disclaimer_es'),
            'refinancing_disclaimer_en'            => __('sistema.configuration.refinancing_disclaimer_en'),
            'access_control_tnc_es'                => __('sistema.configuration.access_control_tnc_es'),
            'access_control_tnc_en'                => __('sistema.configuration.access_control_tnc_en'),
            'accounts_administration_tnc_es'       => __('sistema.configuration.accounts_administration_tnc_es'),
            'accounts_administration_tnc_en'       => __('sistema.configuration.accounts_administration_tnc_en'),
            'adjust_permission_tnc_es'             => __('sistema.configuration.adjust_permission_tnc_es'),
            'adjust_permission_tnc_en'             => __('sistema.configuration.adjust_permission_tnc_en'),
            'send_documentation_disclaimer_es'     => __('sistema.configuration.send_documentation_disclaimer_es'),
            'send_documentation_disclaimer_en'     => __('sistema.configuration.send_documentation_disclaimer_en'),
            'account_registration_disclaimer_es'   => __('sistema.configuration.account_registration_disclaimer_es'),
            'account_registration_disclaimer_en'   => __('sistema.configuration.account_registration_disclaimer_en'),
            'support_team_email'                   => __('sistema.configuration.support_team_email')
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

<?php

namespace App\Models;

use App\Observers\BaseObserver;
use Illuminate\Database\Eloquent\Model;

class ClientFinancialService extends Model
{

    public static function boot()
    {
        parent::boot();
        ClientFinancialService::observe(new BaseObserver());
    }

    protected $fillable = [
        'client_id',
        'financial_service_id',
    ];

}

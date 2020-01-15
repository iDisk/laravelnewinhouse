<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOtherAccount extends Model
{

    protected $fillable = [
        'user_id',
        'type_of_recipient',
        'destination_type',
        'instrument_id',
        'first_name',
        'telephone',
        'address',
        'country',
        'state',
        'city',
        'dest_bank_country',
        'dest_account_number',
        'dest_swift',
        'dest_bank_name',
        'dest_bank_address',
        'intermediary_banking',
        'intermediary_bank_country',
        'intermediary_bank_account',
        'intermediary_swift',
        'intermediary_bank_name',
        'intermediary_bank_address',
    ];

}

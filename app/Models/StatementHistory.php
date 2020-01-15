<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatementHistory extends Model
{

    protected $fillable = ['type', 'account_id', 'file_path', 'from_period', 'upto_period', 'generated_by'];

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

}

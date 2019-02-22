<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Transaction extends Model
{
    use Userstamps;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function finishedByUser()
    {
        return $this->belongsTo('App\User', 'finished_by');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Models\Companies\Company', 'transaction_company')->withPivot('company_type');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function stages()
    {
        return $this->hasMany('App\Models\Stages\Stage');
    }
}

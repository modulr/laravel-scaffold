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

    public function stages()
    {
        return $this->hasMany('App\Models\Stages\Stage'::class);
    }

    public function finishedByUser()
    {
        return $this->belongsTo('App\User', 'finished_by');
    }
}

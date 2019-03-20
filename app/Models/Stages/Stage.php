<?php

namespace App\Models\Stages;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Stage extends Model
{
    use Userstamps;
    //use SoftDeletes;
    //protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function authorizedByUser()
    {
        return $this->belongsTo('App\User', 'authorized_by');
    }

    public function files()
    {
        return $this->hasMany('App\Models\Files\File')->latest();
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comments\Comment')->latest();
    }
}

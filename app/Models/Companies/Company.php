<?php

namespace App\Models\Companies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Company extends Model
{
    use Userstamps;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
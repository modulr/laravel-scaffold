<?php

namespace App\Models\Comments;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Comment extends Model
{
    use Userstamps;
    //use SoftDeletes;
    //protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
}

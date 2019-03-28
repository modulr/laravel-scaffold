<?php

namespace App\Models\Codes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
}

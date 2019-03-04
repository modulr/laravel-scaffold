<?php

namespace App\Models\Files;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;
use Storage;

class File extends Model
{
    use Userstamps;
    //use SoftDeletes;
    //protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected $appends = ['url'];

    public function getUrlAttribute()
    {
        return Storage::url('files/'.$this->stage_id.'/'.$this->basename);
    }
}

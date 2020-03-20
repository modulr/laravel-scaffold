<?php

namespace App\Models\Personalities;

use Illuminate\Database\Eloquent\Model;

class PersonalitiesResult extends Model
{
    protected $guarded = ['id'];

    public function personality()
    {
        return $this->belongsTo('App\Models\Personalities\Personality');
    }

}

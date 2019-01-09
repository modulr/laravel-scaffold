<?php

namespace App\Models\Companies;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = ['id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

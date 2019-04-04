<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Order extends Model
{
    use Userstamps;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function status()
    {
        return $this->belongsTo('App\Models\Orders\OrderStatus');
    }

    public function code()
    {
        return $this->belongsTo('App\Models\Codes\Code');
    }

    public function client()
    {
        return $this->belongsTo('App\User');
    }

    public function dealer()
    {
        return $this->belongsTo('App\User');
    }
}

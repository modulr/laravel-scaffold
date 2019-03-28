<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $table = 'order_status';
}

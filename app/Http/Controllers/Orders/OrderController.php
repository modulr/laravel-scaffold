<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders\Order;
use App\User;

class OrderController extends Controller
{
    public function byUser ($userId)
    {
        $user = User::find($userId);
        $ifDealer = $user->hasRole('dealer');

        if ($ifDealer) {
            return Order::with('status', 'code', 'creator')->where('dealer_id', $userId)->latest()->get();
        } else {
            return Order::with('status', 'code', 'dealer')->where('created_by', $userId)->latest()->get();
        }
    }

    public function show ($orderId)
    {
        return Order::with('status', 'code', 'creator')->findOrFail($orderId);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'order' => 'required|string',
            'address.title' => 'required|string'
        ]);

        return Order::create([
            'order' => $request->order,
            'address' => $request->address['title'],
            'status_id' => 1
        ]);
    }
}

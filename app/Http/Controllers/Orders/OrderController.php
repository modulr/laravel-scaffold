<?php

namespace App\Http\Controllers\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Orders\Order;
use App\Models\Orders\OrderStatus;
use App\Models\Rates\Rate;
use App\User;
use Validator;
use Illuminate\Validation\Rule;
use DB;
use Carbon\Carbon;
use App\Notifications\NewOrder;
use App\Notifications\UpdateOrder;
use App\Notifications\TakeOrder;
use App\Notifications\UntakeOrder;
use App\Notifications\FinalizeOrder;
use App\Notifications\CancelOrder;

class OrderController extends Controller
{
    public function filters (Request $request)
    {
        $query = Order::query();

        if(!empty($request->date)) {
            $date = $request->date;
        } else {
            $date = Carbon::today();
        }

        //return $date;

        $profit = DB::table('orders')->whereDate('created_at', $date)->sum('delivery_costs');

        if(!empty($request->status)) {
            $collection = collect($request->status);
            $plucked = $collection->pluck('id');
            $ids = $plucked->all();
            $query->whereIn('status_id', $ids);
            $profit = DB::table('orders')->whereIn('status_id', $ids)->whereDate('created_at', $date)->sum('delivery_costs');
        }

        if(!empty($request->dealers)) {
            $collection = collect($request->dealers);
            $plucked = $collection->pluck('id');
            $ids = $plucked->all();
            $query->whereIn('dealer_id', $ids);
            $profit = DB::table('orders')->whereIn('dealer_id', $ids)->whereDate('created_at', $date)->sum('delivery_costs');
        }

        $orders = $query->whereDate('created_at', $date)->latest()->get();

        $orders->load('status', 'client', 'dealer');

        return ['orders' => $orders, 'profit' => $profit];
    }

    public function all ()
    {
        return Order::with('status', 'client', 'dealer')->latest()->get();
    }

    public function availables ()
    {
        $ordersCount = Order::where('dealer_id', Auth::id())->where('status_id', 2)->count();
        if ($ordersCount > 0) {
            $orders = Order::with('status', 'client')->where('dealer_id', Auth::id())->where('status_id', 2)->oldest()->get();
            $orders = $orders->concat(Order::with('status', 'client')->where('status_id', 1)->oldest()->get());
            return $orders;
        } else {
            return Order::with('status', 'client')->where('status_id', 1)->oldest()->get();
        }
    }

    public function availablesCount ()
    {
        return Order::where('status_id', 1)->count();
    }

    public function byClient ($userId)
    {
        return Order::with('status', 'dealer')->where('client_id', $userId)->latest()->get();
    }

    public function byDealer ($userId)
    {
        $profit = DB::table('orders')->where('dealer_id', $userId)->whereDate('created_at', Carbon::today())->sum('delivery_costs');
        $orders = Order::with('status', 'client')->where('dealer_id', $userId)->whereDate('created_at', Carbon::today())->latest()->get();

        return ['orders' => $orders, 'profit' => $profit];
    }

    public function show ($orderId)
    {
        return Order::with('status', 'client', 'dealer')->findOrFail($orderId);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'order' => 'required|string',
            'address' => 'required|array',
            'client' => 'required|array',
            'delivery_costs' => 'required|numeric'
        ]);

        if ($request->dealer) {
            $status = 2;
        } else {
            $status = 1;
        }

        $order = Order::create([
            'order' => $request->order,
            'origin' => $request->client['store'] ? $request->client['address'] : '',
            'address' => $request->address['address'],
            'status_id' => $status,
            'client_id' => $request->client['id'],
            'dealer_id' => $request->dealer['id'],
            'rate' => Rate::latest()->first()->rate,
            'delivery_costs' => $request->delivery_costs
        ]);

        Auth::user()->notify(new NewOrder($order));

        return $this->show($order->id);
    }

    public function storeAuth (Request $request)
    {
        $this->validate($request, [
            'order' => 'required|string',
            'address' => 'required|string',
            //'cellphone' => 'numeric|nullable'
        ]);

        Validator::make($request->all(), [
            'cellphone' => Rule::requiredIf($request->user()->cellphone == null),
        ])->validate();

        if ($request->cellphone) {
            $user = User::find(Auth::id());
            $user->cellphone = $request->cellphone;
            $user->save();
        }

        $user = Auth::user();

        $order = Order::create([
            'order' => $request->order,
            'origin' => $user->store ? $user->address : '',
            'address' => $request->address,
            'status_id' => 1,
            'client_id' => Auth::id(),
            'rate' => Rate::latest()->first()->rate,
            'delivery_costs' => Rate::latest()->first()->rate
        ]);

        Auth::user()->notify(new NewOrder($order));

        // Send more than one
        // $users = User::role('superadmin', 'admin', 'dealer')->get();
        // Notification::send($users, new NewOrder($message));

        return $order;
    }

    public function update ($orderId, Request $request)
    {
        $this->validate($request, [
            'order' => 'required|string',
            'delivery_costs' => 'required|numeric'
        ]);

        $order = Order::find($orderId);
        $order->order = $request->order;
        $order->delivery_costs = $request->delivery_costs;
        $order->save();

        Auth::user()->notify(new UpdateOrder($order));

        return $this->show($order->id);
    }

    public function updateStatus ($orderId, Request $request)
    {
        $this->validate($request, [
            'statusId' => 'required|integer'
        ]);

        $order = Order::find($orderId);

        if ($order->status_id != $request->statusId) {
            $order->status_id = $request->statusId;
        }

        $order->save();

        if ($order->status_id == 3) {
            Auth::user()->notify(new FinalizeOrder($order));
        }

        if ($order->status_id == 4) {
            Auth::user()->notify(new CancelOrder($order));
        }

        return $this->show($order->id);
    }

    public function updateScoreClient ($orderId, Request $request)
    {
        $this->validate($request, [
            'scoreClient' => 'required|integer'
        ]);

        $order = Order::find($orderId);

        if ($order->score_client != $request->scoreClient) {
            $order->score_client = $request->scoreClient;
        }

        $order->save();

        $user = User::find($order->dealer_id);
        $user->orders_total++;
        $user->score_sum = $user->score_sum + $request->scoreClient;
        $user->score = $user->score_sum / $user->orders_total;
        $user->save();

        return $order;
    }

    public function updateScoreDealer ($orderId, Request $request)
    {
        $this->validate($request, [
            'scoreDealer' => 'required|integer'
        ]);

        $order = Order::find($orderId);

        if ($order->score_dealer != $request->scoreDealer) {
            $order->score_dealer = $request->scoreDealer;
        }

        $order->save();

        $user = User::find($order->client_id);
        $user->orders_total++;
        $user->score_sum = $user->score_sum + $request->scoreDealer;
        $user->score = $user->score_sum / $user->orders_total;
        $user->save();

        return $order;
    }

    public function takeOrder ($orderId, Request $request)
    {
        $ordersCount = Order::where('dealer_id', Auth::id())->where('status_id', 2)->count();
        if ($ordersCount > 0) {
            return response()->json(['errors' => ['finalize'=> ['Finalize order to take more']]], 422);
        }

        $order = Order::find($orderId);

        if ($order->status_id == 1) {
          $order->status_id = 2;
          $order->dealer_id = Auth::id();
          $order->save();

          Auth::user()->notify(new TakeOrder($order));

          return $order;
        } else {
          return response()->json(['errors' => ['taken'=> ['The order is already taken']]], 422);
        }
    }

    public function assignDealer ($orderId, Request $request)
    {
        // $this->validate($request, [
        //     'dealer' => 'required'
        // ]);

        $order = Order::find($orderId);

        if ($request->dealer) {
            $order->dealer_id = $request->dealer['id'];
            $order->status_id = 2;
            $order->save();
            Auth::user()->notify(new TakeOrder($order));
        } else {
            $order->dealer_id = null;
            $order->status_id = 1;
            $order->save();
            Auth::user()->notify(new UntakeOrder($order));
        }

        return $this->show($order->id);
    }

    public function status ()
    {
        return OrderStatus::orderBy('id', 'asc')->get();
    }
}

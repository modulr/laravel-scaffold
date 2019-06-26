<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Stores\Store;

class StoreOldController extends Controller
{
    public function all (Request $request)
    {
        return Store::orderBy('store')->get();
    }

    public function filter (Request $request)
    {
        $query = Store::query();

        if($request->search) {
            $query->where('store', 'LIKE', '%'.$request->search.'%');
            $query->orWhere('phone', 'LIKE', '%'.$request->search.'%');
            $query->orWhere('cellphone', 'LIKE', '%'.$request->search.'%');
        }

        return $query->get();
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'store' => 'required|string',
            'phone' => 'required|string'
        ]);

        return Store::create([
            'store' => $request->store,
            'address' => $request->address,
            'description' => $request->description,
            'phone' => $request->phone,
            'cellphone' => $request->cellphone,
            'web' => $request->web,
            'link' => $request->link,
        ]);
    }

    public function update ($storeId, Request $request)
    {
        $this->validate($request, [
            'store' => 'required|string',
            'phone' => 'required|string'
        ]);

        $store = Store::find($storeId);
        $store->store = $request->store;
        $store->address = $request->address;
        $store->description = $request->description;
        $store->phone = $request->phone;
        $store->cellphone = $request->cellphone;
        $store->web = $request->web;
        $store->link = $request->link;
        $store->save();

        return $store;
    }

    public function updateScore ($storeId, Request $request)
    {
        $this->validate($request, [
            'score' => 'required|integer'
        ]);

        $store = Store::find($storeId);
        if ($store->score != $request->score) {
            $store->score = $request->score;
        }
        $store->save();

        return $store;
    }

    public function destroy ($store)
    {
        return Store::destroy($store);
    }
}

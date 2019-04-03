<?php

namespace App\Http\Controllers\Address;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function byClient ($clientId = null)
    {
        if (!$clientId) {
            $clientId = Auth::id();
        }

        return Address::where('client_id', $clientId)->latest()->get();
    }

    public function store ($clientId = null, Request $request)
    {
        $this->validate($request, [
            'address' => 'required|string',
            'alias' => 'string'
        ]);

        if (!$clientId) {
            $clientId = Auth::id();
        }

        return Address::create([
            'address' => $request->address,
            'alias' => $request->alias,
            'client_id' => $clientId
        ]);
    }

    public function destroy ($address)
    {
        return Address::destroy($address);
    }
}

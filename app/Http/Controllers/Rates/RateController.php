<?php

namespace App\Http\Controllers\Rates;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rates\Rate;

class RateController extends Controller
{
    public function all()
    {
        return Rate::latest()->get();
    }

    public function day ()
    {
        return Rate::latest()->first();
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'rate' => 'required|numeric'
        ]);

        return Rate::create([
            'rate' => $request->rate
        ]);
    }
}

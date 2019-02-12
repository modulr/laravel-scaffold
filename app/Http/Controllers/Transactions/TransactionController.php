<?php

namespace App\Http\Controllers\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Transactions\Transaction;

class TransactionController extends Controller
{
    public function filter (Request $request)
    {
        $query = Transaction::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $transactions = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->paginate($request->input('pagination.per_page'));

        $transactions->load('stages');

        return $transactions;
    }

    public function show ($transaction)
    {
        return Transaction::with('finishedByUser', 'stages.authorizedByUser', 'stages.files')->findOrFail($transaction);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);

        return Transaction::create([
            'name' => $request->name
        ]);
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $transaction = Transaction::find($request->id);

        if ($transaction->name != $request->name) {
            $transaction->name = $request->name;
            $transaction->save();
        }

        return $transaction;
    }

    public function destroy ($transaction)
    {
        return Transaction::destroy($transaction);
    }

    public function count ()
    {
        return Transaction::count();
    }

    public function toggleFinished (Request $request)
    {
        $this->validate($request, [
            'finished' => 'required|boolean'
        ]);

        $transaction = Transaction::find($request->id);

        if ($transaction->finished != $request->finished) {
            $transaction->finished = $request->finished;
            if ($request->finished) {
                $transaction->finished_by = Auth::id();
            } else {
                $transaction->finished_by = null;
            }
            $transaction->save();
        }

        return $this->show($transaction->id);
    }
}

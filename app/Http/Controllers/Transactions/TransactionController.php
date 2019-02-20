<?php

namespace App\Http\Controllers\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Transactions\Transaction;
use App\User;

class TransactionController extends Controller
{
    public function show ($transaction)
    {
        return Transaction::with('finishedByUser', 'companyImport.users', 'companyExport.users', 'customsImport.users', 'customsExport.users', 'stages.authorizedByUser', 'stages.files.creator', 'stages.comments.creator')->findOrFail($transaction);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'company_import_id' => 'required|integer',
            'company_export_id' => 'required|integer',
            'customs_import_id' => 'required|integer',
            'customs_export_id' => 'required|integer'
        ]);

        $transaction = Transaction::create([
            'name' => $request->name,
            'company_import_id' => $request->company_import_id,
            'company_export_id' => $request->company_export_id,
            'customs_import_id' => $request->customs_import_id,
            'customs_export_id' => $request->customs_export_id
        ]);

        $users = User::whereIn('company_id', [$request->company_import_id, $request->company_export_id, $request->customs_import_id, $request->customs_export_id])->get();

        foreach ($users as $key => $value) {
            $value->transactions()->attach($transaction->id);
        }

        $transaction->stages()->createMany([
            [
                'name' => 'Proforma Impo',
                'transaction_id' => $transaction->id
            ],
            [
                'name' => 'Proforma Expo',
                'transaction_id' => $transaction->id
            ],
            [
                'name' => 'Pedimento Impo',
                'transaction_id' => $transaction->id
            ],
            [
                'name' => 'Pedimento Expo',
                'transaction_id' => $transaction->id
            ]
        ]);

        return $transaction;
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'company_import_id' => 'required|integer',
            'company_export_id' => 'required|integer',
            'customs_import_id' => 'required|integer',
            'customs_export_id' => 'required|integer'
        ]);

        $transaction = Transaction::find($request->id);
        $transaction->name = $request->name;
        $transaction->company_import_id = $request->company_import_id;
        $transaction->company_export_id = $request->company_export_id;
        $transaction->customs_import_id = $request->customs_import_id;
        $transaction->customs_export_id = $request->customs_export_id;
        $transaction->save();

        return $transaction;
    }

    public function destroy ($transaction)
    {
        return Transaction::destroy($transaction);
    }

    public function filter (Request $request)
    {
        $query = Transaction::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $transactions = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->paginate($request->input('pagination.per_page'));

        $transactions->load('companyImport', 'companyExport', 'stages');

        return $transactions;
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

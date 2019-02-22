<?php

namespace App\Http\Controllers\Transactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Transactions\Transaction;
use App\Models\Companies\Company;
use App\User;

class TransactionController extends Controller
{
    public function show ($transactionId)
    {
        $transaction = Transaction::with('finishedByUser', 'companies', 'users', 'stages.authorizedByUser', 'stages.files.creator', 'stages.comments.creator')->findOrFail($transactionId);

        $usersGroupByCompany = $transaction->users->groupBy('company_id');

        foreach ($transaction->companies as $value) {
            foreach ($usersGroupByCompany as $k => $v) {
                if ($value->id == $k) {
                    $value->users = $v;
                }
            }
        }

        return $transaction;
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $transaction = Transaction::create([
            'name' => $request->name
        ]);

        // Create default stages
        $transaction->stages()->createMany([
            [
                'name' => 'Proforma IMPO',
                'transaction_id' => $transaction->id
            ],
            [
                'name' => 'Proforma EXPO',
                'transaction_id' => $transaction->id
            ],
            [
                'name' => 'Pedimento IMPO',
                'transaction_id' => $transaction->id
            ],
            [
                'name' => 'Pedimento EXPO',
                'transaction_id' => $transaction->id
            ]
        ]);

        return $transaction;
    }

    public function update (Request $request, $transactionId)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $transaction = Transaction::find($transactionId);
        $transaction->name = $request->name;
        $transaction->save();

        return $transaction;
    }

    public function destroy ($transactionId)
    {
        return Transaction::destroy($transactionId);
    }

    public function filter (Request $request)
    {
        $query = Transaction::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $transactions = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->paginate($request->input('pagination.per_page'));

        $transactions->load('companies', 'stages');

        return $transactions;
    }

    public function count ()
    {
        return Transaction::count();
    }

    public function toggleFinished (Request $request, $transactionId)
    {
        $this->validate($request, [
            'finished' => 'required|boolean'
        ]);

        $transaction = Transaction::find($transactionId);

        if ($transaction->finished != $request->finished) {
            $transaction->finished = $request->finished;
            if ($request->finished) {
                $transaction->finished_by = Auth::id();
                $transaction->finished_at = now();
            } else {
                $transaction->finished_by = null;
                $transaction->finished_at = null;
            }
            $transaction->save();
        }

        return $this->show($transaction->id);
    }

    public function attachCompany (Request $request, $transactionId)
    {
        $this->validate($request, [
            'company' => 'required|integer',
            'type' => 'required|string'
        ]);

        $company = Company::find($request->company);
        $attach = $company->transactions()->sync([$transactionId => ['company_type' => $request->type]]);

        $users = User::where('company_id', $request->company)->get();
        foreach ($users as $user) {
            $user->transactions()->sync($transactionId);
        }

        return $this->groupCompaniesUsers ($transactionId);
    }

    public function detachCompany ($transactionId, $companyId)
    {
        $company = Company::find($companyId);
        $attach = $company->transactions()->detach($transactionId);

        $users = User::where('company_id', $companyId)->get();
        foreach ($users as $user) {
            $user->transactions()->detach($transactionId);
        }

        return $this->groupCompaniesUsers ($transactionId);
    }

    public function groupCompaniesUsers ($transactionId)
    {
        $transaction = Transaction::with('companies', 'users')->find($transactionId);

        $usersGroupByCompany = $transaction->users->groupBy('company_id');

        foreach ($transaction->companies as $value) {
            foreach ($usersGroupByCompany as $k => $v) {
                if ($value->id == $k) {
                    $value->users = $v;
                }
            }
        }

        return $transaction;
    }
}

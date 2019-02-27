<?php

namespace App\Http\Controllers\Transactions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transactions\Transaction;
use App\Models\Companies\Company;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function filter (Request $request)
    {
        $query = DB::table('transactions')
        ->select('transactions.*')
        ->whereNull('transactions.deleted_at');

        // *$request->finished = [0: Abiertas, 1: Finalizadas, 2:Ambas];
        if ($request->input('finished.id') != 2) {
            $query->where('finished', $request->input('finished.id'));
        }

        // ** var $request->wich = [
        //// 1:Todas
        if ($request->input('wich.id') == 1) {
            $guest = DB::table('transaction_user')->where('user_id', Auth::id())->get();
            $ids = $guest->implode('transaction_id', ', ');

            $query->where(function ($q) use ($ids) {
                $q->whereIn('id', explode(',', $ids));
                $q->orWhere('created_by', Auth::id());
            });
        } else if ($request->input('wich.id') == 2) {
        ////2:Tuyas
                $query->where('created_by', Auth::id());
        } else {
        ////3:Invitado
            $guest = DB::table('transaction_user')->where('user_id', Auth::id())->get();
            $ids = $guest->implode('transaction_id', ', ');
            $query->whereIn('id', explode(',', $ids));
        }
        //];

        // if($request->search) {
        //     $query->where('name', 'LIKE', '%'.$request->search.'%');
        // }

        $transactions = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
            //->paginate($request->input('pagination.per_page'));
            ->get();

        foreach ($transactions as $key => $value) {
            $value->companies = DB::table('transaction_company')
                ->select('companies.name', 'transaction_company.company_type', 'transaction_company.company_type_acronym')
                ->leftjoin('companies', 'companies.id', '=', 'transaction_company.company_id')
                ->where('transaction_id', $value->id)->get();
        }

        return $transactions;
    }

    public function show ($transactionId)
    {
        $transaction = Transaction::with('finishedByUser', 'companies', 'users', 'creator', 'stages.authorizedByUser', 'stages.files.creator', 'stages.comments.creator')->findOrFail($transactionId);

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


        // // find relations
        // //DB::table('transaction_user')->where('transaction_id', $transactionId)->delete();
        // $files = [];
        // $stages = DB::table('stages')->where('transaction_id', $transactionId, function($query) {
        //     $files = DB::table('files')->where('transaction_id', $query->id)->get();
        // })->get();
        //
        // // Delete relations
        // DB::table('files')->whereIn('stage_id', $files)->delete();
        // DB::table('stages')->whereIn('stage_id', $stages)->delete();

        return Transaction::destroy($transactionId);
    }

    public function count ()
    {
        $guest = DB::table('transaction_user')->where('user_id', Auth::id())->get();
        $ids = $guest->implode('transaction_id', ', ');

        return DB::table('transactions')->where(function ($q) use ($ids) {
            $q->whereIn('id', explode(',', $ids));
            $q->orWhere('created_by', Auth::id());
        })->count();
    }

    public function stats ()
    {
        $guest = DB::table('transaction_user')->where('user_id', Auth::id())->get();
        $ids = $guest->implode('transaction_id', ', ');

        $open = DB::table('transactions')->where('finished', 0)->where(function ($q) use ($ids) {
            $q->whereIn('id', explode(',', $ids));
            $q->orWhere('created_by', Auth::id());
        })->count();

        $finished = DB::table('transactions')->where('finished', 1)->where(function ($q) use ($ids) {
            $q->whereIn('id', explode(',', $ids));
            $q->orWhere('created_by', Auth::id());
        })->count();

        return ['open' => $open, 'finished' => $finished];
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
            'type' => 'required|string',
            'acronym' => 'required|string'
        ]);

        $company = Company::find($request->company);
        $attach = $company->transactions()->syncWithoutDetaching([$transactionId => ['company_type' => $request->type, 'company_type_acronym' => $request->acronym]]);

        $users = User::where('company_id', $request->company)->get();
        foreach ($users as $user) {
            $user->transactions()->syncWithoutDetaching($transactionId);
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

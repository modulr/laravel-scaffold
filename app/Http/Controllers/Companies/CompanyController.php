<?php

namespace App\Http\Controllers\Companies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Companies\Company;

class CompanyController extends Controller
{
    public function filter (Request $request)
    {
        $query = Company::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $companies = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->paginate($request->input('pagination.per_page'));

        $companies->load('users');

        return $companies;
    }

    public function show ($company)
    {
        return Company::with(['users'=> function($query){
            $query->orderBy('id', 'desc');
        }])->findOrFail($company);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);

        return Company::create([
            'name' => $request->name
        ]);
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        $company = Company::find($request->id);

        if ($company->name != $request->name) {
            $company->name = $request->name;
        }

        $company->save();

        return $company;
    }

    public function destroy ($company)
    {
        return Company::destroy($company);
    }
}

<?php

namespace App\Http\Controllers\Companies;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Companies\CompanyType;

class CompanyTypeController extends Controller
{
    public function all()
    {
        return CompanyType::all();
    }
}

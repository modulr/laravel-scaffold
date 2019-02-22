<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserType;

class UserTypeController extends Controller
{
    public function all()
    {
        return UserType::all();
    }
}

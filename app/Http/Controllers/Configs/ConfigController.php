<?php

namespace App\Http\Controllers\Configs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Configs\Config;

class ConfigController extends Controller
{
    public function first()
    {
        return Config::first();
    }
}

<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Modules\Module;

class ModuleController extends Controller
{
    public function getModulesPermissions()
    {
        return Module::with('permissions')
          ->has('permissions')
          ->orderBy('name')
          ->get();
    }
  }

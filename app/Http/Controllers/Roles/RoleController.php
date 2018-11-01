<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function filter (Request $request)
    {
        $query = Role::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $roles = $query->orderBy($request->column, $request->direction)
        ->paginate($request->perPage);

        return $roles;
    }

    public function show ($role)
    {
        return Role::findOrFail($role);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'display_name' => 'required|string|unique:roles'
        ]);

        $role = Role::create([
            'display_name' => $request->display_name,
            'name' => strtolower(str_replace(' ', '-', $request->display_name)),
        ]);

        return $role;
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:roles,name,'.$request->id
        ]);

        $role = Role::find($request->id);

        if ($role->name != $request->name) {
            $role->name = $request->name;
        }

        $role->save();
    }

    public function destroy ($role)
    {
        return Role::destroy($role);
    }
}

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
        return Role::with('permissions')->findOrFail($role);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:roles',
            'display_name' => 'required|string|unique:roles'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name
        ]);

        $permissions = [];
        foreach ($request->modules as $key => $value) {
            foreach ($value['permissions'] as $ke => $val) {
                if (isset($val['allow']) && $val['allow']) {
                    array_push($permissions, ['name' => $val['name']]);
                }
            }
        }

        $role->givePermissionTo($permissions);

        return $role;
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:roles,name,'.$request->id,
            'display_name' => 'required|string|unique:roles,display_name,'.$request->id
        ]);

        $role = Role::find($request->id);

        if ($role->name != $request->name) {
            $role->name = $request->name;
        }

        if ($role->display_name != $request->display_name) {
            $role->display_name = $request->display_name;
        }

        $permissions = [];
        foreach ($request->modules as $key => $value) {
            foreach ($value['permissions'] as $ke => $val) {
                if (isset($val['allow']) && $val['allow']) {
                    array_push($permissions, ['name' => $val['name']]);
                }
            }
        }

        $role->syncPermissions($permissions);

        $role->save();
    }

    public function destroy ($role)
    {
        return Role::destroy($role);
    }
}

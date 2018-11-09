<?php

namespace App\Http\Controllers\Roles;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;
use App\Models\Modules\Module;

class RoleController extends Controller
{
    public function filter (Request $request)
    {
        $query = Role::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $roles = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->paginate($request->input('pagination.per_page'));

        $roles->load('permissions', 'users');

        return $roles;
    }

    public function all()
    {
        return Role::all();
    }

    public function show ($role)
    {
        return Role::findOrFail($role);
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
        foreach ($request->modulesPermissions as $key => $value) {
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
            'display_name' => 'required|string|unique:roles,display_name,'.$request->id,
            'modulesPermissions' => 'array'
        ]);

        $role = Role::find($request->id);

        if ($role->name != $request->name) {
            $role->name = $request->name;
        }

        if ($role->display_name != $request->display_name) {
            $role->display_name = $request->display_name;
        }

        $permissions = [];
        foreach ($request->modulesPermissions as $key => $value) {
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

    public function count ()
    {
        return Role::count();
    }

    public function getRoleModulesPermissions($role)
    {
        $role = Role::with('permissions', 'users')->findOrFail($role);
        $modules = Module::has('permissions')->orderBy('name')->get();

        foreach ($modules as $key => $value) {
            foreach ($value->permissions as $ke => $val) {
                foreach ($role->permissions as $k => $v) {
                    if ($v->name == $val->name) {
                        $val->allow = true;
                    }
                }
            }
        }
        $role->modulesPermissions = $modules;
        return $role;
    }
}

<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Http\Helpers\Upload;
use Avatar;

use App\User;

class UserController extends Controller
{
    public function filter (Request $request)
    {
        $query = User::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }

        $users = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->paginate($request->input('pagination.per_page'));

        $users->load('roles');

        return $users;
    }

    public function show ($user)
    {
        return User::findOrFail($user);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'cellphone' => 'required|numeric|unique:users',
            'description' => 'string|nullable',
            'password' => 'required|string',
            'roles' => 'required|array'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cellphone' => $request->cellphone,
            'description' => $request->description,
            'password' => Hash::make($request->password)
        ]);

        $rolesNames = array_pluck($request->roles, ['name']);
        $user->assignRole($rolesNames);

        $avatar = Avatar::create($user->name)->getImageObject()->encode('png');
        Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);

        return $user;
    }

    public function update (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'cellphone' => 'required|numeric',
            'description' => 'string|nullable',
            'password' => 'string|nullable',
            'roles' => 'required|array'
        ]);

        $user = User::find($request->id);

        if ($user->name != $request->name) {
            $avatar = Avatar::create($request->name)->getImageObject()->encode('png');
            Storage::put('avatars/'.$user->id.'/avatar.png', (string) $avatar);
            $user->name = $request->name;
        }
        if ($user->email != $request->email) {
            $user->email = $request->email;
        }
        if ($user->cellphone != $request->cellphone) {
            $user->cellphone = $request->cellphone;
        }
        if ($user->description != $request->description) {
            $user->description = $request->description;
        }
        if ($request->password != '') {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $rolesNames = array_pluck($request->roles, ['name']);
        $user->syncRoles($rolesNames);

        return $user;
    }

    public function destroy ($user)
    {
        return User::destroy($user);
    }

    public function count ()
    {
        return User::count();
    }

    public function getUserRoles ($user)
    {
        $user = User::findOrFail($user);
        $user->getRoleNames();

        return $user;
    }

    public function uploadAvatar(Request $request)
    {
        $upload = new Upload();
        $avatar = $upload->upload($request->file, 'avatars/'.$request->userId)->resize(200, 200)->getData();

        $user = User::find($request->userId);
        $user->avatar = $avatar['basename'];
        $user->save();

        return $user;
    }

    // public function removeAvatar()
    // {
    //     $user = User::find($request->userId);
    //     $user->avatar = 'avatar.png';
    //     $user->save();
    //
    //     return $user;
    // }

    public function getDealers ()
    {
        return User::role('dealer')->orderBy('name')->get();
    }

    public function getClients ()
    {
        return User::role('user')->orderBy('name')->get();
    }
}

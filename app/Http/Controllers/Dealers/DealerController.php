<?php

namespace App\Http\Controllers\Dealers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use App\Http\Helpers\Upload;
use Avatar;

use App\User;

use App\Notifications\ActiveDealer;
use App\Notifications\DeactiveDealer;

class DealerController extends Controller
{
    public function filter (Request $request)
    {
        $query = User::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
            $query->orWhere('cellphone', 'LIKE', '%'.$request->search.'%');
        }

        if ($request->status) {
            if ($request->status == 'active') {
                $query->where('active', true);
            }
        }

        $query->role('dealer');

        $users = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->paginate($request->input('pagination.per_page'));

        return $users;
    }

    public function show ($user)
    {
        return User::with('addresses')->findOrFail($user);
    }

    public function store (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'numeric|unique:users',
            'cellphone' => 'numeric|unique:users',
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

    public function uploadAvatar(Request $request)
    {
        $upload = new Upload();
        $avatar = $upload->upload($request->file, 'avatars/'.$request->userId)->resize(200, 200)->getData();

        $user = User::find($request->userId);
        $user->avatar = $avatar['basename'];
        $user->save();

        return $user;
    }

    public function activeToggle(Request $request)
    {
        $user = User::find($request->id);
        $user->active = !$user->active;
        $user->save();

        if ($user->active) {
            Auth::user()->notify(new ActiveDealer($user));
        } else {
            Auth::user()->notify(new DeactiveDealer($user));
        }

        return $user;
    }
}

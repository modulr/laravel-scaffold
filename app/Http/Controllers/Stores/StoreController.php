<?php

namespace App\Http\Controllers\Stores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Http\Helpers\Upload;
use Avatar;

use App\User;

class StoreController extends Controller
{
    public function filter (Request $request)
    {
        $query = User::query();

        if($request->search) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
            $query->orWhere('description', 'LIKE', '%'.$request->search.'%');
            $query->orWhere('tags', 'LIKE', '%'.$request->search.'%');
        }

        $query->role('store');

        $users = $query->orderBy($request->input('orderBy.column'), $request->input('orderBy.direction'))
                    ->orderBy('name', 'asc')
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
            'level' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'phone' => 'numeric|unique:users',
            'cellphone' => 'numeric|unique:users',
            'password' => 'required|string',
            'roles' => 'required|array'
        ]);

        $user = User::create([
            'name' => $request->name,
            'store' => $request->store,
            'level' => $request->level,
            'email' => $request->email,
            'address' => $request->address,
            'schedule' => $request->schedule,
            'description' => $request->description,
            'phone' => $request->phone,
            'cellphone' => $request->cellphone,
            'tags' => implode(",", $request->tags),
            'web' => $request->web,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'link' => $request->link,
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
        if ($user->phone != $request->phone) {
            $user->phone = $request->phone;
        }
        if ($user->cellphone != $request->cellphone) {
            $user->cellphone = $request->cellphone;
        }
        if ($user->tags != $request->tags) {
            $user->tags = implode(",", $request->tags);
        }
        if ($user->description != $request->description) {
            $user->description = $request->description;
        }
        if ($request->password != '') {
            $user->password = Hash::make($request->password);
        }
        if ($user->store != $request->store) {
            $user->store = $request->store;
        }
        if ($user->level != $request->level) {
            $user->level = $request->level;
        }
        if ($user->address != $request->address) {
            $user->address = $request->address;
        }
        if ($user->address != $request->address) {
            $user->address = $request->address;
        }
        if ($user->schedule != $request->schedule) {
            $user->schedule = $request->schedule;
        }
        if ($user->web != $request->web) {
            $user->web = $request->web;
        }
        if ($user->facebook != $request->facebook) {
            $user->facebook = $request->facebook;
        }
        if ($user->instagram != $request->instagram) {
            $user->instagram = $request->instagram;
        }
        if ($user->link != $request->link) {
            $user->link = $request->link;
        }

        $user->save();

        $rolesNames = array_pluck($request->roles, ['name']);
        if (!in_array("store", $rolesNames)) {
            array_push($rolesNames, "store");
        }
        $user->syncRoles($rolesNames);

        return $user;
    }

    public function destroy ($user)
    {
        $user = User::find($user);
        return $user->removeRole('store');
        //return User::destroy($user);
    }

    public function uploadAvatar(Request $request)
    {
        $upload = new Upload();
        $avatar = $upload->upload($request->file, 'avatars/'.$request->userId)->resize(200, 200)->getData();
        //$upload->upload($request->file, 'banners/'.$request->userId)->resize(600, 300)->getData();

        $user = User::find($request->userId);
        $user->avatar = $avatar['basename'];
        $user->save();

        return $user;
    }

    public function uploadBanner(Request $request)
    {
        $upload = new Upload();
        $banner = $upload->upload($request->file, 'banners/'.$request->userId)->resize2(600, 300)->getData();

        $user = User::find($request->userId);
        $user->banner = $banner['basename'];
        $user->save();

        return $user;
    }

    public function getStoresRandom ()
    {
        //return User::role('store')->where('level', 1)->orderBy('name')->get();
        return User::where('store', 1)->orderByRaw("RAND()")->get();
    }

    public function getStoresLevel1 ()
    {
        return User::role('store')->where('level', 1)->orderByRaw("RAND()")->get();
    }

    public function getStoresLevel23 ()
    {
        return User::role('store')->whereIn('level', [2,3])->orderByRaw("RAND()")->get();
    }
}

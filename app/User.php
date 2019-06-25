<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

use Storage;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password', 'avatar', 'cellphone', 'description'
    // ];
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    protected $appends = ['avatar_url', 'avatar_url_large', 'avatar_url_banner', 'hasPermission', 'hasRole'];

    public function getAvatarUrlAttribute()
    {
        if (Str::startsWith($this->avatar, 'http')) {
            return $this->avatar;
        } else {
            return Storage::url('avatars/'.$this->id.'/'.$this->avatar);
        }
    }

    public function getAvatarUrlLargeAttribute()
    {
        if (Str::startsWith($this->avatar, 'http')) {
            $avatar = Str::replaceLast('type=normal', 'type=large', $this->avatar);
            return $avatar;
        } else {
            return Storage::url('avatars/'.$this->id.'/'.$this->avatar);
        }
    }

    public function getAvatarUrlBannerAttribute()
    {
        return Storage::url('banners/'.$this->id.'/'.$this->avatar);
    }

    public function getHasPermissionAttribute()
    {
        $permissions = [];
        foreach (Permission::all() as $permission) {
            if ($this->can($permission->name)) {
                $permissions[$permission->name] = true;
            } else {
                $permissions[$permission->name] = false;
            }
        }
        return $permissions;
    }

    public function getHasRoleAttribute()
    {
        $roles = [];
        foreach (Role::all() as $role) {
            if ($this->hasRole($role->name)) {
                $roles[$role->name] = true;
            } else {
                $roles[$role->name] = false;
            }
        }
        return $roles;
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address\Address', 'client_id');
    }
}

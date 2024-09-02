<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'employee_id',
        'position',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(string|Role|Collection $role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);

        } else if ($role instanceof Role) {
            return !! $this->roles->contains('name', $role->name);

        }

        return !! $role->intersect($this->roles)->count();

    }

    public function hasPermission($permissionName)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permissionName) {
            $query->where('name', $permissionName);
        })->exists();
    }

    public function hasAnyPermission(array $permissions)
    {
        return $this->roles()->whereHas('permissions', function($query) use ($permissions) {
            $query->whereIn('name', $permissions);
        })->exists();
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
            return $this->roles()->attach($role?->id);

        } else if ($role instanceof Role) {
            return $this->roles()->attach($role->id);

        }

    }

    public function detachRole($role)
    {
        if (is_string($role)) {
            $role = Role::whereName($role)->firstOrFail();
            return $this->roles()->detach($role?->id);

        } else if ($role instanceof Role) {
            return $this->roles()->detach($role->id);

        }

    }

    // public function isAdmin()
    // {
    //     return $this->hasRole('admin');
    // }
}

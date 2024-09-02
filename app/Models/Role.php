<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ["name", "label"];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');

    }

    public function givePermissionTo(string|Permission $permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
            return $this->permissions()->attach($permission->id);

        } else if ($permission instanceof Permission) {
            return $this->permissions()->attach($permission->id);

        }
    }

    public function revokePermission(string|Permission $permission)
    {
        if (is_string($permission)) {
            $permission = Permission::whereName($permission)->firstOrFail();
            return $this->permissions()->detach($permission->id);

        } else if ($permission instanceof Permission) {
            return $this->permissions()->detach($permission->id);

        }
    }
}

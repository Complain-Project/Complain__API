<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionGroup extends Model
{
    use HasFactory;

    protected $table = "permission_groups";

    protected $fillable = [
        "name",
        "code",
        "description",
        "parent_code",
    ];

    /**
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, "permission_group_code", "code");
    }

    public function children()
    {
        return $this->hasMany(PermissionGroup::class, 'parent_code', 'code')
            ->with(["children", "permissions"]);
    }
}

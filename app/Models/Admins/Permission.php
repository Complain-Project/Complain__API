<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $table = "permissions";

    protected $fillable = [
        "name",
        "description",
        "code",
        "permission_group_code",
        "permission_type_code",
        "role_ids"
    ];

    /**
     * @return BelongsTo
     */
    public function permissionGroup(): BelongsTo
    {
        return $this->belongsTo(PermissionGroup::class, "permission_group_code", "code");
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\BelongsToMany|BelongsToMany
     */
    public function roles(): \Jenssegers\Mongodb\Relations\BelongsToMany|BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}

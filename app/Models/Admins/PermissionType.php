<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionType extends Model
{
    use HasFactory;

    protected $table = "permission_types";

    protected $fillable = [
        "name",
        "code",
        "position",
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
}

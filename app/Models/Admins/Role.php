<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Jenssegers\Mongodb\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";

    protected $fillable = [
        "name",
        "description",
        "is_protected",
        "permission_ids",
        "employee_ids",
        "parent_id"
    ];

	/**
	 * @return void
	 */
	protected static function boot(): void
	{
		parent::boot();

		static::deleting(function (Role $role) {
			$role->employees()->detach();
			$role->permissions()->detach();
		});
	}

    /**
     * @return \Jenssegers\Mongodb\Relations\BelongsToMany|BelongsToMany
     */
    public function employees(): \Jenssegers\Mongodb\Relations\BelongsToMany|BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\BelongsToMany|BelongsToMany
     */
    public function permissions(): \Jenssegers\Mongodb\Relations\BelongsToMany|BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|HasMany
     */
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany|HasMany
    {
        return $this->hasMany(Role::class, 'parent_id', '_id')
            ->with(["children" => function($q) {
                $q->select([
                    "name", "description", "is_protected", "parent_id",
                    "created_at", "updated_at"
                ]);
            }]);
    }
}

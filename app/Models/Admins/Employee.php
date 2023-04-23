<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Employee extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes;

    protected $guard = "admins";

    protected $table = "employees";

	protected $fillable = [
		"name",
		"email",
		"phone",
		"password",
		"status",
		"district_id",
		"is_admin",
		"role_ids"
	];

    protected $hidden = [
        "password",
    ];

	const ACTIVE_STATUS = [
		"DEACTIVATE" => 0,
		"ACTIVATED" => 1,
	];

    /**
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function (Employee $employee) {
            $employee->roles()->detach();
        });
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

	/**
	 * @return \Jenssegers\Mongodb\Relations\BelongsToMany|BelongsToMany
	 */
	public function roles(): \Jenssegers\Mongodb\Relations\BelongsToMany|BelongsToMany
	{
		return $this->belongsToMany(Role::class);
	}

	public function district() {
		return $this->belongsTo(District::class);
	}
}
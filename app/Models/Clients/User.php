<?php

namespace App\Models\Clients;

use App\Models\Admins\Role;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
	use SoftDeletes;

	protected $guard = "clients";
	protected $fillable = [
		"code",
		"name",
		"email",
		"password",
		"avatar_path",
		"description",
		"slug",
		"status",
		"priority",
		"type",
		"social_type",
		"verify_code",
		"verify_code_expired",
		"verify_email_at",
		"song_ids",
		"post_ids",
	];

	/**
	 * @var string[]
	 */
	protected $hidden = [
		"password",
		"remember_token",
	];

	const ACTIVE_STATUS = [
		"ACTIVATED" => 0,
		"DEACTIVATE" => 1,
		"PENDING_ACTIVATION" => 2,
	];

	const TYPE = [
		"GENERAL" => 0,
		"ARTIST" => 1,
	];

	const PRIORITY_TYPE = [
		"GENERAL" => 0,
		"PRIORITY" => 1,
	];

	const SOCIAL_TYPE = [
		"NORMAL" => null,
		"FACEBOOK" => 0,
		"GOOGLE" => 1,
	];

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
}

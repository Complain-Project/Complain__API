<?php

namespace App\Models\Clients;

use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class User extends Authenticatable
{
	use SoftDeletes;

	protected $table = "users";

	protected $fillable = [
		'name',
		'aliases',
		'email',
		'phone',
		'birthday',
		'account_name',
		'password',
		'status',
	];

	protected $hidden = [
		'password',
	];

	const STATUS = [
		'DEACTIVATE' => 0,
		'ACTIVATE' => 1
	];
}

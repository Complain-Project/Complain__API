<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class District extends Model
{
    use HasFactory;

	protected $table = "districts";

	protected $fillable = [
		"name",
		"code"
	];
}

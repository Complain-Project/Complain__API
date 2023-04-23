<?php

namespace Database\Seeders\Admins;

use App\Models\Admins\Employee;
use App\Models\Admins\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class EmployeeTableSeeder extends Seeder
{
	/**
	 * @return void
	 */
	public function run(): void
	{
		$roleID = Role::query()->where("name", "Super Admin")->value("_id");

		if ($roleID) {
			Employee::query()->updateOrCreate(
				[
					"email" => "admin@gmail.com"
				],
				[
					"name" => "Super Admin",
					"email" => "admin@gmail.com",
					"phone" => "0388889999",
					"password" => Hash::make("password"),
					"status" => Employee::ACTIVE_STATUS["ACTIVATED"],
					"is_admin" => true,
					"district_id" => null,
					"role_ids" => []
				]
			)->roles()->sync([$roleID]);
		}
	}
}

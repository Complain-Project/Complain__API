<?php

namespace Database\Seeders\Admins;

use App\Models\Admins\Employee;
use App\Models\Admins\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeTableSeeder extends Seeder
{
	/**
	 * @return void
	 */
	public function run(): void
	{
		$roleID = Role::query()->where("name", "Super Admin")->value("_id");

		if ($roleID) {
			$name = "Super Admin";
			$email = "admin@gmail.com";
			$phone = "0388889999";
			$keyword = collect([$name, $email, $phone])->implode(" ");

			Employee::query()->updateOrCreate(
				[
					"email" => $email
				],
				[
					"name" => $name,
					"email" => $email,
					"phone" => $phone,
					"password" => Hash::make("password"),
					"avatar_path" => null,
					"status" => Employee::ACTIVE_STATUS["ACTIVATED"],
					"keyword" => $keyword,
					"role_ids" => []
				]
			)->roles()->sync([$roleID]);
		}
	}
}

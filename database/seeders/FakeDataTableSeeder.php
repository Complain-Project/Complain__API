<?php

namespace Database\Seeders;

use App\Models\Admins\District;
use App\Models\Admins\Employee;
use App\Models\Clients\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class FakeDataTableSeeder extends Seeder
{
	/**
	 * @return void
	 * @throws \Exception
	 */
	public function run()
	{
		$districts = District::all()->pluck("_id");

	    $faker = Faker::create();
	    for ($i = 1; $i <= 500; $i++) {
		    Employee::query()->updateOrCreate(
			    [
				    "email" => $faker->name
			    ],
			    [
				    "name" => $faker->name,
				    "email" => $faker->email,
				    "phone" => $faker->numerify('03########'),
				    "password" => Hash::make("111111"),
				    "status" => random_int(0, 1),
				    "is_admin" => false,
				    "district_id" => $districts->random(),
				    "role_ids" => []
			    ]
		    );
	    }

	    for ($i = 1; $i <= 200; $i++) {
		    $phone = $faker->numerify('09########');
		    User::query()->updateOrCreate(
			    [
				    "phone" => $phone
			    ],
			    [
				    "name" => $faker->name,
				    "aliases" => $faker->lastName,
				    "email" => $faker->email,
				    "phone" => $phone,
				    "password" => Hash::make("111111"),
				    "account_name" => $faker->userName,
				    "birthday" => $faker->unixTime(),
				    "status" => random_int(0, 1),
			    ]
		    );
	    }
	}
}

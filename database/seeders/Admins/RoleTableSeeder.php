<?php

namespace Database\Seeders\Admins;

use App\Models\Admins\Permission;
use App\Models\Admins\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        $rootPermissionID = Permission::query()
            ->where("code", "ROOT")
            ->value("_id");

		if ($rootPermissionID) {
			Role::query()->updateOrCreate(
				[
					"name" => "Super Admin"
				],
				[
					"description" => "Quản trị hệ thống",
					"is_protected" => true,
					"permission_ids" => []
				]
			)->permissions()->sync([$rootPermissionID]);
		}
    }
}

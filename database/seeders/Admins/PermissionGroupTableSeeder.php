<?php

namespace Database\Seeders\Admins;

use App\Models\Admins\PermissionGroup;
use Illuminate\Database\Seeder;

class PermissionGroupTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        self::updateOrCreate([
            "name" => "Tổng quan",
            "code" => "DAB",
            "parent_code" => null,
            "description" => null
        ]);

        self::updateOrCreate([
            "name" => "Quản lý vai trò",
            "code" => "ROLE",
            "parent_code" => null,
            "description" => null
        ]);

        self::updateOrCreate([
            "name" => "Quản lý quyền hạn",
            "code" => "PERMISSION",
            "parent_code" => "ROLE",
            "description" => null
        ]);

        self::updateOrCreate([
            "name" => "Quản lý cán bộ",
            "code" => "ADM",
            "parent_code" => null,
            "description" => null
        ]);

	    self::updateOrCreate([
		    "name" => "Quản lý người khiếu nại",
		    "code" => "COMPLAINANT",
		    "parent_code" => null,
		    "description" => null
	    ]);

        self::updateOrCreate([
            "name" => "Quản lý khiếu nại",
            "code" => "COMPLAIN",
            "parent_code" => null,
            "description" => null
        ]);

        self::updateOrCreate([
            "name" => "Quản lý bài viết",
            "code" => "POST",
            "parent_code" => null,
            "description" => null
        ]);
    }

    /**
     * @param $data
     * @return void
     */
    public function updateOrCreate($data): void
    {
        PermissionGroup::query()->updateOrCreate(
            [
                "code" => $data["code"]
            ],
            [
                "name"          => $data["name"],
                "code"          => $data["code"],
                "parent_code"   => $data["parent_code"],
            ]
        );
    }
}

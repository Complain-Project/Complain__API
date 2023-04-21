<?php

namespace Database\Seeders\Admins;

use App\Models\Admins\PermissionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        self::updateOrCreate([
            "name" => "Truy cập",
            "code" => "LIST",
            "position" => 1
        ]);
        self::updateOrCreate([
            "name" => "Tạo mới",
            "code" => "CREATE",
            "position" => 2
        ]);
        self::updateOrCreate([
            "name" => "Chỉnh sửa",
            "code" => "UPDATE",
            "position" => 3
        ]);
        self::updateOrCreate([
            "name" => "Xóa",
            "code" => "DELETE",
            "position" => 4
        ]);
        self::updateOrCreate([
            "name" => "Xem chi tiết",
            "code" => "DETAIL",
            "position" => 5
        ]);
    }

    /**
     * @param $data
     * @return void
     */
    public function updateOrCreate($data): void
    {
        PermissionType::query()->updateOrCreate(
            [
                "code" => $data["code"]
            ],
            [
                "name" => $data["name"],
                "code" => $data["code"],
                "position" => $data["position"]
            ]
        );
    }
}

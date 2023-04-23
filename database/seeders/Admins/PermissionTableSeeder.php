<?php

namespace Database\Seeders\Admins;

use App\Models\Admins\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        /* Super admin::start */
        self::updateOrCreate([
            "name" => "Quản trị hệ thống",
            "description" => "Có toàn quyền sử dụng hệ thống",
            "code" => "ROOT",
            "permission_type_code" => null,
            "permission_group_code" => null,
            "role_ids" => []
        ]);
        /* Super admin::end */

        /* Vai trò::start */
        self::updateOrCreate([
            "name" => "Xem danh sách vai trò",
            "description" => "",
            "code" => "ROLE-L",
            "permission_type_code" => "LIST",
            "permission_group_code" => "ROLE",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Xem chi tiết vai trò",
            "description" => "",
            "code" => "ROLE-DPR",
            "permission_type_code" => "DETAIL",
            "permission_group_code" => "ROLE",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Thêm mới vai trò",
            "description" => "",
            "code" => "ROLE-C",
            "permission_type_code" => "CREATE",
            "permission_group_code" => "ROLE",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Cập nhật vai trò",
            "description" => "",
            "code" => "ROLE-U",
            "permission_type_code" => "UPDATE",
            "permission_group_code" => "ROLE",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Xóa vai trò",
            "description" => "",
            "code" => "ROLE-DEL",
            "permission_type_code" => "DELETE",
            "permission_group_code" => "ROLE",
            "role_ids" => []
        ]);
        /* Vai trò::end */

        /* Quyền hạn::start */
        self::updateOrCreate([
            "name" => "Xem danh sách quyền hạn của vai trò",
            "description" => "",
	        "code" => "PERMISSION-L",
	        "permission_type_code" => "LIST",
            "permission_group_code" => "PERMISSION",
            "role_ids" => []
        ]);
        self::updateOrCreate([
            "name" => "Chỉnh sửa quyền hạn của vai trò",
            "description" => "",
            "code" => "PERMISSION-U",
            "permission_type_code" => "UPDATE",
            "permission_group_code" => "PERMISSION",
            "role_ids" => []
        ]);
        /* Quyền hạn::end */

        /* cán bộ::start */
        self::updateOrCreate([
            "name" => "Xem danh sách nhân viên",
            "description" => "",
            "code" => "ADM-L",
            "permission_type_code" => "LIST",
            "permission_group_code" => "ADM",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Xem chi tiết nhân viên",
            "description" => "",
            "code" => "ADM-D",
            "permission_type_code" => "DETAIL",
            "permission_group_code" => "ADM",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Thêm mới nhân viên",
            "description" => "",
            "code" => "ADM-C",
            "permission_type_code" => "CREATE",
            "permission_group_code" => "ADM",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Cập nhật nhân viên",
            "description" => "",
            "code" => "ADM-U",
            "permission_type_code" => "UPDATE",
            "permission_group_code" => "ADM",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Xóa nhân viên",
            "description" => "",
            "code" => "ADM-DEL",
            "permission_type_code" => "DELETE",
            "permission_group_code" => "ADM",
            "role_ids" => []
        ]);
        /* Nhân viên::end */
    }

    /**
     * @param $data
     * @return void
     */
    public function updateOrCreate($data): void
    {
        Permission::query()->updateOrCreate(
            [
                "code" => $data["code"]
            ],
            [
                "name" => $data["name"],
                "description" => $data["description"],
                "code" => $data["code"],
                "permission_type_code" => $data["permission_type_code"],
                "permission_group_code" => $data["permission_group_code"],
                "role_ids" => $data["role_ids"]
            ]
        );
    }}

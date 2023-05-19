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

        /* Tổng quan::start */
        self::updateOrCreate([
            "name" => "Tổng quan",
            "description" => "",
            "code" => "DAB-L",
            "permission_type_code" => "LIST",
            "permission_group_code" => "DAB",
            "role_ids" => []
        ]);
        /* Tổng quan::end */

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

        /* Cán bộ::start */
        self::updateOrCreate([
            "name" => "Xem danh sách cán bộ",
            "description" => "",
            "code" => "ADM-L",
            "permission_type_code" => "LIST",
            "permission_group_code" => "ADM",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Thêm mới cán bộ",
            "description" => "",
            "code" => "ADM-C",
            "permission_type_code" => "CREATE",
            "permission_group_code" => "ADM",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Cập nhật cán bộ",
            "description" => "",
            "code" => "ADM-U",
            "permission_type_code" => "UPDATE",
            "permission_group_code" => "ADM",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Xóa cán bộ",
            "description" => "",
            "code" => "ADM-DEL",
            "permission_type_code" => "DELETE",
            "permission_group_code" => "ADM",
            "role_ids" => []
        ]);
        /* Cán bộ::end */

	    /* Người khiếu nại::start */
	    self::updateOrCreate([
		    "name" => "Xem danh sách người khiếu nại",
		    "description" => "",
		    "code" => "COMPLAINANT-L",
		    "permission_type_code" => "LIST",
		    "permission_group_code" => "COMPLAINANT",
		    "role_ids" => []
	    ]);
	    self::updateOrCreate([
		    "name" => "Chỉnh sửa người khiếu nại",
		    "description" => "",
		    "code" => "COMPLAINANT-U",
		    "permission_type_code" => "UPDATE",
		    "permission_group_code" => "COMPLAINANT",
		    "role_ids" => []
	    ]);
	    /* Người khiếu nại::end */

        /* Bài viết::start */
        self::updateOrCreate([
            "name" => "Xem danh sách bài viết",
            "description" => "",
            "code" => "POST-L",
            "permission_type_code" => "LIST",
            "permission_group_code" => "POST",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Thêm mới bài viết",
            "description" => "",
            "code" => "POST-C",
            "permission_type_code" => "CREATE",
            "permission_group_code" => "POST",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Cập nhật bài viết",
            "description" => "",
            "code" => "POST-U",
            "permission_type_code" => "UPDATE",
            "permission_group_code" => "POST",
            "role_ids" => []
        ]);

        self::updateOrCreate([
            "name" => "Xóa bài viết",
            "description" => "",
            "code" => "POST-DEL",
            "permission_type_code" => "DELETE",
            "permission_group_code" => "POST",
            "role_ids" => []
        ]);
        /* Bài viết::end */

        /* Khiếu nại::start */
        self::updateOrCreate([
            "name" => "Xem danh sách khiếu nại",
            "description" => "",
            "code" => "COMPLAIN-L",
            "permission_type_code" => "LIST",
            "permission_group_code" => "COMPLAIN",
            "role_ids" => []
        ]);
        self::updateOrCreate([
            "name" => "Xem chi tiết khiếu nại",
            "description" => "",
            "code" => "COMPLAIN-DETAIL",
            "permission_type_code" => "DETAIL",
            "permission_group_code" => "COMPLAIN",
            "role_ids" => []
        ]);
        /* Khiếu nại::end */
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

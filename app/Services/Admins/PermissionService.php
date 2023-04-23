<?php

namespace App\Services\Admins;

use App\Models\Admins\PermissionGroup;
use App\Models\Admins\Role;
use Illuminate\Support\Facades\Log;
use Exception;

class PermissionService
{
    public function index(){
        try {
            $permissionGroups = PermissionGroup::query()
                ->whereNull("parent_code")
                ->with(["children", "permissions"]);
            return $permissionGroups->get();
        } catch (Exception $e) {
            Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách quyền hạn của vai trò", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage()
            ]);

            return false;
        }
    }
}

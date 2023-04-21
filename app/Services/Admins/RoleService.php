<?php

namespace App\Services\Admins;

use App\Models\Admins\PermissionType;
use Illuminate\Http\Request;
use App\Models\Admins\Employee;
use App\Models\Admins\Role;
use App\Models\Clients\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class RoleService
{
    /**
     * @param $request
     * @return Collection|bool|array
     */
	public function index($request): Collection|bool|array
	{
		try {
			$roles = Role::query()
                ->with(["children" => function($q) {
                    $q->select([
                        "name", "description", "is_protected", "parent_id",
                        "created_at", "permission_ids"
                    ]);
                }])->whereNull("parent_id");

			return $roles->latest()->get([
				"name", "description", "is_protected", "parent_id",
				"created_at", "updated_at"
			]);
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách vai trò", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"data" => $request->all()
			]);

			return false;
		}
	}

    public function getAdminsRole(Request $request, $id){
        try {
            $query = Employee::query();
            if($request->has('has_role')){
                $query->whereIn('role_ids', [$id]);
            }else{
                $query->whereNotIn('role_ids', [$id]);
            }
            return $query->get(["name", "email"]);
        } catch (Exception $e) {
            Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách những người không thuộc vai trò", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage()
            ]);

            return false;
        }
    }

    public function updateRoleForEmployees(Request $request, $id)
    {
        try {
            $employeeIds = $request->employee_ids;
            $remove = $request->is_remove;
            foreach ($employeeIds as $employeeId){
                $employee = Employee::find($employeeId);
                $roles = $employee->role_ids ?: [];
                if($remove){
                    $roles = array_diff($roles, [$id]);
                } else {
                    $roles[] = $id;
                }
                $employee->roles()->sync($roles);
                $employee->save();
            }
            return true;
        } catch (Exception $e) {
            Log::error("ERROR - Đã có lỗi xảy ra khi thêm quyền vào vai trò", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage()
            ]);

            return false;
        }
    }

	/**
	 * @param $request
	 *
	 * @return bool
	 */
	public function store($request): bool
	{
		try {
			Role::query()->create([
				"name" => $request->name,
				"description" => $request->description,
				"is_protected" => false,
				"permission_ids" => [],
				"employee_ids" => [],
                "parent_id" => $request->parent_id ?: null
			]);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi tạo mới vai trò", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"data" => $request->all()
			]);

			return false;
		}
	}

	/**
	 * @param $request
	 * @param $id
	 *
	 * @return bool
	 */
	public function update($request, $id): bool
	{
		try {
			Role::query()->find($id)->update([
				"name" => $request->name,
				"description" => $request->description,
                "parent_id" => $request->parent_id ?: null
			]);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi cập nhật thông tin vai trò", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => $id,
				"data" => $request->all()
			]);

			return false;
		}
	}

	/**
	 * @param $request
	 * @param $id
	 *
	 * @return bool
	 */
	public function syncPermissions($request, $id): bool
	{
		try {
            $remove = $request->is_remove;
            $role = Role::find($id);
            $permissions = $role->permission_ids ?: [];
            if($remove){
                $permissions = array_diff($permissions, [$id]);
            } else {
                $permissions[] = $id;
            }
            $role->permissions()->sync($permissions);

	        return true;
	    } catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi đồng bộ hóa quyền hạn của vai trò", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => $id,
				"data" => $request->all()
			]);

			return false;
		}
	}

	/**
	 * @param $id
	 *
	 * @return bool
	 */
	public function destroy($id): bool
	{
		try {
			Role::destroy($id);
            $query = Employee::query()->whereIn('role_ids', [$id]);
            $employees = $query->get();
            foreach ($employees as $employee) {
                $roles = $employee->role_ids ?: [];
                $roles = array_diff($roles, [$id]);
                $employee->roles()->sync($roles);
                $employee->save();
            }
			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi xóa vai trò", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => $id
			]);

			return false;
		}
	}

    public function getPermissionTypes()
    {
        try {
            return PermissionType::query()->orderBy("position")->get();
        } catch (Exception $e) {
            Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách kiểu quyền", [
                "method" => __METHOD__,
                "line" => __LINE__,
                "message" => $e->getMessage(),
            ]);

            return false;
        }
    }
}

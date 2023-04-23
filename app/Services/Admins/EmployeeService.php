<?php

namespace App\Services\Admins;

use App\Models\Admins\District;
use App\Models\Admins\Employee;
use App\Models\Admins\Role;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EmployeeService
{
	/**
	 * @param $request
	 *
	 * @return LengthAwarePaginator|bool
	 */
	public function index($request): LengthAwarePaginator|bool
	{
		try {
			$perPage = $request->per_page ?: config('constants.per_page');
			$employee = Employee::query()->with(["roles", "district"]);

			if ($request->filled("q")) {
				$keyword = $request->q;
				$employee->where("name", "LIKE", "%" . $keyword . "%")
					->orWhere("email", "LIKE", "%" . $keyword . "%")
					->orWhere("phone", "LIKE", "%" . $keyword . "%");
			}

			return $employee->latest()->paginate($perPage);
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách cán bộ", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"data" => $request->all()
			]);

			return false;
		}
	}

	public function getAllRole()
	{
		try {
			$query = Role::query()->where("is_protected", false);
			return $query->get(["name"]);
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách vai trò", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

			return false;
		}
	}

	public function getAllDistrict()
	{
		try {
			return District::all();
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách huyện", [
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
			Employee::query()->create([
				"name" => $request->name,
				"email" => $request->email,
				"phone" => $request->phone,
				"password" => Hash::make($request->password),
				"status" => (int)$request->status,
				"is_admin" => false,
				"district_id" => $request->district_id,
				"role_ids" => []
			])->roles()->sync($request->role_ids);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi tạo mới cán bộ", [
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
			$employee = Employee::query()->find($id);
			$employee->update([
				"name" => $request->name,
				"email" => $request->email,
				"phone" => $request->phone,
				"status" => (int)$request->status,
				"district_id" => $request->district_id,
				"role_ids" => []
			]);
			$employee->roles()->sync($request->role_ids);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi cập nhật thông tin cán bộ", [
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
	public function updateStatus($request, $id): bool
	{
		try {
			Employee::query()->find($id)->update([
				"status" => (int)$request->status
			]);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi cập nhật trạng thái cán bộ", [
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
	public function updatePassword($request, $id): bool
	{
		try {
			Employee::query()->find($id)->update([
				"password" => Hash::make($request->password),
			]);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi cập nhật mật khẩu cán bộ", [
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
			Employee::destroy($id);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi xóa cán bộ", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => $id
			]);

			return false;
		}
	}
}

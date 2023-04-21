<?php

namespace App\Services\Admins;

use App\Models\Admins\Employee;
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
			$keyword = $request->keyword;
			$perPage = $request->per_page ?: config('constants.per_page');
			$employee = Employee::query()->with(["roles"]);

			if ($request->filled("keyword")) {
				$employee->whereRaw(['$text' => ['$search' => $keyword]]);
			}

			if ($request->filled("column") && $request->filled("direction")) {
				$employee->orderBy(
					$request->column,
					$request->direction
				);
			} else if ($request->filled("keyword")) {
				$employee->orderBy('score', ['$meta' => 'textScore']);
			} else {
				$employee->latest();
			}

			return $employee->paginate($perPage);
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi lấy danh sách nhân viên", [
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
	 *
	 * @return bool
	 */
	public function store($request): bool
	{
		try {
			$avatarPath = "";
			$keyword = [$request->name, $request->email, $request->phone];

			if ($request->hasFile("avatar_path")) {
				$avatarPath = Storage::disk("public")->put("admins/avatars", $request->file('avatar_path'));
			}

			Employee::query()->create([
				"name" => $request->name,
				"email" => $request->email,
				"phone" => $request->phone,
				"password" => Hash::make($request->password),
				"avatar_path" => $avatarPath,
				"status" => (int)$request->status,
				"keyword" => collect($keyword)->implode(" "),
				"role_ids" => []
			]);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi tạo mới nhân viên", [
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
			$keyword = [$request->name, $request->email, $request->phone];

			$avatarPath = $request->hasFile("avatar_path") ?
				Storage::disk("public")->put("admins/avatars", $request->file('avatar_path')) :
				$employee->avatar_path;

			$employee->update([
				"name" => $request->name,
				"email" => $request->email,
				"phone" => $request->phone,
				"avatar_path" => $avatarPath,
				"status" => (int)$request->status,
				"keyword" => collect($keyword)->implode(" ")
			]);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi cập nhật thông tin nhân viên", [
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
			Log::error("ERROR - Đã có lỗi xảy ra khi cập nhật trạng thái nhân viên", [
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
			Log::error("ERROR - Đã có lỗi xảy ra khi cập nhật mật khẩu nhân viên", [
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
			Log::error("ERROR - Đã có lỗi xảy ra khi xóa nhân viên", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => $id
			]);

			return false;
		}
	}
}

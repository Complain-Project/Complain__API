<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Models\Admins\Employee;
use App\Models\Admins\Permission;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
	/**
	 * @return JsonResponse
	 */
	public function signIn(): JsonResponse
	{
		try {
			$credentials = request(["email", "password"]);

			if (!$token = Auth::guard("admins")->attempt($credentials)) {
				return ResponseTrait::responseError(
					"Tài khoản hoặc mật khẩu không chính xác", [],
					Response::HTTP_UNAUTHORIZED,
					Response::HTTP_UNAUTHORIZED,
				);
			} else {
				if (Auth::guard("admins")->user()->status === Employee::ACTIVE_STATUS["DEACTIVATE"]) {
					return ResponseTrait::responseError(
						"Tài khoản đã bị khóa", [],
						Response::HTTP_UNAUTHORIZED,
						Response::HTTP_UNAUTHORIZED,
					);
				}
			}

			return $this->respondWithToken($token);
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi đăng nhập", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"email" => request("email"),
			]);

			return ResponseTrait::responseError();
		}
	}

	/**
	 * @return JsonResponse
	 */
	public function me(): JsonResponse
	{
		try {
			if (Auth::guard("admins")->user()->status === Employee::ACTIVE_STATUS["ACTIVATED"]) {
				$roles = Auth::guard("admins")->user()->roles;
				$auth = collect($roles)->map(function ($role) {
					return $role->permission_ids;
				});

				$permissionIds = $auth->flatten()->unique();
				$permissionCodes = Permission::query()
					->whereIn("_id", $permissionIds)
					->pluck("code");

				Auth::guard("admins")->user()->makeHidden(["roles", "role_ids", "status"]);
				Auth::guard("admins")->user()->permissions = $permissionCodes;

				return ResponseTrait::responseSuccess(Auth::guard("admins")->user());
			}

			return ResponseTrait::responseError(
				"Tài khoản đã bị khóa", [],
				Response::HTTP_UNAUTHORIZED
			);
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi lấy thông tin người dùng", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => Auth::guard("admins")->id(),
			]);

			return ResponseTrait::responseError();
		}
	}

	/**
	 * @return JsonResponse
	 */
	public function logout(): JsonResponse
	{
		try {
			Auth::guard("admins")->logout();

			return ResponseTrait::responseSuccess(["message" => "Đăng xuất thành công"]);
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi đăng xuất", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => Auth::guard("admins")->id(),
			]);

			return ResponseTrait::responseError();
		}
	}

	/**
	 * @return JsonResponse
	 */
	public function refresh(): JsonResponse
	{
		try {
			return $this->respondWithToken(Auth::guard("admins")->refresh());
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi làm mới token", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => Auth::guard("admins")->id(),
			]);

			return ResponseTrait::responseError();
		}
	}

	/**
	 * @param $token
	 *
	 * @return JsonResponse
	 */
	protected function respondWithToken($token): JsonResponse
	{
		return ResponseTrait::responseSuccess([
			"access_token" => $token,
			"token_type" => "bearer",
			"expires_in" => Auth::guard("admins")->factory()->getTTL() * 60
		]);
	}
}

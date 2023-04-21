<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Clients\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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

			if (!$token = Auth::guard("clients")->attempt($credentials)) {
				return ResponseTrait::responseError(
					"Tài khoản hoặc mật khẩu không chính xác", [],
					Response::HTTP_UNAUTHORIZED,
					Response::HTTP_UNAUTHORIZED,
				);
			} else {
				if (Auth::guard("clients")->user()->status === User::ACTIVE_STATUS["DEACTIVATE"]) {
					return ResponseTrait::responseError(
						"Tài khoản đã bị khóa", [],
						Response::HTTP_UNAUTHORIZED,
						Response::HTTP_UNAUTHORIZED,
					);
				} else if (Auth::guard("clients")->user()->status === User::ACTIVE_STATUS["PENDING_ACTIVATION"]) {
					return ResponseTrait::responseError(
						"Tài khoản chưa được kích hoạt", [],
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
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function signUp(Request $request): JsonResponse
	{
		try {
			$code = $this->generateCode();

			User::query()->create([
				"code" => $code,
				"name" => $request->name,
				"email" => $request->email,
				"password" => Hash::make($request->password),
				"avatar_path" => "",
				"description" => "",
				"slug" => Str::slug($request->name, "-"),
				"status" => User::ACTIVE_STATUS["PENDING_ACTIVATION"],
				"priority" => User::PRIORITY_TYPE["GENERAL"],
				"type" => User::TYPE["GENERAL"],
				"social_type" => User::SOCIAL_TYPE["NORMAL"],
				"verify_code" => Str::random(),
				"verify_code_expired" => Carbon::now()->addMinute()->timestamp,
				"verify_email_at" => null,
				"song_ids" => [],
				"post_ids" => [],
			]);

			return ResponseTrait::responseSuccess();
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi đăng ký tài khoản người dùng", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"data" => $request->all(),
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
			if (Auth::guard("clients")->user()->status === User::ACTIVE_STATUS["ACTIVATED"]) {
				return ResponseTrait::responseSuccess([Auth::guard("clients")->user()]);
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
				"id" => Auth::guard("clients")->id(),
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
			Auth::guard("clients")->logout();

			return ResponseTrait::responseSuccess(["message" => "Đăng xuất thành công"]);
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi đăng xuất", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => Auth::guard("clients")->id(),
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
			return $this->respondWithToken(Auth::guard("clients")->refresh());
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi làm mới token", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage(),
				"id" => Auth::guard("clients")->id(),
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
			"expires_in" => Auth::guard("clients")->factory()->getTTL() * 60
		]);
	}

	/**
	 * @return string|null
	 */
	private function generateCode(): ?string
	{
		try {
			$code = null;
			$exists = true;

			while($exists) {
				$code = Str::random(8);
				$user = User::query()->firstWhere("code", $code);
				$exists = !!$user;
			}

	        return $code;
	    } catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi tạo code người dùng mới", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

			return null;
		}
	}
}

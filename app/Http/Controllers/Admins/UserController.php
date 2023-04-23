<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Services\Admins\UserService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
	private $userService;

	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		$users = $this->userService->index($request);

		return $users ? ResponseTrait::responseSuccess($users) : ResponseTrait::responseError();
	}

	/**
	 * @param Request $request
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function updateStatus(Request $request, $id): JsonResponse
	{
		$user = $this->userService->updateStatus($request, $id);

		return $user ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}
}

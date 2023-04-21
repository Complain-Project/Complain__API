<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Services\Admins\EmployeeService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
	private EmployeeService $employeeService;

	/**
	 * @param EmployeeService $employeeService
	 */
	public function __construct(EmployeeService $employeeService)
    {
		$this->employeeService = $employeeService;
    }

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		$employees = $this->employeeService->index($request);

		return $employees ? ResponseTrait::responseSuccess($employees) : ResponseTrait::responseError();
	}

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function store(Request $request): JsonResponse
	{
		$employee = $this->employeeService->store($request);

		return $employee ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}

	/**
	 * @param Request $request
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function update(Request $request, $id): JsonResponse
	{
		$employee = $this->employeeService->update($request, $id);

		return $employee ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}

	/**
	 * @param Request $request
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function updateStatus(Request $request, $id): JsonResponse
	{
		$employee = $this->employeeService->updateStatus($request, $id);

		return $employee ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}

	/**
	 * @param Request $request
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function updatePassword(Request $request, $id): JsonResponse
	{
		$employee = $this->employeeService->updatePassword($request, $id);

		return $employee ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}

	/**
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function destroy($id): JsonResponse
	{
		$employee = $this->employeeService->destroy($id);

		return $employee ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}
}

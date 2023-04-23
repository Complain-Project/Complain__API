<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\Employees\StoreEmployeeRequest;
use App\Http\Requests\Admins\Employees\UpdateEmployeeRequest;
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

	public function getAllRole(): JsonResponse
	{
		$roles = $this->employeeService->getAllRole();

		return $roles ? ResponseTrait::responseSuccess($roles) : ResponseTrait::responseError();
	}

	public function getAllDistrict(): JsonResponse
	{
		$districts = $this->employeeService->getAllDistrict();

		return $districts ? ResponseTrait::responseSuccess($districts) : ResponseTrait::responseError();
	}

	/**
	 * @param StoreEmployeeRequest $request
	 *
	 * @return JsonResponse
	 */
	public function store(StoreEmployeeRequest $request): JsonResponse
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
	public function update(UpdateEmployeeRequest $request, $id): JsonResponse
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

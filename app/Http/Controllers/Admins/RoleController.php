<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\Roles\StoreRoleRequest;
use App\Http\Requests\Admins\Roles\SyncPermissionRequest;
use App\Http\Requests\Admins\Roles\UpdateRoleRequest;
use App\Services\Admins\RoleService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	private RoleService $roleService;

	public function __construct(RoleService $roleService)
	{
		$this->roleService = $roleService;
	}

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function index(Request $request): JsonResponse
	{
		$roles = $this->roleService->index($request);

		return $roles ? ResponseTrait::responseSuccess($roles) : ResponseTrait::responseError();
	}

	public function rolesAction(Request $request): JsonResponse
	{
		$roles = $this->roleService->rolesAction($request);

		return $roles ? ResponseTrait::responseSuccess($roles) : ResponseTrait::responseError();
	}

    public function getAdminsRole(Request $request, $id)
    {
        $employees = $this->roleService->getAdminsRole($request, $id);

        return $employees ? ResponseTrait::responseSuccess($employees) : ResponseTrait::responseError();
    }

    public function updateRoleForEmployees(Request $request, $id)
    {
        $roles = $this->roleService->updateRoleForEmployees($request, $id);

        return $roles ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
    }

	/**
	 * @param StoreRoleRequest $request
	 *
	 * @return JsonResponse
	 */
	public function store(StoreRoleRequest $request): JsonResponse
	{
		$role = $this->roleService->store($request);

		return $role ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}

	/**
	 * @param UpdateRoleRequest $request
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function update(UpdateRoleRequest $request, $id): JsonResponse
	{
		$role = $this->roleService->update($request, $id);

		return $role ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}

	/**
	 * @param SyncPermissionRequest $request
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function syncPermissions(SyncPermissionRequest $request, $id): JsonResponse
	{
		$role = $this->roleService->syncPermissions($request, $id);

		return $role ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}

	/**
	 * @param $id
	 *
	 * @return JsonResponse
	 */
	public function destroy($id): JsonResponse
	{
		$role = $this->roleService->destroy($id);

		return $role ? ResponseTrait::responseSuccess() : ResponseTrait::responseError();
	}

    public function getPermissionTypes()
    {
        $types = $this->roleService->getPermissionTypes();

        return $types ? ResponseTrait::responseSuccess($types) : ResponseTrait::responseError();
    }
}

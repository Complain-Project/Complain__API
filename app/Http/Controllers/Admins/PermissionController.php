<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Services\Admins\PermissionService;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class PermissionController extends Controller
{
    private PermissionService $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    public function index() {
        $permissions = $this->permissionService->index();

        return $permissions ? ResponseTrait::responseSuccess($permissions) : ResponseTrait::responseError();
    }
}

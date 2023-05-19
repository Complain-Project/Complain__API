<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Services\Admins\DashboardService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
	use ResponseTrait;

	private DashboardService $dashboardService;

	/**
	 * @param DashboardService $dashboardService
	 */
	public function __construct(DashboardService $dashboardService)
	{
		$this->dashboardService = $dashboardService;
	}

	/**
	 * @param Request $request
	 *
	 * @return JsonResponse
	 */
	public function statistical(Request $request)
	{
		$complains = $this->dashboardService->statistical($request);

		return $complains ? $this->responseSuccess($complains) : $this->responseError();
	}

	public function getDistrict(Request $request)
	{
		$districts = $this->dashboardService->getDistrict();

		return $districts ? $this->responseSuccess($districts) : $this->responseError();
	}
}

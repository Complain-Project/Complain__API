<?php

namespace App\Services\Admins;

use App\Models\Admins\District;
use App\Models\Clients\Complain;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class DashboardService
{
	public function statistical(Request $request)
	{
		try {
			$districtID = $request->input("district_id");
			$query = Complain::query();

			$firstCondition = $request->filled("start_time") && $request->filled("end_time");

			if ($firstCondition) {
				$startTime = Carbon::createFromFormat("Y-m-d", $request->input("start_time"))->startOfDay();
				$endTime = Carbon::createFromFormat("Y-m-d", $request->input("end_time"))->endOfDay();
				$query->whereBetween("updated_at", [$startTime, $endTime]);
			}

			$complains = $query->get();

			$labels = [];
			$total = [];
			$processed = [];
			$no_process = [];

			if ($complains) {
				$districts = District::query();

				if ($districtID) {
					$districts->where("_id", $districtID);
				}

				$districts = $districts->get();

				if (count($districts) > 0) {
					$labels = Arr::pluck($districts, 'name');

					foreach ($districts as $district) {
						$total[] = collect($complains)->where('district_id', $district->_id)->count();
						$processed[] = collect($complains)
							->where('district_id', $district->_id)
							->where('status', Complain::STATUS["PROCESSED"])
							->count();
						$no_process[] = collect($complains)
							->where('district_id', $district->_id)
							->where('status', Complain::STATUS["NO_PROCESS"])
							->count();
					}
				}
			}
			
	        return [
				"labels" => $labels,
				"total" => $total,
				"processed" => $processed,
				"no_process" => $no_process,
	        ];
	    } catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra khi thống kê khiếu nại", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

			return false;
		}
	}

	public function getDistrict()
	{
		try {
			return District::all();
		} catch (Exception $e) {
			Log::error("ERROR - Đã có lỗi xảy ra lấy danh sách huyện", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

			return false;
		}
	}
}

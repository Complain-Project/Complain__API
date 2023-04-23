<?php

namespace App\Services\Admins;

use App\Models\Clients\User;
use Exception;
use Illuminate\Support\Facades\Log;

class UserService
{
	public function index($request)
	{
		try {
			$perPage = $request->per_page ?: config('constants.per_page');
			$employee = User::query();

			if ($request->filled("q")) {
				$keyword = $request->q;
				$employee->where("name", "LIKE", "%" . $keyword . "%")
					->orWhere("aliases", "LIKE", "%" . $keyword . "%")
					->orWhere("email", "LIKE", "%" . $keyword . "%")
					->orWhere("phone", "LIKE", "%" . $keyword . "%");
			}

			return $employee->latest()->paginate($perPage);
	    } catch (Exception $e) {
			Log::error("ERROR - ", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

			return false;
		}
	}

	public function updateStatus($request, $id): bool
	{
		try {
			User::query()->find($id)->update([
				"status" => $request->status
			]);

			return true;
		} catch (Exception $e) {
			Log::error("ERROR - ", [
				"method" => __METHOD__,
				"line" => __LINE__,
				"message" => $e->getMessage()
			]);

			return false;
		}
	}
}

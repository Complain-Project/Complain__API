<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class Service
{
	public function index()
	{
		try {
			
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

	public function show($id)
	{
		try {

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

	public function store($request): bool
	{
		try {

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

	public function update($request, $id): bool
	{
		try {

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

	public function destroy($id): bool
	{
		try {

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

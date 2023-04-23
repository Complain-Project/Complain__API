<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ResponseTrait
{
	/**
	 * @param mixed $data
	 * @param string $message
	 * @param int $code
	 * @param int $httpStatusCode
	 *
	 * @return JsonResponse
	 */
	public static function responseSuccess(
		mixed $data = [], string $message = "success",
		int   $code = Response::HTTP_OK,
		int   $httpStatusCode = Response::HTTP_OK
	): JsonResponse
	{
		return response()->json([
			"code" => $code,
			"message" => $message,
			"data" => $data,
		], $httpStatusCode);
	}

	/**
	 * @param string $message
	 * @param array $data
	 * @param int $httpStatusCode
	 * @param int $code
	 *
	 * @return JsonResponse
	 */
	public static function responseError(
		string $message = "error", mixed $data = [],
		int    $code = Response::HTTP_INTERNAL_SERVER_ERROR,
		int    $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR
	): JsonResponse
	{
		return response()->json([
			"code" => $code,
			"message" => $message,
			"error" => $data,
		], $httpStatusCode);
	}
}

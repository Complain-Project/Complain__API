<?php

namespace App\Http\Requests\Admins\Roles;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SyncPermissionRequest extends Request
{
	/**
	 * @return true
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * @return array
	 */
	public function rules(): array
	{
		return [
			"permission_ids" => "array",
			"permission_ids.*" => Rule::exists("permissions", "_id"),
		];
	}

	/**
	 * @return string[]
	 */
	public function messages(): array
	{
		return [
			"array" => ":attribute sai định dạng.",
			"exists" => ":attribute không tồn tại."
		];
	}

	/**
	 * @return string[]
	 */
	public function attributes(): array
	{
		return [
			"permission_ids" => "Quyền hạn",
			"permission_ids.*" => "Quyền hạn",
		];
	}
}

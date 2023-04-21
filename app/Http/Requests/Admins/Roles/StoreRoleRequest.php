<?php

namespace App\Http\Requests\Admins\Roles;

use App\Http\Requests\Request;

class StoreRoleRequest extends Request
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
			"name" => "required|max:256|unique:roles,name",
			"description" => "nullable|max:256",
		];
	}

	/**
	 * @return string[]
	 */
	public function messages(): array
	{
		return [
			"required" => ":attribute không được để trống.",
			"unique" => ":attribute đã tồn tại.",
			"max" => ":attribute tối đa :max ký tự.",
		];
	}

	/**
	 * @return string[]
	 */
	public function attributes(): array
	{
		return [
			"name" => "Tên vai trò",
			"description" => "Mô tả",
		];
	}
}

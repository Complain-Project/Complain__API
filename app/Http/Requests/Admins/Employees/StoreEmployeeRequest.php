<?php

namespace App\Http\Requests\Admins\Employees;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
			'email'     => 'required|email|unique:employees',
			'phone'     => ['required','unique:employees','regex:/(84|0[3|5|7|8|9])+([0-9]{8})\b/'],
		];
	}

	/**
	 * @return string[]
	 */
	public function messages(): array
	{
		return [
			'required'  => ':attribute không được để trống',
			'email'     => ':attribute sai định dạng',
			'unique'    => ':attribute đã tồn tại.',
			'regex'     => ':attribute sai định dạng',
		];
	}

	/**
	 * @return string[]
	 */
	public function attributes(): array
	{
		return [
			'email'     => 'Email',
			'phone'     => 'Số điện thoại',
		];
	}
}

<?php

namespace App\Http\Requests\Admins\Auths;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateYourSelfRequest extends FormRequest
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
			'email'     => [
				'required','email',
				Rule::unique('employees')->ignore(auth()->user()->_id, '_id')
			],
			'phone'     => [
				'required',
				Rule::unique('employees')->ignore(auth()->user()->_id, '_id'),
				'regex:/(84|0[3|5|7|8|9])+([0-9]{8})\b/'
			],
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

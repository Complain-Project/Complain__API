<?php

namespace App\Http\Requests\Clients\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateInformationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
            "aliases" => "required",
            "phone" => [
                "required",
                "regex:/(84|0[3|5|7|8|9])+([0-9]{8})\b/",
                Rule::unique("users", "phone")
                    ->ignore(Auth::guard('clients')->id(), "_id")
            ],
            "email" => 'email'
        ];
    }

    public function messages()
    {
        return [
            "required" => ":attribute không được để trống",
            "regex" => ":attribute không hợp lệ",
            "unique" => ":attribute đã tồn tại",
            "email" => ":attribute sai định dạng",
        ];
    }

    public function attributes()
    {
        return [
            "name" => "Họ tên",
            "aliases" => "Bí danh",
            "phone" => "Số điện thoại",
            "email" => "Email",
        ];
    }
}

<?php

namespace App\Http\Requests\Clients\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            "old_password" => "required|current_password:users",
            "new_password" => "required|min:6",
            "confirm_password" => "required|same:new_password",
        ];
    }

    public function messages()
    {
        return [
            "required" => ":attribute không được để trống.",
            "current_password" => ":attribute không chính xác.",
            "min" => ":attribute tối thiểu :min ký tự.",
            "same" => ":attribute không khớp với mật khẩu mới.",
        ];
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            "old_password" => "Mật khẩu cũ",
            "new_password" => "Mật khẩu mới",
            'confirm_password' => "Mật khẩu xác nhận"
        ];
    }
}

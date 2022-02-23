<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|between2,6',
            'pass' => 'required|between:8,18'
        ];
    }

    /**
     * return error msg
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required' => '请输入用户名',
            'name.between' => '用户名在2到6个字符之间',
            'pass.required' => '请输入密码',
            'pass.between' => '密码在8到18个字符之间',
        ];
    }
}

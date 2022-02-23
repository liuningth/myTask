<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'id' => 'required|integer',
            'name' => 'required|between1,36',
            'image' => 'required',
        ];
    }

    /**
     * return error msg
     * @return string[]
     */
    public function messages()
    {
        return [
            'id.required' => 'id不能为空',
            'id.integer' => 'id必须为整形数字',
            'name.required' => '请输入产品名',
            'name.between' => '产品名在1到36个字符之间',
            'image.required' => '请上传图片',
        ];
    }
}

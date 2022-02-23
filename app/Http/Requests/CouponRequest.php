<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'money' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required',
            'products' => 'required',
            'adminId' => 'required|integer',
        ];
    }

    /**
     * return error msg
     * @return string[]
     */
    public function messages()
    {
        return [
            'money.required' => '请输入金额',
            'money.integer' => '产品的价格必须为整数',
            'start_time.required' => '开始时间不能为空',
            'end_time.required' => '结束时间不能为空',
            'products.required' => '请选择对应的商品',
            'adminId.required' => '管理员id不能为空',
            'adminId.integer' => '管理员id必须为整数',
        ];
    }
}

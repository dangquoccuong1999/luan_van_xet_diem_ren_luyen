<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use  Illuminate\Support\Facades\DB;

class ProfileRequest extends FormRequest
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
            'name' => 'required|min:8|max:255',
            'sodienthoai' => 'required|size:10',
            'diachi' => 'required|min:8|max:255',
            'password' => 'required|min:8',
            'email' => 'required|email',
        ];
    }

    public funcTion messages()
    {
        return [
            'required' => 'Không được để trống',
            'max' => 'Không được nhập quá 255 kí tự',
            'size' => "Số điện thoại có 10 số",
            'integer' => "Nhập vào phải là số",
            'email' => "Nhập vào phải là email",
            'min' => "Nhập vào phải có ít nhất 8 kí tự"
        ]; 
    }
}

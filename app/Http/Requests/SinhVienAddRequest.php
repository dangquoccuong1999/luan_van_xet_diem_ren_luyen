<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SinhVienAddRequest extends FormRequest
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
            'masv' => 'unique:sinhviens,masv'
        ];
    }

    public function messages()
    {
        return [
            'masv.unique' => 'Mã sinh viên đã tồn tại'

        ];
    }
}

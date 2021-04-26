<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use  Illuminate\Support\Facades\DB;
use App\Chitiettieuchi;

class ChamDiemRequest extends FormRequest
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
        $tongSoLuongChiTietTieuChi = DB::select("SELECT * FROM chitiettieuchis where vipham != 1");

        $tongSoLuongVP = DB::select("SELECT *  FROM chitiettieuchis where vipham = 1");

        $arrDiem = [];
        $arrDiemVP = [];


        foreach ($tongSoLuongChiTietTieuChi as $tc) {
            $diemSV =  "diemSV-" . $tc->id;
            $diemMax = $tc->sodiem;
            $arrDiem[$diemSV] = "required|numeric|max:$diemMax|min:0";
        }


        foreach ($tongSoLuongVP as $vp) {
            $diemVP =  "diemvipham-" . $vp->id;
            $diemMin = $vp->sodiem;
            $arrDiemVP[$diemVP] = "required|numeric|max:0|min:$diemMin";
        }

        $arrValid = array_merge($arrDiem, $arrDiemVP);
        return $arrValid;
    }

    public function messages()
    {

        $tongSoLuongChiTietTieuChi = DB::select("SELECT * FROM chitiettieuchis where vipham != 1");

        $tongSoLuongVP = DB::select("SELECT *  FROM chitiettieuchis where vipham = 1");

        $arrDiem = [];
        $arrDiemVP = [];

        foreach ($tongSoLuongChiTietTieuChi as $tc) {
            $diemSV =  "diemSV-" . $tc->id;
            $arrDiem["$diemSV.required"] = 'Điểm không được để trống';
            $arrDiem["$diemSV.integer"] = 'Điểm nhập vào phải là số';
            $arrDiem["$diemSV.max"] = 'Điểm nhập vào phải bé hơn thang điểm quy định';
            $arrDiem["$diemSV.min"] = 'Điểm nhập vào phải lớn hơn 0';
        }

        foreach ($tongSoLuongVP as $vp) {
            $diemVP =  "diemvipham-" . $vp->id;

            $arrDiem["$diemVP.required"] = 'Điểm không được để trống';
            $arrDiem["$diemVP.integer"] = 'Điểm nhập vào phải là số';
            $arrDiem["$diemVP.max"] = 'Điểm nhập vào phải bé hơn thang điểm quy định';
            $arrDiem["$diemVP.min"] = 'Điểm nhập vào phải lớn hơn 0';
        }

        $arrValid = array_merge($arrDiem, $arrDiemVP);

        return $arrValid; 
    }
}

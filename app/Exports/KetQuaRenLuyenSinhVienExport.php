<?php

namespace App\Exports;

use App\Sinhvien;
use Maatwebsite\Excel\Concerns\FromCollection;
use  Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KetQuaRenLuyenSinhVienExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents

{
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }



    public function headings(): array
    {
        return [
            'Mã sinh viên',
            'Họ tên',
            'Tổng điểm',
            'Xếp loại'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }

    public function collection()
    {
        $hocki = DB::select("SELECT * FROM `hocki` WHERE active = 1");
        $hockiID = $hocki[0]->id;

        $sinhViens =  DB::table('sinhviens')->join('users', 'sinhviens.user_id', '=', 'users.id')
            ->select('users.maso', 'sinhviens.name', 'sinhviens.user_id')->where('sinhviens.lop_id', $this->id)->get();

        
        foreach ($sinhViens as $item => $sv) {
            $id =  $sv->user_id;
            $diemDB = DB::select("SELECT SUM(diem) as 'diem' FROM diem_danh_gias WHERE user_sinhvien = $id and hocki_id = $hockiID ");
            $diem = $diemDB[0]->diem;
            $sv->diem = $diem;
            $xepLoai = "";
            $this->checkXemUserDaChamDiemChua  = DB::select("SELECT * FROM `diem_danh_gia_banchunhiemkhoa` WHERE hocki_id = $hockiID AND user_sinhvien =  $sv->user_id");
            if (!empty($diem)) {
                if ($diem < 35) {
                    $xepLoai = "Kém";
                } else if ($diem >= 35 && $diem <= 50) {
                    $xepLoai = "Yếu";
                } else if ($diem >= 50 && $diem <= 65) {
                    $xepLoai = "Trung bình";
                } else if ($diem >= 65 && $diem <= 80) {
                    $xepLoai = "Khá";
                } else if ($diem >= 80 && $diem <= 90) {
                    $xepLoai = "Tốt";
                } else {
                    $xepLoai = "Xuất sắc";
                }
            }
            unset($sv->user_id);
            $sv->xeploai = $xepLoai;
           
            if (empty($this->checkXemUserDaChamDiemChua)) {
                unset($sinhViens[$item]);        
            }
            if (!empty($this->checkXemUserDaChamDiemChua)) {
                if($this->checkXemUserDaChamDiemChua[0]->y_kien_bcn == 0)
                unset($sinhViens[$item]);
            }
           
        }
        return $sinhViens;
    }
}

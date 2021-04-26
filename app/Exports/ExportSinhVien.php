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

class ExportSinhVien implements FromCollection, WithHeadings, ShouldAutoSize,WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
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
            'Ngày sinh',
            'Email',
            'Số điện thoại',
            'Giới tính'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                
            },
        ];
    }

    public function collection()
    {        
        $sv = DB::table('sinhviens')->join('lops', 'sinhviens.lop_id', '=', 'lops.id')->join('users', 'sinhviens.user_id', '=', 'users.id')
            ->select('users.maso','sinhviens.name','sinhviens.ngaysinh','sinhviens.email','sinhviens.sodienthoai','sinhviens.gioitinh')->where('sinhviens.lop_id', $this->id)->get();
        return $sv;
    }
}

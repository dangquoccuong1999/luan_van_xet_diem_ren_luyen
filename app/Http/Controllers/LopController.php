<?php

namespace App\Http\Controllers;

use App\Admins;
use App\Giangvien;
use Illuminate\Http\Request;
use App\Khoa;
use App\Lop;
use App\Sinhvien;
use App\User;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\DB;

class LopController extends Controller
{
    public function getDanhSach()
    {
        $vaiTro = Auth::user()->vaitro;

        if ($vaiTro == 1) {
            $lops = DB::table('lops')->join('khoas', 'lops.khoa_id', '=', 'khoas.id')
                ->select('khoas.*', 'lops.*')->paginate(10);

            $sinhvien =  Auth::user()->maso;
            $idSinhVien = User::where("maso", $sinhvien)->get();
            $tenADMIN =  Admins::where("user_id", $idSinhVien[0]['id'])->get();
            $ten = $tenADMIN[0]['name'];
        }
        if ($vaiTro == 3) { // nếu là chủ nhiệm sẽ hiển thị các lớp mà giáo viên đó chủ nhiệm
            $sinhvien =  Auth::user()->maso;
            $idSinhVien = User::where("maso", $sinhvien)->get();


            $tenGV =  Giangvien::where("user_id", $idSinhVien[0]['id'])->get();

            $ten = $tenGV[0]['name'];

            $lops = DB::table('lops')->join('khoas', 'lops.khoa_id', '=', 'khoas.id')
                ->join('chunhiems', 'lops.id', '=', 'chunhiems.lop_id')
                ->where('chunhiems.giangvien_id', $tenGV[0]['id'])
                ->select('khoas.*', 'lops.*')->paginate(10);
        }
        if ($vaiTro == 2) {
          
            $sinhvien =  Auth::user()->maso;
            $idSinhVien = User::where("maso", $sinhvien)->get();


            $tenGV =  Giangvien::where("user_id", $idSinhVien[0]['id'])->get();
           
            $ten = $tenGV[0]['name'];

            $lops = DB::table('lops')->join('khoas', 'lops.khoa_id', '=', 'khoas.id')
                ->join('banchunhiemkhoa', 'khoas.id', '=', 'banchunhiemkhoa.khoa_id')
                ->where('banchunhiemkhoa.giangvien_id', $tenGV[0]['id'])
                ->select('khoas.*', 'lops.*')->paginate(10);
        }
  
        return view('lop.danhsach', compact('lops', 'ten'));
    }



    public function getAdd()
    {
        $khoas = Khoa::all();

        $sinhvien =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $sinhvien)->get();

        $tenSv =  Admins::where("user_id", $idSinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];


        return view('lop.add', compact('khoas', 'ten'));
    }

    public function postAdd(Request $request)
    {
        $lop = new Lop();
        $lop->tenlop = $request->tenlop;
        $lop->khoa_id = $request->khoa;
        $lop->save();
        return redirect()->route('lop.get_danhsach');
    }

    public function getEdit($id)
    {
        $lops =  Lop::find($id);
        $khoas = Khoa::all();
        $khoaHienTai = $lops->khoa_id;

        $sinhvien =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $sinhvien)->get();

        $tenSv =  Admins::where("user_id", $idSinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        return view('lop.edit', compact('ten', 'khoas', 'lops','khoaHienTai'));
    }

    public function postEdit(Request $request, $id)
    {
        $lop = Lop::find($id);
        $lop->tenlop = $request->tenlop;
        $lop->khoa_id = $request->khoa;
        $lop->save();
        return redirect()->route('lop.get_danhsach');
    }

    public function delete($id)
    {
        Lop::destroy($id);
        return redirect()->route('lop.get_danhsach');
    }
}

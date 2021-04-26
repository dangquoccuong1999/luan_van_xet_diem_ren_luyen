<?php

namespace App\Http\Controllers;

use App\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\DB;
use App\Khoa;
use App\Sinhvien;
use App\User;

class KhoaController extends Controller
{
    public function getAdd()
    {
        $sinhvien =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $sinhvien)->get();

        $tenSv =  Admins::where("user_id", $idSinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        return view('khoa.add', compact('ten'));
    }

    public function postAdd(Request $request)
    {
        $khoa = new Khoa();
        $khoa->tenkhoa = $request->tenkhoa;
        $khoa->save();
        
        return redirect()->route('khoa.get_danhsach');
    }

    public function getDanhSach()
    {
        $khoa = Khoa::all();
        $sinhvien =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $sinhvien)->get();

        $tenSv =  Admins::where("user_id", $idSinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        
        return view('khoa.danhsach', compact('khoa','ten'));
    }

    public function getEdit($id)
    {
        $khoa = Khoa::find($id);

        $sinhvien =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $sinhvien)->get();

        $tenSv =  Admins::where("user_id", $idSinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        return view('khoa.edit', compact('khoa','ten'));
    }

    public function postEdit(Request $request, $id)
    {
        $khoa = Khoa::find($id);
        $khoa->tenkhoa = $request->tenkhoa;
        $khoa->save();
        return redirect()->route('khoa.get_danhsach');
    }

    public function delete($id)
    {
        Khoa::find($id)->delete();
        return redirect()->route('khoa.get_danhsach');
    }
}

<?php

namespace App\Http\Controllers;

use App\Admins;
use App\Chitiettieuchi;
use App\Tieuchidanhgia;
use App\Tieuchuan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\DB;
use App\Vipham;
use Illuminate\Support\Facades\Session;

class NoidungdanhgiaController extends Controller
{
    //

    public function getTen()
    {
        $idSV =  Auth::user()->maso;
        $giangVien = User::where("maso", $idSV)->get();

        $user =  Admins::where("user_id", $giangVien[0]['id'])->get();
        $ten = $user[0]['name'];
        return $ten;
    }
    public function getDanhSachTieuChuan()
    {
        $ten = $this->getTen();

        $tieuChuans = Tieuchuan::all();
        return view('noidungdanhgia.tieuchuan.danhsach', compact('tieuChuans', 'ten'));
    }

    public function getEditDanhSachTieuChuan($id)
    {
        $ten = $this->getTen();

        $tieuchuan = Tieuchuan::find($id);
        return view('noidungdanhgia.tieuchuan.edit', compact('tieuchuan', 'ten'));
    }


    public function postEditDanhSachTieuChuan(Request $request, $id)
    {
        $ten = $this->getTen();

        $tieuchuan = Tieuchuan::find($id);
        $tieuchuan->name = $request->name;
        $tieuchuan->save();

        return redirect()->route('tieuchuan.get_danhsach');
    }

    public function getAddDanhSachTieuChuan(Request $request)
    {
        $ten = $this->getTen();
        return view('noidungdanhgia.tieuchuan.add', compact('ten'));
    }

    public function postAddDanhSachTieuChuan(Request $request)
    {
        $tieuChuan = new Tieuchuan();
        $tieuChuan->name = $request->name;
        $tieuChuan->save();

        return redirect()->route('tieuchuan.get_danhsach');
    }

    public function deleteDanhSachTieuChuan($id)
    {
        Tieuchuan::destroy($id);
        return redirect()->route('tieuchuan.get_danhsach');
    }

    // tieu chí

    public function getDanhSachTieuChi()
    {
        $ten = $this->getTen();
        $tieuChis = Tieuchidanhgia::all();

        return view('noidungdanhgia.tieuchi.danhsach', compact('tieuChis', 'ten'));
    }

    public function getEditDanhSachTieuChi($id)
    {
        $ten = $this->getTen();

        $tieuChuans = Tieuchuan::all();

        $tieuChi = Tieuchidanhgia::find($id);

        $tieuChuanHienTai = Tieuchuan::find($tieuChi['tieuchuan_id']);
        return view('noidungdanhgia.tieuchi.edit', compact('tieuChi', 'ten', 'tieuChuans', 'tieuChuanHienTai'));
    }


    public function postEditDanhSachTieuChi(Request $request, $id)
    {
        $tieuChi = Tieuchidanhgia::find($id);
        $tieuChi->name = $request->name;
        $tieuChi->tieuchuan_id = $request->tieuchuan_id;
        $tieuChi->save();

        return redirect()->route('tieuchi.get_danhsach');
    }

    public function getAddDanhSachTieuChi(Request $request)
    {
        $ten = $this->getTen();
        $tieuChuans = Tieuchuan::all();

        return view('noidungdanhgia.tieuchi.add', compact('ten', 'tieuChuans'));
    }

    public function postAddDanhSachTieuChi(Request $request)
    {
        $tieuChi = new Tieuchidanhgia();
        $tieuChi->name = $request->name;
        $tieuChi->tieuchuan_id = $request->tieuchuan_id;
        $tieuChi->save();
        return redirect()->route('tieuchi.get_danhsach');
    }


    public function deleteDanhSachTieuChi($id)
    {
        Tieuchidanhgia::destroy($id);
        return redirect()->route('tieuchi.get_danhsach');
    }


    // chi tiết tiêu chí

    public function getDanhSachChiTietTieuChi()
    {
        $ten = $this->getTen();
        $tieuChis = Chitiettieuchi::all();

        return view('noidungdanhgia.chitiettieuchi.danhsach', compact('tieuChis', 'ten'));
    }

    public function getEditDanhSachChiTietTieuChi($id)
    {
        $ten = $this->getTen();

        $tieuChis = Chitiettieuchi::all();

        $tieuChi = Chitiettieuchi::find($id);

        $tieuChiHienTai = Tieuchidanhgia::find($tieuChi['tieuchi_id']);

        return view('noidungdanhgia.chitiettieuchi.edit', compact('tieuChis', 'ten', 'tieuChi', 'tieuChiHienTai'));
    }

    public function postEditDanhSachChiTietTieuChi(Request $request, $id)
    {
        if ($request->vipham == 1) {
            if ($request->sodiem >= -25 && $request->sodiem <= 0) {
                $tieuChi = Chitiettieuchi::find($id);
                $tieuChi->name = $request->name;
                $tieuChi->sodiem = $request->sodiem;
                $tieuChi->tieuchi_id = $request->tieuchi_id;
                $tieuChi->vipham = $request->vipham;
                $tieuChi->save();
            } else {
                $request->session()->flash('diemViPham', 'Mời bạn nhập điểm trong khoảng từ -25 đến 0');
                return redirect()->route('chitiettieuchi.get_edit_tieuchi', $id);
            }
        } else {
            $tieuChi = Chitiettieuchi::find($id);
            $tieuChi->name = $request->name;
            $tieuChi->sodiem = $request->sodiem;
            $tieuChi->tieuchi_id = $request->tieuchi_id;
            $tieuChi->vipham = $request->vipham;
            $tieuChi->save();
        }
        return redirect()->route('chitiettieuchi.get_danhsach');
    }

    public function getAddDanhSachChiTietTieuChi(Request $request)
    {
        $ten = $this->getTen();

        $tieuChis = Tieuchidanhgia::all();

        return view('noidungdanhgia.chitiettieuchi.add', compact('ten', 'tieuChis'));
    }

    public function postAddDanhSachChiTietTieuChi(Request $request)
    {
        if ($request->vipham == 1) {
            if ($request->sodiem >= -25 && $request->sodiem <= 0) {
                $tieuChi = new Chitiettieuchi();
                $tieuChi->name = $request->name;
                $tieuChi->sodiem = $request->sodiem;
                $tieuChi->tieuchi_id = $request->tieuchi_id;
                $tieuChi->vipham = $request->vipham;
                $tieuChi->save();
            } else {
                $request->session()->flash('diemViPham', 'Mời bạn nhập điểm trong khoảng từ -25 đến 0');
                return redirect()->route('chitiettieuchi.get_add');
            }
        } else {
            $tieuChi = new Chitiettieuchi();
            $tieuChi->name = $request->name;
            $tieuChi->sodiem = $request->sodiem;
            $tieuChi->tieuchi_id = $request->tieuchi_id;
            $tieuChi->vipham = $request->vipham;
            $tieuChi->save();
        }
        return redirect()->route('chitiettieuchi.get_danhsach');
    }

    public function deleteDanhSachChiTietTieuChi($id)
    {
        Chitiettieuchi::destroy($id);
        return redirect()->route('chitiettieuchi.get_danhsach');
    }


    // vi phạm
    public function getDanhSachVipham()
    {
        $ten = $this->getTen();
        $viPhams = Vipham::all();
        return view('noidungdanhgia.vipham.danhsach', compact('viPhams', 'ten'));
    }

    public function getEditDanhSachVipham($id)
    {
        $ten = $this->getTen();

        $viPham = Vipham::find($id);

        return view('noidungdanhgia.vipham.edit', compact('viPham', 'ten'));
    }

    public function postEditDanhSachVipham(Request $request, $id)
    {

        if ($request->sodiemtru >= -25 && $request->sodiemtru <= 0) {
            $viPham = Vipham::find($id);
            $viPham->name = $request->name;
            $viPham->sodiemtru = $request->sodiemtru;
            $viPham->save();
        } else {
            $request->session()->flash('diemViPham', 'Mời bạn nhập điểm trong khoảng từ -25 đến 0');
            return redirect()->route('vipham.get_edit_tieuchi', $id);
        }

        return redirect()->route('vipham.get_danhsach');
    }

    public function getAddDanhSachVipham()
    {
        $ten = $this->getTen();

        return view('noidungdanhgia.vipham.add', compact('ten'));
    }

    public function postAddDanhSachVipham(Request $request)
    {

        if ($request->sodiemtru >= -25 && $request->sodiemtru <= 0) {
            $viPham = new Vipham();
            $viPham->name = $request->name;
            $viPham->sodiemtru = $request->sodiemtru;
            $viPham->save();
        } else {
            $request->session()->flash('diemViPham', 'Mời bạn nhập điểm trong khoảng từ -25 đến 0');
            return redirect()->route('vipham.get_add');
        }
        return redirect()->route('vipham.get_danhsach');
    }

    public function deleteDanhSachVipham($id)
    {
        Vipham::destroy($id);
        return redirect()->route('vipham.get_danhsach');
    }

}

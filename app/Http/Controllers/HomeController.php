<?php

namespace App\Http\Controllers;

use App\Giangvien;
use Illuminate\Http\Request;
use App\Sinhvien;
use App\Http\Requests\SinhVienAddRequest;
use Illuminate\Support\Facades\Hash;
use App\Lop;
use App\User;
use App\Admins;
use App\Hocki;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $idSinhVien =  Auth::user()->id;

        $user = [];

        if (Auth::user()->vaitro == 4) {
            $user =  Sinhvien::where("user_id", $idSinhVien)->get();
        } else if (Auth::user()->vaitro == 5) {
            $user =  Sinhvien::where("user_id", $idSinhVien)->get();
        } else if (Auth::user()->vaitro == 3) {
            $user =  Giangvien::where("user_id", $idSinhVien)->get();
        } else if (Auth::user()->vaitro == 1) {
            $user =  Admins::where("user_id", $idSinhVien)->get();
        } else {
            $user =  Giangvien::where("user_id", $idSinhVien)->get();
        }

        $ten = $user[0]->name;

        return view('index', compact('ten'));
    }

    public function getAddHocKi()
    {
        $idSinhVien =  Auth::user()->id;
        $user =  Admins::where("user_id", $idSinhVien)->get();
        $ten = $user[0]->name;
        return view('hocki.add', compact('ten'));
    }

    public function postAddHocKi(Request $request)
    {
        $idSinhVien =  Auth::user()->id;
        $user =  Admins::where("user_id", $idSinhVien)->get();
        $ten = $user[0]->name;
        if ($request->active == 1) {
            if ($request->name >= 1 && $request->name <= 2) {
                $hocKis = Hocki::all();
                foreach ($hocKis as $item) {
                    $hocKi = Hocki::find($item['id']);
                    $hocKi->active = 0;
                    $hocKi->save();
                }
                $hocki = new Hocki();
                $hocki->name = $request->name;
                $hocki->nam = $request->nam;
                $hocki->active = $request->active;
                $hocki->save();
            } else {
                $request->session()->flash('hocki', 'Mời bạn nhập học kì 1 hoặc 2');
                return redirect()->route('hocki.get_add');
            }
        } else {
            if ($request->name >= 1 && $request->name <= 2) {
                $hocki = new Hocki();
                $hocki->name = $request->name;
                $hocki->nam = $request->nam;
                $hocki->active = $request->active;
                $hocki->save();
            } else {
                $request->session()->flash('hocki', 'Mời bạn nhập học kì 1 hoặc 2');
                return redirect()->route('hocki.get_add');
            }
        }
        return redirect()->route('hocki.get_danhsach');
    }

    public function getDanhSachHocKi()
    {
        $idSinhVien =  Auth::user()->id;
        $user =  Admins::where("user_id", $idSinhVien)->get();
        $ten = $user[0]->name;

        $hocKis = Hocki::all();

        return view('hocki.danhsach', compact('ten', 'hocKis'));
    }

    public function getActive($id)
    {
        $hocKis = Hocki::all();
        foreach ($hocKis as $item) {
            $hocKi = Hocki::find($item['id']);
            $hocKi->active = 0;
            $hocKi->save();
        }

        $hocKi = Hocki::find($id);
        $hocKi->active = 1;
        $hocKi->save();
        return redirect()->route('hocki.get_danhsach');
    }

    public function getEditHocKi($id)
    {
        $idSinhVien =  Auth::user()->id;
        $user =  Admins::where("user_id", $idSinhVien)->get();
        $ten = $user[0]->name;

        $hocKi = Hocki::find($id);
        return view('hocki.edit', compact('ten', 'hocKi'));
    }

    public function postEditHocKi(Request $request, $id)
    {
        $idSinhVien =  Auth::user()->id;
        $user =  Admins::where("user_id", $idSinhVien)->get();
        $ten = $user[0]->name;

        $hocKi = Hocki::find($id);
        $hocKi->name =  $request->name;
        $hocKi->nam =  $request->nam;
        $hocKi->save();

        return redirect()->route('hocki.get_danhsach');
    }

    public function getDeleteHocKi($id)
    {
        Hocki::destroy($id);
        return redirect()->route('hocki.get_danhsach');
    }

    public function getProfile()
    {
        $id = Auth::user()->id;
        if (Auth::user()->vaitro == 1) {
            $idSinhVien =  Auth::user()->id;
            $user =  Admins::where("user_id", $idSinhVien)->get();
            $ten = $user[0]->name;

            $user = Admins::where('user_id', $id)->first();
        } else if (Auth::user()->vaitro == 2 || Auth::user()->vaitro == 3) {
            $idSinhVien =  Auth::user()->id;
            $user =  Giangvien::where("user_id", $idSinhVien)->get();
            $ten = $user[0]->name;

            $user = Giangvien::where('user_id', $id)->first();
        } else {
            $idSinhVien =  Auth::user()->id;
            $user =  Sinhvien::where("user_id", $idSinhVien)->get();
            $ten = $user[0]->name;

            $user = Sinhvien::where('user_id', $id)->first();
        }
        return view('thongtincanhan.profile', compact('ten', 'user'));
    }

    public function postProfile(ProfileRequest $request)
    {
        $id = Auth::user()->id;
        if (Auth::user()->vaitro == 1) {
            $idAdmin = DB::table('admins')->where('user_id', $id)->first();

            $user = Admins::find($idAdmin->id);
            $user->name = $request->name;
            $user->ngaysinh = $request->ngaysinh;
            $user->email = $request->email;
            $user->gioitinh = $request->gioitinh;
            $user->sodienthoai = $request->sodienthoai;
            $user->diachi = $request->diachi;
            $user->avatar = $request->avatar;
            $user->save();

            $user = User::find($id);
            $user->password =Hash::make($request->password) ;
            $user->save();
        } else if (Auth::user()->vaitro == 2 || Auth::user()->vaitro == 3) {
            $idGiangVien = DB::table('giangviens')->where('user_id', $id)->first();

            $user = Giangvien::find($idGiangVien->id);
            $user->name = $request->name;
            $user->ngaysinh = $request->ngaysinh;
            $user->email = $request->email;
            $user->gioitinh = $request->gioitinh;
            $user->sodienthoai = $request->sodienthoai;
            $user->diachi = $request->diachi;
            $user->avatar = $request->avatar;
            $user->save();

            $user = User::find($id);
            $user->password =Hash::make($request->password) ;
            $user->save();
        } else {
            $idSinhVien = DB::table('sinhviens')->where('user_id', $id)->first();
   
            $user = Sinhvien::find($idSinhVien->id);
            $user->name = $request->name;
            $user->ngaysinh = $request->ngaysinh;
            $user->email = $request->email;
            $user->gioitinh = $request->gioitinh;
            $user->sodienthoai = $request->sodienthoai;
            $user->diachi = $request->diachi;
            $user->avatar = $request->avatar;
            $user->save();
            
            $user = User::find($id);
            $user->password =Hash::make($request->password) ;
            $user->save();
        }
        return redirect()->route('profile.get');
    }
}

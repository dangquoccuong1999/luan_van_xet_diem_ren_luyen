<?php

namespace App\Http\Controllers;

use App\Admins;
use App\User;
use Illuminate\Http\Request;
use App\Giangvien;
use App\Sinhvien;
use App\Lop;
use App\TieuChuan;
use App\Tieuchidanhgia;
use App\Chitiettieuchi;
use App\Chunhiem;
use App\Diem_danh_gia_sinh_vien;
use App\Http\Requests\ChamDiemRequest;
use App\Khoa;
use App\Vipham;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\DB;

class GiangvienController extends Controller
{
    public function getDanhSach()
    {
        $giangviens = Giangvien::paginate(10);

        $sinhvien =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $sinhvien)->get();

        $tenSv =  Admins::where("user_id", $idSinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        return view('giangvien.danhsach', compact('giangviens', 'ten'));
    }

    public function getAdd()
    {
        $sinhvien =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $sinhvien)->get();

        $tenSv =  Admins::where("user_id", $idSinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        $khoas = Khoa::all();

        return view('giangvien.add', compact('ten', 'khoas'));
    }

    public function postAdd(Request $request)
    {
        // $maUser = DB::table('users')->orderBy('id','DESC')->limit(1);
        // $user = new User();
        // $user->maso = $request->maso;
        // $user->vaitro = $request->vaitro;
        // $user->password = Hash::make('123456');
        // $user->remember_token = $request->_token;
        // $user->save();

        // $idUser = DB::select("SELECT id FROM users ORDER BY ID DESC LIMIT 1");

        // $giangvien = new Giangvien();
        // $giangvien->user_id = $idUser[0]->id;
        // $giangvien->name = $request->name;
        // $giangvien->email = $request->email;
        // $giangvien->gioitinh = $request->gioitinh;
        // $giangvien->ngaysinh = $request->ngaysinh;
        // $giangvien->sodienthoai = $request->sodienthoai;
        // if ($request->vaitro == 3) {
        //     $giangvien->chucvu = "Chủ nhiệm";
        // } else {
        //     $giangvien->chucvu = "Ban chủ nhiệm khoa";
        // }
        // $giangvien->save();

        $idGiangVienCuoiCung = DB::select("SELECT id FROM giangviens ORDER BY ID DESC LIMIT 1");
        $idGiangVien = $idGiangVienCuoiCung[0]->id;

        $checkGiangVien = Giangvien::find($idGiangVien);
        dd($checkGiangVien);
        // if()
        return redirect()->route('giangvien.get_danhsach');
    }

    public function add_ajax(Request $request)
    {
        $data = DB::select("SELECT * FROM `lops` WHERE khoa_id = $request->id");

        return response()->json($data);
    }

    public function getEdit($id)
    {
        $maso =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $maso)->get();

        $tenSv =  Admins::where("user_id", $idSinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        //cap nhat
        $giangVien = Giangvien::find($id);
        $maUser = User::find($giangVien['user_id']);

        if ($giangVien['chucvu'] == "Chủ nhiệm") {
            $chuNhiem = DB::select("SELECT * FROM `chunhiems` WHERE giangvien_id = $id ");
            $lops = Lop::all();

            foreach ($lops as $lop) {
                $lop['checkCN'] = false;
                foreach ($chuNhiem as $chunhiem) {
                    if ($lop['id'] == $chunhiem->lop_id) {
                        $lop['checkCN'] = true;
                    }
                }
            }
        } else {
            $lops = "";
        }
        return view('giangvien.edit', compact('ten', 'lops', 'giangVien', 'maUser'));
    }


    public function postEdit(Request $request, $id)
    {
        //check user xem đã tồn tại chưa
        // $giangVien = Giangvien::find($id);
        // $id_user =  $giangVien['user_id'];

        // $user = User::find($id_user);
        // $user->vaitro = $request->vaitro;
        // $user->save();

        // $giangVien->name = $request->name;
        // $giangVien->email = $request->email;
        // $giangVien->gioitinh = $request->gioitinh;
        // $giangVien->ngaysinh = $request->ngaysinh;
        // $giangVien->sodienthoai = $request->sodienthoai;
        // if ($request->chucvu == 2) {
        //     $giangVien->chucvu = 'Ban chủ nhiệm khoa';
        // }else if($request->chucvu == 3){
        //     $giangVien->chucvu = 'Chủ nhiệm';
        // }
        // $giangVien->save();

        $chuNhiem = DB::select("SELECT * FROM `chunhiems` WHERE giangvien_id = $id");

        // $chuNhiemNew = new Chunhiem();
        // $chuNhiemNew->giangvien_id = $id;
        // $chuNhiemNew->lop_id = $id_lop_request;
        // $chuNhiemNew->save();

        dd($chuNhiem);
        if (!empty($request->id_lop_ChuNhiem)) {
            if (!empty($chuNhiem)) {
                foreach ($chuNhiem as $chunhiem) {
                    echo $chunhiem->lop_id;
                }
            }
        } else {
            // DB::select("DELETE FROM chunhiems WHERE giangvien_id = $id");
        }
    }


    public function delete($id)
    {
    }

    public function getDanhSachDanhGiaDiemLop($id_lop)
    {

        $idSV =  Auth::user()->maso;
        $giangVien = User::where("maso", $idSV)->get();

        $user =  Giangvien::where("user_id", $giangVien[0]['id'])->get();
        $ten = $user[0]['name'];
        $lop =  DB::table('lops')->where('id', $id_lop)->first();

        $sinhviens =  DB::table('sinhviens')->join('lops', 'sinhviens.lop_id', '=', 'lops.id')->join('users', 'sinhviens.user_id', '=', 'users.id')
            ->select('lops.*', 'sinhviens.*', 'users.maso', 'users.id')->where('sinhviens.lop_id', $id_lop)->paginate(10);
        $maSV =  Auth::user()->maso;

        $idSinhVien = User::where("maso", $maSV)->get();


        $sinhVienDaChamDiemRenLuyen = DB::select("SELECT DISTINCT user_sinhvien FROM diem_danh_gia_sinh_vien");
        $cbl_DaChamDiemRenLuyenSV = DB::select("SELECT DISTINCT user_sinhvien FROM diem_danh_gia_cbl");

        foreach ($sinhviens as $sv) {
            $sv->checkSV = false; // nếu chưa có sv nào chấm điểm thì thêm mặc định check = false
            $sv->checkCBL = false;
        }

        foreach ($sinhVienDaChamDiemRenLuyen as $idSV) {
            foreach ($sinhviens as $sv) {
                if ($sv->user_id ==  $idSV->user_sinhvien) {
                    $sv->checkSV = true; // nếu sinh viên đã chấm điểm thì thêm check = true
                } else {
                    $sv->checkSV = false;
                }
            }
        };

        foreach ($cbl_DaChamDiemRenLuyenSV as $idSV) {
            foreach ($sinhviens as $sv) {
                if ($sv->user_id ==  $idSV->user_sinhvien) {
                    $sv->checkCBL = true; // nếu giảng viên đã chấm điểm cho sv đó thì thêm check = true
                } else {
                    $sv->checkCBL = false;
                }
            }
        };

        return view('sinhvien.list', compact('lop', 'sinhviens', 'ten'));
    }

    public function getChamDiemSV($id_SV)
    {

        $idSV =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $idSV)->get();

        $user =  Giangvien::where("user_id", $idSinhVien[0]['id'])->get();

        $ten = $user[0]['name'];

        $tieuChuan = TieuChuan::all();

        $tieuChiDanhGia = Tieuchidanhgia::all();

        $chiTietTieuChi = Chitiettieuchi::all();

        $viPham = Vipham::all();

        $hocki = DB::select("SELECT * FROM `hocki` WHERE active = 1");

        $this->hockiID = $hocki[0]->id;

        $idGV = Auth::user()->id;

        $diemSV = DB::select("SELECT diem_danh_gia_sinh_vien.diem FROM `diem_danh_gia_sinh_vien` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID");

        $id_CBL = DB::select("SELECT diem_danh_gia_cbl.user_canbolop FROM `diem_danh_gia_cbl` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID LIMIT 1");
        $idCBL = $id_CBL[0]->user_canbolop;
        $diemCBL = DB::select("SELECT diem_danh_gia_cbl.diem FROM `diem_danh_gia_cbl` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID and user_canbolop = $idCBL");

        $diemGV = DB::select("SELECT diem_danh_gias.diem FROM `diem_danh_gias` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID and user_giangvien = $idGV");

        if (empty($diemCBL)) {
            $tongDiemCBL = '';
        } else {
            $tongDiemCBL = 0;
        }

        if (empty($diemGV)) {
            $tongDiemGV = '';
        } else {
            $tongDiemGV = 0;
        }

        foreach ($diemGV as $diem) {
            $tongDiemGV += $diem->diem; // tính tổng điểm
        }

        foreach ($diemCBL as $diem) {
            $tongDiemCBL += $diem->diem; // tính tổng điểm
        }

        $tongDiemSV = 0;
        foreach ($diemSV as $diem) {
            $tongDiemSV += $diem->diem; // tính tổng điểm
        }

        $xepLoaiSV = '';
        if ($tongDiemSV < 35) {
            $xepLoaiSV = "Kém";
        } else if ($tongDiemSV >= 35 && $tongDiemSV <= 50) {
            $xepLoaiSV = "Yếu";
        } else if ($tongDiemSV >= 50 && $tongDiemSV <= 65) {
            $xepLoaiSV = "Trung bình";
        } else if ($tongDiemSV >= 65 && $tongDiemSV <= 80) {
            $xepLoaiSV = "Khá";
        } else if ($tongDiemSV >= 80 && $tongDiemSV <= 90) {
            $xepLoaiSV = "Tốt";
        } else {
            $xepLoaiSV = "Xuất sắc";
        }

        $xepLoaiCBL = '';
        if ($tongDiemCBL != "") {
            if ($tongDiemCBL < 35) {
                $xepLoaiCBL = "Kém";
            } else if ($tongDiemCBL >= 35 && $tongDiemCBL <= 50) {
                $xepLoaiCBL = "Yếu";
            } else if ($tongDiemCBL >= 50 && $tongDiemCBL <= 65) {
                $xepLoaiCBL = "Trung bình";
            } else if ($tongDiemCBL >= 65 && $tongDiemCBL <= 80) {
                $xepLoaiCBL = "Khá";
            } else if ($tongDiemCBL >= 80 && $tongDiemCBL <= 90) {
                $xepLoaiCBL = "Tốt";
            } else {
                $xepLoaiCBL = "Xuất sắc";
            }
        }

        $xepLoaiGV = '';
        if ($tongDiemGV != "") {
            if ($tongDiemGV < 35) {
                $xepLoaiGV = "Kém";
            } else if ($tongDiemGV >= 35 && $tongDiemGV <= 50) {
                $xepLoaiGV = "Yếu";
            } else if ($tongDiemGV >= 50 && $tongDiemGV <= 65) {
                $xepLoaiGV = "Trung bình";
            } else if ($tongDiemGV >= 65 && $tongDiemGV <= 80) {
                $xepLoaiGV = "Khá";
            } else if ($tongDiemGV >= 80 && $tongDiemGV <= 90) {
                $xepLoaiGV = "Tốt";
            } else {
                $xepLoaiGV = "Xuất sắc";
            }
        }
        return view('sinhvien.chamdiem', compact('ten', 'tieuChuan', 'tieuChiDanhGia', 'chiTietTieuChi', 'viPham', 'diemSV', 'diemCBL', 'diemGV', 'id_SV', 'tongDiemCBL', 'tongDiemSV', 'xepLoaiCBL', 'xepLoaiSV', 'tongDiemGV', 'xepLoaiGV'));
    }

    public function postChamDiemSV(ChamDiemRequest $request, $id_userSV)
    {
        $arrDiemSV = [];
        $arrChiTietTieuChiID = [];

        $hocki_ID = 0; // lưu kiểu number
        foreach ($request->all() as $key => $diemSV) {
            if ($key != "luu") {
                if ($diemSV != null) {
                    if (is_numeric($diemSV)) {

                        if (is_numeric(strpos($key, 'diemvipham'))) {
                            array_push($arrDiemSV, $diemSV);

                            $bienTamLayID = strstr($key, '-');

                            array_push($arrChiTietTieuChiID, substr($bienTamLayID,  1, strlen($bienTamLayID)));
                        } else {
                            array_push($arrDiemSV, $diemSV);

                            $bienTamLayID = strstr($key, '-');

                            array_push($arrChiTietTieuChiID, substr($bienTamLayID,  1, strlen($bienTamLayID)));
                        }
                    }
                }
            }
        }

        $hocki = DB::select("SELECT * FROM `hocki` WHERE active = 1");

        $this->hockiID = $hocki[0]->id;

        $idGV = Auth::user()->id;

        $this->checkXemUserDaChamDiemChua  = DB::select("SELECT * FROM `diem_danh_gias` WHERE hocki_id = $this->hockiID AND user_sinhvien =  $id_userSV and user_giangvien = $idGV");
        
        $this->checkXemBcnKhoaChamChua  = DB::select("SELECT * FROM `diem_danh_gia_banchunhiemkhoa` WHERE hocki_id = $this->hockiID AND user_sinhvien =  $id_userSV");
        
        
        if (empty($this->checkXemUserDaChamDiemChua)) { // true tức là GV chưa chấm điểm cho sv đó
            $i = 0;
            foreach ($arrDiemSV as $diem) {
                DB::insert("insert into diem_danh_gias (diem,hocki_id,chitiettieuchi_id,user_sinhvien,user_giangvien) values (?, ?,?,?,?)", [$diem, $this->hockiID, $arrChiTietTieuChiID[$i], $id_userSV, $idGV]);  
                
                if(empty($this->checkXemBcnKhoaChamChua)){
                    DB::insert("insert into diem_danh_gia_banchunhiemkhoa (hocki_id,user_sinhvien) values (?,?)", [$this->hockiID, $id_userSV]);
                    $this->checkXemBcnKhoaChamChua  = DB::select("SELECT * FROM `diem_danh_gia_banchunhiemkhoa` WHERE hocki_id = $this->hockiID AND user_sinhvien =  $id_userSV");
                }

                $i++;
            }
            return redirect()->route('giangvien.get_chamdiemsinhvien', ['id' => $id_userSV]);
        } else { // nếu có dữ liệu rồi thì cập nhật điểm
            $i = 0;
            foreach ($arrChiTietTieuChiID as $id) {
                DB::select("UPDATE diem_danh_gias set diem = '$arrDiemSV[$i]' where hocki_id = '$this->hockiID' and chitiettieuchi_id = '$id' and user_sinhvien = '$id_userSV' and user_giangvien = $idGV");
                $i++;
            }
            return redirect()->route('giangvien.post_chamdiemsinhvien', ['id' => $id_userSV]);
        }
    }

    // ban chủ nhiệm khoa

    public function getTongHopKetQua($id)
    {
        $sinhvien =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $sinhvien)->get();

        $tenSv =  Giangvien::where("user_id", $idSinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        $hocki = DB::select("SELECT * FROM `hocki` WHERE active = 1");
        $hockiID = $hocki[0]->id;

        $sinhViens = Sinhvien::where('lop_id', $id)->get();



        foreach ($sinhViens as $sv) {
            $id =  $sv['user_id'];
            $diemDB = DB::select("SELECT SUM(diem) as 'diem' FROM diem_danh_gias WHERE user_sinhvien = $id and hocki_id = $hockiID ");
            $diem = $diemDB[0]->diem;
            $sv['diem'] = $diem;
            $xepLoai = "";
            $this->checkXemUserDaChamDiemChua  = DB::select("SELECT * FROM `diem_danh_gia_banchunhiemkhoa` WHERE hocki_id = $hockiID AND user_sinhvien =  $sv->user_id");
            if(!empty($this->checkXemUserDaChamDiemChua)){
                $sv['ykienbcnkhoa'] = $this->checkXemUserDaChamDiemChua[0]->y_kien_bcn;  
            }

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
            $sv['xeploai'] = $xepLoai;
        }
        return view('giangvien.tonghop', compact('ten', 'sinhViens'));
    }

    public function bnc_xetduyetdiem(Request $request, $id)
    {
        $hocki = DB::select("SELECT * FROM `hocki` WHERE active = 1");
        $hockiID = $hocki[0]->id;

        $sinhViens = Sinhvien::where('lop_id', $id)->get();

        foreach ($request->all() as $key => $item) {
            if (is_numeric($item)) {
                foreach ($sinhViens as $sv) {
                    if ($key == $sv->user_id) {
                        $this->checkXemUserDaChamDiemChua  = DB::select("SELECT * FROM `diem_danh_gia_banchunhiemkhoa` WHERE hocki_id = $hockiID AND user_sinhvien =  $key");
                        if (!empty($this->checkXemUserDaChamDiemChua)) { // cap nhat y kien bcn khoa
                            DB::select("UPDATE diem_danh_gia_banchunhiemkhoa set y_kien_bcn = $item  where hocki_id = $hockiID and user_sinhvien =  $key ");
                        }
                    }
                }
            }
        }
        return redirect()->route('khoa.get_tonghop', $id);
    }
}

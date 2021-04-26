<?php

namespace App\Http\Controllers;

use App\Admins;
use App\Sinhvien;
use Illuminate\Http\Request;
use App\Http\Requests\SinhVienAddRequest;
use  Illuminate\Support\Facades\Hash;
use App\Lop;
use App\User;
use App\TieuChuan;
use App\Tieuchidanhgia;
use App\Chitiettieuchi;
use App\Diem_danh_gia_sinh_vien;
use App\Exports\ExportSinhVien;
use App\Giangvien;
use App\Http\Requests\ChamDiemRequest;
use App\Vipham;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Dompdf\Adapter\PDFLib;
use Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\DB;
use PDF;
use App\Exports\ExportUsers;
use App\Exports\KetQuaRenLuyenSinhVienExport;
use App\Hocki;
use App\Imports\ImportUsers;
use Maatwebsite\Excel\Facades\Excel;

class SinhvienController extends Controller
{
    protected $hockiID, $checkXemUserDaChamDiemChua;

    public function __construct()
    {
        
    }

    public function getAdd($id) 
    {
        $lops = Lop::all();
        return view('sinhvien.add', compact('lops'));
    }

    public function getDanhSach($id_lop)
    {

        $sinhvien =  Auth::user()->maso;
        $idSinhVien = User::where("maso", $sinhvien)->get();


        $tenGV =  Giangvien::where("user_id", $idSinhVien[0]['id'])->get();
        $tenADMIN =  Admins::where("user_id", $idSinhVien[0]['id'])->get();

        $vaiTro = Auth::user()->vaitro;
        if ($vaiTro == 1) {
            $ten = $tenADMIN[0]['name'];
        }
        if ($vaiTro == 3) {
            $ten = $tenGV[0]['name'];
        }


        $lop =  DB::table('lops')->where('id', $id_lop)->first();

        $sinhviens =  DB::table('sinhviens')->join('lops', 'sinhviens.lop_id', '=', 'lops.id')->join('users', 'sinhviens.user_id', '=', 'users.id')
            ->select('lops.*', 'sinhviens.*', 'users.maso', 'users.id')->where('sinhviens.lop_id', $id_lop)->paginate(10);
        $maSV =  Auth::user()->maso;

        $idSinhVien = User::where("maso", $maSV)->get();


        $sinhVienDaChamDiemRenLuyen = DB::select("SELECT DISTINCT user_sinhvien FROM diem_danh_gia_sinh_vien");
        $cbl_DaChamDiemRenLuyenSV = DB::select("SELECT DISTINCT user_sinhvien FROM diem_danh_gia_cbl where active = 1");
        $cv_DaChamDiemRenLuyenSV = DB::select("SELECT DISTINCT user_sinhvien FROM diem_danh_gias");

        foreach ($sinhviens as $sv) {
            $sv->checkSV = false; // nếu chưa có sv nào chấm điểm thì thêm mặc định check = false
            $sv->checkCBL = false;
            $sv->checkCV = false;
        }

        foreach ($sinhVienDaChamDiemRenLuyen as $idSV) {
            foreach ($sinhviens as $sv) {
                if ($sv->user_id ==  $idSV->user_sinhvien) {
                    $sv->checkSV = true; // nếu sinh viên đã chấm điểm thì thêm check = true
                }
                if (Auth::user()->vaitro == 5) {
                    $sv->checkSV = true;
                }
            }
        };

        foreach ($cbl_DaChamDiemRenLuyenSV as $idSV) {
            foreach ($sinhviens as $sv) {
                if ($sv->user_id ==  $idSV->user_sinhvien) {
                    $sv->checkCBL = true; // nếu cán bộ lớp đã chấm điểm cho sv đó thì thêm check = true
                }
            }
        };

        foreach ($cv_DaChamDiemRenLuyenSV as $idSV) {
            foreach ($sinhviens as $sv) {
                if ($sv->user_id ==  $idSV->user_sinhvien) {
                    $sv->checkCV = true; // nếu giảng viên đã chấm điểm cho sv đó thì thêm check = true
                }
            }
        };
        // dd($sinhviens);
        return view('sinhvien.list', compact('lop', 'sinhviens', 'ten'));
    }


    public function getxemdiem($id_SV, Request $request)
    {
        //kihoc sẽ nhận giá trị là id của kì học đó
        $idSV =  Auth::user()->id;
        $vaitro = Auth::user()->vaitro;

        if ($vaitro == 1) {
            $user =  Admins::where("user_id", $idSV)->get();
        } elseif ($vaitro == 3 || $vaitro == 2) {
            $user =  Giangvien::where("user_id", $idSV)->get();
        } elseif ($vaitro == 5 || $vaitro == 4) {
            $user =  Sinhvien::where("user_id", $idSV)->get();
        }
        $ten = $user[0]['name'];

        $tieuChuan = TieuChuan::all();

        $tieuChiDanhGia = Tieuchidanhgia::all();

        $chiTietTieuChi = Chitiettieuchi::all();

        $viPham = Vipham::all();
        $kihoc = $request->kihoc;

        if (!empty($kihoc)) {
            $hocki = DB::select("SELECT * FROM `hocki` WHERE id =  $kihoc");
        } else {
            $hocki = DB::select("SELECT * FROM `hocki` WHERE active =  1");
        }

        $hocKiAll = Hocki::all();
        $this->hockiID = $hocki[0]->id;

        $id_GV = DB::select("SELECT user_giangvien FROM `diem_danh_gias` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID limit 1");

        if (!empty($id_GV)) {
            $idGV = $id_GV[0]->user_giangvien;
        } else {
            $idGV = 0;
        }

        $diemSV = DB::select("SELECT diem_danh_gia_sinh_vien.diem FROM `diem_danh_gia_sinh_vien` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID");

        $id_CBL = DB::select("SELECT diem_danh_gia_cbl.user_canbolop FROM `diem_danh_gia_cbl` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID LIMIT 1");

        if (!empty($id_CBL)) {
            $idCBL = $id_CBL[0]->user_canbolop;
        } else {
            $idCBL = 0;
        }


        $diemCBL = DB::select("SELECT diem_danh_gia_cbl.diem FROM `diem_danh_gia_cbl` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID and user_canbolop = $idCBL");
        $diemGV = DB::select("SELECT diem_danh_gias.diem FROM `diem_danh_gias` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID and user_giangvien = $idGV");

        $yKienBCN = DB::select("SELECT * FROM `diem_danh_gia_banchunhiemkhoa` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID ");

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

        if (empty($diemSV)) {
            $tongDiemSV = '';
        } else {
            $tongDiemSV = 0;
        }

        foreach ($diemGV as $diem) {
            $tongDiemGV += $diem->diem; // tính tổng điểm
        }

        foreach ($diemCBL as $diem) {
            $tongDiemCBL += $diem->diem; // tính tổng điểm
        }


        foreach ($diemSV as $diem) {
            $tongDiemSV += $diem->diem; // tính tổng điểm
        }

        $xepLoaiSV = '';
        if ($tongDiemSV != '') {
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
        return view('sinhvien.xemdiem', compact('ten', 'tieuChuan', 'tieuChiDanhGia', 'chiTietTieuChi', 'viPham', 'diemSV', 'diemCBL', 'diemGV', 'id_SV', 'tongDiemCBL', 'tongDiemSV', 'xepLoaiCBL', 'xepLoaiSV', 'tongDiemGV', 'xepLoaiGV', 'hocKiAll', 'kihoc', 'yKienBCN'));
    }

    public function postAdd(SinhVienAddRequest $request, $id_lop)
    {

        $user = new User();
        $user->name = $request->tensv;
        $user->email = $request->email;
        $user->password = Hash::make($request->email);
        $user->vaitro = 4;
        $user->remember_token = $request->_token;
        //        vai tro 4 la sinh vien
        $user->save();


        $sinhvien = new Sinhvien();
        $sinhvien->name = $request->tensv;
        $sinhvien->masv = $request->masv;
        $sinhvien->ngaysinh = $request->ngaysinh;
        $sinhvien->gioitinh = $request->gioitinh;
        $sinhvien->lop_id = $id_lop;

        $sinhvien->email = $request->email;

        $sinhvien->save();


        return redirect()->route('sinhvien.get_danhsach', $id_lop);
    }

    public function getTuChamdiem($id_SV)
    {
        $idSV =  Auth::user()->id;
        $vaitro = Auth::user()->vaitro;

        if ($vaitro == 1) {
            $user =  Admins::where("user_id", $idSV)->get();
        } elseif ($vaitro == 3 || $vaitro == 2) {
            $user =  Giangvien::where("user_id", $idSV)->get();
        } elseif ($vaitro == 5 || $vaitro == 4) {
            $user =  Sinhvien::where("user_id", $idSV)->get();
        }

        $ten = $user[0]['name'];

        $tieuChuan = TieuChuan::all();

        $tieuChiDanhGia = Tieuchidanhgia::all();

        $chiTietTieuChi = Chitiettieuchi::all();

        $viPham = Vipham::all();

        $hocki = DB::select("SELECT * FROM `hocki` WHERE active = 1");

        $this->hockiID = $hocki[0]->id;

        $id_GV = DB::select("SELECT user_giangvien FROM `diem_danh_gias` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID limit 1");

        if (!empty($id_GV)) {
            $idGV = $id_GV[0]->user_giangvien;
        } else {
            $idGV = 0;
        }

        $diemSV = DB::select("SELECT diem_danh_gia_sinh_vien.diem FROM `diem_danh_gia_sinh_vien` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID");

        $id_CBL = DB::select("SELECT diem_danh_gia_cbl.user_canbolop FROM `diem_danh_gia_cbl` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID LIMIT 1");

        if (!empty($id_CBL)) {
            $idCBL = $id_CBL[0]->user_canbolop;
        } else {
            $idCBL = 0;
        }

        $id_user = $idSV;

        $diemCBL = DB::select("SELECT diem_danh_gia_cbl.diem FROM `diem_danh_gia_cbl` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID and user_canbolop = $idCBL");
        $diemGV = DB::select("SELECT diem_danh_gias.diem FROM `diem_danh_gias` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID and user_giangvien = $idGV");

        $active = DB::select("SELECT DISTINCT active FROM `diem_danh_gia_sinh_vien` WHERE user_sinhvien = $id_SV and hocki_id = $this->hockiID");

        if (!empty($active)) {
            if ($active[0]->active == 1) {
                return redirect()->route('sinhvien.getxemdiem', ['id' => $id_SV]);
            }
        }

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

        if (empty($diemSV)) {
            $tongDiemSV = '';
        } else {
            $tongDiemSV = 0;
        }

        foreach ($diemGV as $diem) {
            $tongDiemGV += $diem->diem; // tính tổng điểm
        }

        foreach ($diemCBL as $diem) {
            $tongDiemCBL += $diem->diem; // tính tổng điểm
        }


        foreach ($diemSV as $diem) {
            $tongDiemSV += $diem->diem; // tính tổng điểm
        }

        $xepLoaiSV = '';
        if ($tongDiemSV != '') {
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
        return view('sinhvien.chamdiem', compact('ten', 'tieuChuan', 'tieuChiDanhGia', 'chiTietTieuChi', 'viPham', 'diemSV', 'tongDiemCBL', 'tongDiemSV', 'xepLoaiSV', 'xepLoaiCBL', 'xepLoaiGV', 'tongDiemGV'));
    }

    public function postTuChamDiem(ChamDiemRequest $request, $userID)
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

        $this->checkXemUserDaChamDiemChua  = DB::select("SELECT diem_danh_gia_sinh_vien.hocki_id,diem_danh_gia_sinh_vien.user_sinhvien FROM `diem_danh_gia_sinh_vien` WHERE hocki_id = $this->hockiID AND user_sinhvien =  $userID");
        if (empty($this->checkXemUserDaChamDiemChua)) { // true tức là sv chưa có điểm gì cả 
            $i = 0;
            if ($request->luu == 1) {
                foreach ($arrDiemSV as $diem) {
                    DB::insert("insert into diem_danh_gia_sinh_vien (diem,hocki_id,chitiettieuchi_id,user_sinhvien,active) values (?, ?,?,?,?)", [$diem, $this->hockiID, $arrChiTietTieuChiID[$i], $userID, 1]);
                    $i++;
                }
            } else {
                foreach ($arrDiemSV as $diem) {
                    DB::insert("insert into diem_danh_gia_sinh_vien (diem,hocki_id,chitiettieuchi_id,user_sinhvien) values (?, ?,?,?)", [$diem, $this->hockiID, $arrChiTietTieuChiID[$i], $userID]);
                    $i++;
                }
            }
            return redirect()->route('sinhvien.get_tuchamdiem', ['id' => $userID]);
        } else { // nếu có dữ liệu rồi thì cập nhật điểm
            $i = 0;
            if ($request->luu == 1) {
                foreach ($arrChiTietTieuChiID as $id) {
                    DB::select("UPDATE diem_danh_gia_sinh_vien set diem = '$arrDiemSV[$i]', active = 1 where hocki_id = '$this->hockiID' and chitiettieuchi_id = '$id' and user_sinhvien = '$userID'");
                    $i++;
                }
            } else {
                foreach ($arrChiTietTieuChiID as $id) {
                    DB::select("UPDATE diem_danh_gia_sinh_vien set diem = '$arrDiemSV[$i]' where hocki_id = '$this->hockiID' and chitiettieuchi_id = '$id' and user_sinhvien = '$userID'");
                    $i++;
                }
            }
            return redirect()->route('sinhvien.get_tuchamdiem', ['id' => $userID]);
        }
    }



    // lớp trưởng
    public function getDanhSachLopTruongChamdiem($id_lop)
    {
        $idSV =  Auth::user()->maso;
        $sinhVien = User::where("maso", $idSV)->get();

        $tenSv =  Sinhvien::where("user_id", $sinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        $lop =  DB::table('lops')->where('id', $id_lop)->first();

        $sinhviens = DB::table('sinhviens')->join('lops', 'sinhviens.lop_id', '=', 'lops.id')->join('users', 'sinhviens.user_id', '=', 'users.id')
            ->select('lops.*', 'sinhviens.*', 'users.maso', 'users.id')->where('sinhviens.lop_id', $id_lop)->paginate(10);

        $sinhVienDaChamDiemRenLuyen = DB::select("SELECT DISTINCT user_sinhvien FROM diem_danh_gia_sinh_vien where active = 1");

        $cbl_DaChamDiemRenLuyenSV = DB::select("SELECT DISTINCT user_sinhvien FROM diem_danh_gia_cbl where active = 1");

        foreach ($sinhviens as $sv) {
            $sv->checkSV = false; // nếu chưa có sv nào chấm điểm thì thêm mặc định check = false
            $sv->checkCBL = false;
        }

        foreach ($sinhVienDaChamDiemRenLuyen as $idSV) {
            foreach ($sinhviens as $sv) {
                if ($sv->user_id ==  $idSV->user_sinhvien) {
                    $sv->checkSV = true; // nếu sinh viên đã chấm điểm thì thêm check = true
                }
                if (Auth::user()->vaitro == 5 &&  $sv->user_id ==  $idSV->user_sinhvien) {
                    $sv->checkSV = true;
                }
            }
        };
        foreach ($cbl_DaChamDiemRenLuyenSV as $idSV) {
            foreach ($sinhviens as $sv) {
                if ($sv->user_id ==  $idSV->user_sinhvien) {
                    $sv->checkCBL = true; // nếu cán bộ lớp đã chấm điểm cho sv đó thì thêm check = true
                }
            }
        }


        return view('sinhvien.list', compact('lop', 'sinhviens', 'ten'));
    }

    public function getLopTruongTuChamdiem($id_SV)
    {
        $idSV =  Auth::user()->maso;
        $sinhVien = User::where("maso", $idSV)->get();

        $tenSv =  Sinhvien::where("user_id", $sinhVien[0]['id'])->get();
        $ten = $tenSv[0]['name'];

        $tieuChuan = TieuChuan::all();

        $tieuChiDanhGia = Tieuchidanhgia::all();

        $chiTietTieuChi = Chitiettieuchi::all();

        $viPham = Vipham::all();

        $id_user =  Auth::user()->id;

        $hocki = DB::select("SELECT * FROM `hocki` WHERE active = 1");

        $this->hockiID = $hocki[0]->id;

        $diemSV = DB::select("SELECT diem_danh_gia_sinh_vien.diem FROM `diem_danh_gia_sinh_vien` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID");

        $idCBL = Auth::user()->id;



        $diemCBL = DB::select("SELECT diem_danh_gia_cbl.diem FROM `diem_danh_gia_cbl` where user_sinhvien = $id_SV  AND hocki_id =  $this->hockiID and user_canbolop = $idCBL");

        $active = DB::select("SELECT DISTINCT active FROM `diem_danh_gia_cbl` WHERE user_canbolop =  $id_user and user_sinhvien = $id_SV and hocki_id = $this->hockiID");

        if (!empty($active)) {
            if ($active[0]->active == 1) {
                return redirect()->route('sinhvien.getxemdiem', ['id' => $id_SV]);
            }
        }

        if (empty($diemCBL)) {
            $tongDiemCBL = '';
        } else {
            $tongDiemCBL = 0;
        }

        foreach ($diemCBL as $diem) {
            $tongDiemCBL += $diem->diem; // tính tổng điểm CBL
        }

        if (empty($diemSV)) {
            $tongDiemSV = '';
        } else {
            $tongDiemSV = 0;
        }

        foreach ($diemSV as $diem) {
            $tongDiemSV += $diem->diem; // tính tổng điểm SV
        }

        $xepLoaiSV = '';
        if ($tongDiemSV != "") {
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

        return view('sinhvien.chamdiem', compact('ten', 'tieuChuan', 'tieuChiDanhGia', 'chiTietTieuChi', 'viPham', 'diemSV', 'diemCBL', 'id_SV', 'tongDiemCBL', 'tongDiemSV', 'xepLoaiCBL', 'xepLoaiSV', 'active'));
    }


    public function postLopTruongTuChamDiem(ChamDiemRequest $request, $userSV)
    {
        $arrDiemSV = [];
        $arrChiTietTieuChiID = [];

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

        $idCBL = Auth::user()->id;

        $this->checkXemUserDaChamDiemChua  = DB::select("SELECT * FROM `diem_danh_gia_cbl` WHERE hocki_id = $this->hockiID AND user_sinhvien =  $userSV and user_canbolop = $idCBL");
        $this->checkXemUserLopTruongDaChamDiemChua  = DB::select("SELECT diem_danh_gia_sinh_vien.hocki_id,diem_danh_gia_sinh_vien.user_sinhvien FROM `diem_danh_gia_sinh_vien` WHERE hocki_id = $this->hockiID AND user_sinhvien =  $idCBL");
        // cái này để lưu khi lớp trưởng chưa chấm điểm cho bản thân mình

        if ($userSV ==  $idCBL) {
            if (empty($this->checkXemUserLopTruongDaChamDiemChua)) {
                $i = 0;
                if ($request->luu == 1) {
                    foreach ($arrDiemSV as $diem) {
                        DB::insert("insert into diem_danh_gia_sinh_vien (diem,hocki_id,chitiettieuchi_id,user_sinhvien,active) values (?, ?,?,?,?)", [$diem, $this->hockiID, $arrChiTietTieuChiID[$i], $idCBL, 1]);
                        $i++;
                    }
                } else {
                    foreach ($arrDiemSV as $diem) {
                        DB::insert("insert into diem_danh_gia_sinh_vien (diem,hocki_id,chitiettieuchi_id,user_sinhvien) values (?, ?,?,?)", [$diem, $this->hockiID, $arrChiTietTieuChiID[$i], $idCBL]);
                        $i++;
                    }
                }
            } else { // nếu có dữ liệu rồi thì cập nhật điểm
                $i = 0;
                if ($request->luu == 1) {
                    foreach ($arrChiTietTieuChiID as $id) {
                        DB::select("UPDATE diem_danh_gia_sinh_vien set diem = '$arrDiemSV[$i]',active = 1 where hocki_id = '$this->hockiID' and chitiettieuchi_id = '$id' and user_sinhvien = '$idCBL'");
                        $i++;
                    }
                } else {
                    foreach ($arrChiTietTieuChiID as $id) {
                        DB::select("UPDATE diem_danh_gia_sinh_vien set diem = '$arrDiemSV[$i]' where hocki_id = '$this->hockiID' and chitiettieuchi_id = '$id' and user_sinhvien = '$idCBL'");
                        $i++;
                    }
                }
            }
        }


        if (empty($this->checkXemUserDaChamDiemChua)) { // true tức là lớp trưởng chưa chấm điểm cho sv đó
            $i = 0;
            if ($request->luu == 1) {
                foreach ($arrDiemSV as $diem) {
                    DB::insert("insert into diem_danh_gia_cbl (diem,hocki_id,chitiettieuchi_id,user_sinhvien,user_canbolop,active) values (?, ?,?,?,?,?)", [$diem, $this->hockiID, $arrChiTietTieuChiID[$i], $userSV, $idCBL, 1]);
                    $i++;
                }
            } else {
                foreach ($arrDiemSV as $diem) {
                    DB::insert("insert into diem_danh_gia_cbl (diem,hocki_id,chitiettieuchi_id,user_sinhvien,user_canbolop) values (?, ?,?,?,?)", [$diem, $this->hockiID, $arrChiTietTieuChiID[$i], $userSV, $idCBL]);
                    $i++;
                }
            }
            return redirect()->route('sinhvien.get_loptruongtuchamdiem', ['id' => $userSV]);
        } else { // nếu có dữ liệu rồi thì cập nhật điểm
            $i = 0;
            if ($request->luu == 1) {
                foreach ($arrChiTietTieuChiID as $id) {
                    DB::select("UPDATE diem_danh_gia_cbl set diem = '$arrDiemSV[$i]', active = 1 where hocki_id = '$this->hockiID' and chitiettieuchi_id = '$id' and user_sinhvien = '$userSV' and user_canbolop = $idCBL");
                    $i++;
                }
            } else {
                foreach ($arrChiTietTieuChiID as $id) {
                    DB::select("UPDATE diem_danh_gia_cbl set diem = '$arrDiemSV[$i]' where hocki_id = '$this->hockiID' and chitiettieuchi_id = '$id' and user_sinhvien = '$userSV' and user_canbolop = $idCBL");
                    $i++;
                }
            }
            return redirect()->route('sinhvien.get_loptruongtuchamdiem', ['id' => $userSV]);
        }
    }

    public function exportDanhSachSV($id_lop)
    {
        return Excel::download(new ExportSinhVien($id_lop), 'DanhSachSinhVien.xlsx');
    }

    public function exportDanhSachKetQuaSV($id_lop)
    {
        return Excel::download(new KetQuaRenLuyenSinhVienExport($id_lop), 'KetQuaDiemRenLuyenSinhvien.xlsx');
    }
}

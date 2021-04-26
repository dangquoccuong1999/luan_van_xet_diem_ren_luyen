<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login')->name('login');
// });

Route::get('index','HomeController@index')->name('get.index');



Route::prefix('khoa')->group(function () {

    Route::get('danhsach','KhoaController@getDanhSach')->name('khoa.get_danhsach');

    Route::get('themkhoa','KhoaController@getAdd')->name('khoa.get_add');
    Route::post('themkhoa','KhoaController@postAdd')->name('khoa.post_add');

    Route::get('edit/{id}','KhoaController@getEdit')->name('khoa.get_edit');
    Route::post('edit/{id}','KhoaController@postEdit')->name('khoa.post_edit');

    Route::get('delete/{id}','KhoaController@delete')->name('khoa.delete');

});

Route::prefix('sinhvien')->group(function () {
    Route::get('tuchamdiem/{id}','SinhvienController@getTuChamdiem')->name('sinhvien.get_tuchamdiem');  
    Route::post('tuchamdiem/{id}','SinhvienController@postTuChamDiem')->name('sinhvien.post_tuchamdiem');

    Route::get('loptruongchamdiem/{id_lop}','SinhvienController@getDanhSachLopTruongChamdiem')->name('sinhvien.get_danhsachloptruongchamdiem');
    
    Route::get('loptruongtuchamdiem/{id}','SinhvienController@getLopTruongTuChamdiem')->name('sinhvien.get_loptruongtuchamdiem');
    Route::post('loptruongtuchamdiem/{id}','SinhvienController@postLopTruongTuChamDiem')->name('sinhvien.postLopTruongTuChamDiem');

    Route::get('xemdiem/{idSV}','SinhvienController@getxemdiem')->name('sinhvien.getxemdiem');
    Route::post('xemdiem/{idSV}','SinhvienController@getxemdiem')->name('sinhvien.postxemdiemtheoki');

});

Route::prefix('lop')->group(function () {
    Route::get('danhsach','LopController@getDanhSach')->name('lop.get_danhsach');

    Route::get('themlop','LopController@getAdd')->name('lop.get_add');
    Route::post('themlop','LopController@postAdd')->name('lop.post_add');

    Route::get('edit/{id}','LopController@getEdit')->name('lop.get_edit');
    Route::post('edit/{id}','LopController@postEdit')->name('lop.post_edit');

    Route::get('delete/{id}','LopController@delete')->name('lop.delete');

    Route::get('danhsachsinhvien/{id_lop}','SinhVienController@getDanhSach')->name('sinhvien.get_danhsach');

    Route::get('themsinhvien/{id_lop}','SinhVienController@getAdd')->name('sinhvien.get_add');
    Route::post('themsinhvien/{id_lop}','SinhVienController@postAdd')->name('sinhvien.post_add');

});

Route::prefix('giangvien')->group(function () {
    Route::get('danhsach','GiangVienController@getDanhSach')->name('giangvien.get_danhsach');
    
    Route::get('themgiangvien','GiangVienController@getAdd')->name('giangvien.get_add');
    Route::post('themgiangvien','GiangVienController@postAdd')->name('giangvien.post_add');


    Route::get('edit/{id}','GiangVienController@getEdit')->name('giangvien.get_edit');
    Route::post('edit/{id}','GiangVienController@postEdit')->name('giangvien.post_edit');

    Route::get('delete/{id}','GiangVienController@delete')->name('giangvien.delete');


    Route::get('danhsachdiemsinhvien/{ma_lop}','GiangVienController@getDanhSachDanhGiaDiemLop')->name('giangvien.get_danhsachdanhgiadiem');
    
    Route::get('chamdiem/{id_sv}','GiangVienController@getChamDiemSV')->name('giangvien.get_chamdiemsinhvien');
    Route::post('chamdiem/{id_sv}','GiangVienController@postChamDiemSV')->name('giangvien.post_chamdiemsinhvien');

    Route::get('add_ajax','GiangVienController@add_ajax')->name('giangvien.add_ajax');

});

Route::prefix('noidungdanhgia')->group(function () {
    Route::get('danhsach/tieuchuan','NoidungdanhgiaController@getDanhSachTieuChuan')->name('tieuchuan.get_danhsach');
    
    Route::get('danhsach/tieuchuan/edit/{id}','NoidungdanhgiaController@getEditDanhSachTieuChuan')->name('tieuchuan.get_edit_tieuchuan');
    Route::post('danhsach/tieuchuan/edit/{id}','NoidungdanhgiaController@postEditDanhSachTieuChuan')->name('tieuchuan.post_edit_tieuchuan');
    
    Route::get('danhsach/tieuchuan/add','NoidungdanhgiaController@getAddDanhSachTieuChuan')->name('tieuchuan.get_add_tieuchuan');
    Route::post('danhsach/tieuchuan/add','NoidungdanhgiaController@postAddDanhSachTieuChuan')->name('tieuchuan.post_add_tieuchuan');

    Route::get('danhsach/tieuchuan/delete/{id}','NoidungdanhgiaController@deleteDanhSachTieuChuan')->name('tieuchuan.get_delete_tieuchuan');

    //tieu chí
    Route::get('danhsach/tieuchi','NoidungdanhgiaController@getDanhSachTieuChi')->name('tieuchi.get_danhsach');

    Route::get('danhsach/tieuchi/edit/{id}','NoidungdanhgiaController@getEditDanhSachTieuChi')->name('tieuchi.get_edit_tieuchi');
    Route::post('danhsach/tieuchi/edit/{id}','NoidungdanhgiaController@postEditDanhSachTieuChi')->name('tieuchi.post_edit_tieuchi');

    Route::get('danhsach/tieuchi/add','NoidungdanhgiaController@getAddDanhSachTieuChi')->name('tieuchi.get_add');
    Route::post('danhsach/tieuchi/add','NoidungdanhgiaController@postAddDanhSachTieuChi')->name('tieuchi.post_add');
   
    Route::get('danhsach/tieuchi/delete/{id}','NoidungdanhgiaController@deleteDanhSachTieuChi')->name('tieuchi.get_delete');

    //chi tiết tiêu chí
    Route::get('danhsach/chitiettieuchi','NoidungdanhgiaController@getDanhSachChiTietTieuChi')->name('chitiettieuchi.get_danhsach');

    Route::get('danhsach/chitiettieuchi/edit/{id}','NoidungdanhgiaController@getEditDanhSachChiTietTieuChi')->name('chitiettieuchi.get_edit_tieuchi');
    Route::post('danhsach/chitiettieuchi/edit/{id}','NoidungdanhgiaController@postEditDanhSachChiTietTieuChi')->name('chitiettieuchi.post_edit_tieuchi');

    Route::get('danhsach/chitiettieuchi/add','NoidungdanhgiaController@getAddDanhSachChiTietTieuChi')->name('chitiettieuchi.get_add');
    Route::post('danhsach/chitiettieuchi/add','NoidungdanhgiaController@postAddDanhSachChiTietTieuChi')->name('chitiettieuchi.post_add');
   
    Route::get('danhsach/chitiettieuchi/delete/{id}','NoidungdanhgiaController@deleteDanhSachChiTietTieuChi')->name('chitiettieuchi.get_delete');

    // vi phạm
    Route::get('danhsach/vipham','NoidungdanhgiaController@getDanhSachVipham')->name('vipham.get_danhsach');

    Route::get('danhsach/vipham/edit/{id}','NoidungdanhgiaController@getEditDanhSachVipham')->name('vipham.get_edit_tieuchi');
    Route::post('danhsach/vipham/edit/{id}','NoidungdanhgiaController@postEditDanhSachVipham')->name('vipham.post_edit_tieuchi');

    Route::get('danhsach/vipham/add','NoidungdanhgiaController@getAddDanhSachVipham')->name('vipham.get_add');
    Route::post('danhsach/vipham/add','NoidungdanhgiaController@postAddDanhSachVipham')->name('vipham.post_add');
   
    Route::get('danhsach/vipham/delete/{id}','NoidungdanhgiaController@deleteDanhSachVipham')->name('vipham.get_delete');

});

Route::prefix('hocki')->group(function () {
    Route::get('add','HomeController@getAddHocKi')->name('hocki.get_add');
    Route::post('add','HomeController@postAddHocKi')->name('hocki.post_add');

    Route::get('danhsach','HomeController@getDanhSachHocKi')->name('hocki.get_danhsach');
    
    Route::get('actice/{id}','HomeController@getActive')->name('hocki.get_active');

    Route::get('edit{id}','HomeController@getEditHocKi')->name('hocki.get_edit');
    Route::post('edit{id}','HomeController@postEditHocKi')->name('hocki.post_edit');

    Route::get('delete{id}','HomeController@getDeleteHocKi')->name('hocki.get_delete');
});


Route::get('tonghop/{id}','GiangVienController@getTongHopKetQua')->name('khoa.get_tonghop');
Route::post('tonghop/{id}','GiangVienController@bnc_xetduyetdiem')->name('khoa.post_tonghop');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('profile','HomeController@getProfile')->name('profile.get');
Route::post('profile','HomeController@postProfile')->name('profile.post');


Route::get('/exportDanhSachSV/{id}', 'SinhvienController@exportDanhSachSV')->name('sinhvien.get_export');
Route::get('/exportKetQuaSV/{id}', 'SinhvienController@exportDanhSachKetQuaSV')->name('sinhvien.get_export_ketqua');

Route::get('/',['as'=>'admin.login.getLogin','uses'=>'Auth\LoginController@getLogin']);
Route::post('/',['as'=>'admin.login.postLogin','uses'=>'Auth\LoginController@postLogin']);
Route::get('logout',['as'=>'admin.logout','uses'=>'Auth\LoginController@logout']);

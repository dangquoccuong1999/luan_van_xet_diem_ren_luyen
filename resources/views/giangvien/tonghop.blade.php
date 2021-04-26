@extends('master')
@section('title-page', 'Bảng tổng hợp kết quả của sinh viên')

@section('content')
    <?php if (Auth::user()->vaitro == 4 || Auth::user()->vaitro == 5) {
    $id_user = Auth::user()->id;
    $id_lop = DB::select("SELECT sinhviens.lop_id FROM `sinhviens` WHERE user_id = $id_user");
    $id_lop = $id_lop[0]->lop_id;
    } elseif (Auth::user()->vaitro == 3) {
    $id_user = Auth::user()->id;
    $id_giangvien = DB::select("SELECT id FROM `giangviens` WHERE user_id = $id_user");
    $id_giangvien = $id_giangvien[0]->id;
    $id_lop = DB::select("SELECT chunhiems.lop_id FROM `chunhiems` WHERE giangvien_id = $id_giangvien");
    $id_lop = $id_lop[0]->lop_id;
    } else {
    $id_lop = $sinhViens[0]->lop_id;
    } ?>

    <form action="{{ route('khoa.post_tonghop', "$id_lop") }}" method="post">
        @csrf
        <div class="table-responsive">

            <a href="{{ route('sinhvien.get_export_ketqua', $id_lop) }}" class="btn btn-primary pull-right">Export</a>


            <table class="table table-bordered">
                <thead class="text-center">
                    <tr class="text-center">
                        <th rowspan="2">STT</th>
                        <th rowspan="2">MSSV</th>
                        <th rowspan="2">Họ Và Tên</th>
                        <th rowspan="2">TỔNG ĐIỂM</th>
                        <th rowspan="2">XẾP LOẠI</th>
                        <th rowspan="2">Ý KIẾN BAN CHỦ NHIỆM KHOA</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($sinhViens as $sv)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $sv->user->maso }}</td>
                            <td>{{ $sv->name }}</td>
                            <td>{{ $sv->diem }}</td>
                            <td>{{ $sv->xeploai }}</td>
                            <td>
                                @if ($sv->diem != null)
                                    @if ($sv->ykienbcnkhoa == 1)
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="{{ $sv->user_id }}" class="custom-control-input"
                                                checked="true" value="1">
                                            <span class="custom-control-label" for="customRadio1">Đồng ý</span>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="{{ $sv->user_id }}" class="custom-control-input"
                                                value="0">
                                            <span class="custom-control-label" for="customRadio1">Không đồng ý</span>
                                        </div>
                                    @else
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="{{ $sv->user_id }}" class="custom-control-input"
                                                value="1">
                                            <span class="custom-control-label" for="customRadio1">Đồng ý</span>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input type="radio" name="{{ $sv->user_id }}" class="custom-control-input"
                                                checked="true" value="0">
                                            <span class="custom-control-label" for="customRadio1">Không đồng ý</span>
                                        </div>
                                    @endif

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Duyệt</button>
        </div>
    </form>
  
@endsection

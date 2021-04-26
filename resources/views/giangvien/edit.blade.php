@extends('master')
@section('title-page', 'Cập nhật thông tin giảng viên')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Mã giảng viên</label>
                <input type="text" name="maso" class="form-control" value="{{ $maUser['maso'] }}" disabled>
            </div>

            <div class="form-group">
                <label for="">Vai trò </label>
                @if ($maUser['vaitro'] == 2)
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vaitro" class="custom-control-input" checked="true" value="2">
                        <span class="custom-control-label" for="customRadio1">Ban chủ nhiệm khoa</span>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vaitro" class="custom-control-input"  value="3">
                        <span class="custom-control-label" for="customRadio1">Chủ nhiệm</span>
                    </div>
                @elseif($maUser['vaitro'] == 3)
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vaitro" class="custom-control-input"  value="2">
                        <span class="custom-control-label" for="customRadio1">Ban chủ nhiệm khoa</span>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vaitro" class="custom-control-input" checked="true"  value="3">
                        <span class="custom-control-label" for="customRadio1">Chủ nhiệm</span>
                    </div>
                @else
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vaitro" class="custom-control-input">
                        <span class="custom-control-label" for="customRadio1">Ban chủ nhiệm khoa</span>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vaitro" class="custom-control-input">
                        <span class="custom-control-label" for="customRadio1">Chủ nhiệm</span>
                    </div>
                @endif


            </div>

            <div class="form-group">
                <label for="">Tên giảng viên</label>
                <input type="text" name="name" class="form-control" value="{{ $giangVien['name'] }}" required>
            </div>

            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $giangVien['email'] }}" required>
            </div>

            <div class="form-group">
                <label for="">Giới tính </label>
                <select name="gioitinh" id="" class="form-control" required>
                    <option value="{{ $giangVien['gioitinh'] }}">{{ $giangVien['gioitinh'] }}</option>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                    <option value="khác">Khác</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Ngày sinh</label>
                <input type="date" name="ngaysinh" class="form-control" value="{{ $giangVien['ngaysinh'] }}" required>
            </div>

            <div class="form-group">
                <label for="">Số điện thoại</label>
                <input type="number" name="sodienthoai" class="form-control" value="{{ $giangVien['sodienthoai'] }}"
                    required>
            </div>
            
            <?php $i = 0; ?>
            @if ($maUser['vaitro'] == 3)
                <div class="form-group">
                    <label for="">Lớp chủ nhiệm</label>
                    @foreach ($lops as $lop)
                        @if ($lop['checkCN'] == true)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="{{ $lop['id'] }}" checked='true' name="id_lop_ChuNhiem[]">
                                <span class="custom-control-label" for="customCheck1"> {{ $lop['tenlop'] }}</span>
                            </div>
                        @else
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" value="{{ $lop['id'] }}" name="id_lop_ChuNhiem[]">
                                <span class="custom-control-label" for="customCheck1"> {{ $lop['tenlop'] }}</span>
                            </div>
                        @endif
                        <?php $i++; ?>
                    @endforeach
                </div>
            @endif

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection

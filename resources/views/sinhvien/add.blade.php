@extends('master')
@section('title-page','Thêm sinh viên')
@section('content')
    <div class="col-md-8 offset-md-2">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Mã sinh viên</label>
                <input type="text" name="masv" class="form-control" placeholder="Mã sinh viên" required>
            </div>

            <div class="form-group">
                <label for="">Tên sinh viên</label>
                <input type="text" name="tensv" class="form-control" placeholder="Tên sinh viên " required>
            </div>


            <div class="form-group">
                <label for="">Ngày sinh </label>
                <input type="date" name="ngaysinh" class="form-control" required/>
            </div>

            <div class="form-group">
                <label for="">Giới tính </label><br>
                <label class="checkbox-inline"><input type="radio" value="1" name="gioitinh" checked> Nam</label>
                <label class="checkbox-inline"><input type="radio" value="0" name="gioitinh"> Nữ</label>
            </div>

            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email " required>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection
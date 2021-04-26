@extends('master')
@section('title-page', 'Thông tin cá nhân')
@section('content')

    <div class="container rounded bg-white mt-5 mb-5">
        <form action="{{ route('profile.post') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQF2psCzfbB611rnUhxgMi-lc2oB78ykqDGYb4v83xQ1pAbhPiB&usqp=CAU">
                        <div class="kv-avatar">
                            <div class="file-loading">
                                <input id="avatar-1" name="avatar" type="file">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Chỉnh sửa thông tin cá nhân</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12"><label class="labels">Họ tên</label>
                                <input type="text" class="form-control" name="name" placeholder="Họ tên"
                                    value="{{ $user['name'] }}" required>
                                @if ($errors->has('name'))
                                    <p class="text-danger" required>
                                        {{ $errors->first('name') }}
                                    </p>
                                @endif
                            </div>

                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12"><label class="labels">Ngày sinh</label>
                                <input type="date" name="ngaysinh" class="form-control" value="{{ $user['ngaysinh'] }}"
                                    required>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">Số điện thoại</label>
                                <input type="number" name="sodienthoai" class="form-control"
                                    placeholder="Nhập số điện thoại" value="{{ $user['sodienthoai'] }}" required>
                                @if ($errors->has('sodienthoai'))
                                    <p class="text-danger" required>
                                        {{ $errors->first('sodienthoai') }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-12"><label class="labels">Địa chỉ</label>
                                <input type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ"
                                    value="{{ $user['diachi'] }}" required>
                                @if ($errors->has('diachi'))
                                    <p class="text-danger" required>
                                        {{ $errors->first('diachi') }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-12"><label class="labels">Email ID</label>
                                <input type="email" class="form-control" name="email" placeholder="Nhập email"
                                    value="{{ $user['email'] }}" required>
                                @if ($errors->has('email'))
                                    <p class="text-danger" required>
                                        {{ $errors->first('email') }}
                                    </p>
                                @endif
                            </div>
                            <div class="col-md-12"><label class="labels">Giới tính</label>
                                @if ($user['gioitinh'] == 'Nam')
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="gioitinh" class="custom-control-input" value="Nam"
                                            checked="true">
                                        <span class="custom-control-label" for="customRadio1">Nam</span>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="gioitinh" class="custom-control-input" value="Nữ">
                                        <span class="custom-control-label" for="customRadio1">Nữ</span>
                                    </div>
                                @else
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="gioitinh" class="custom-control-input" value="nam">
                                        <span class="custom-control-label" for="customRadio1">Nam</span>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" name="gioitinh" class="custom-control-input" value="Nữ"
                                            checked="true">
                                        <span class="custom-control-label" for="customRadio1">Nữ</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12"><label class="labels">Password</label>
                                <input type="password" name="password" class="form-control"
                                    value="{{ Auth::user()->password }}" required>
                                @if ($errors->has('password'))
                                    <p class="text-danger" required>
                                        {{ $errors->first('password') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" type="submit" style="margin-top:5%">Lưu</button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

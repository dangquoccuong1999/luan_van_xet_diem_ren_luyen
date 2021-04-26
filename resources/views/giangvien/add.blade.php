@extends('master')
@section('title-page', 'Thêm giảng viên')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Mã giảng viên</label>
                <input type="text" name="maso" class="form-control" placeholder="Mã giảng viên" required>
            </div>

            <div class="form-group">
                <label for="">Vai trò </label>
                <select name="vaitro" id="" class="form-control" required>
                    <option value="">--Chọn vai trò--</option>
                    <option value="2">Ban chủ nhiệm khoa</option>
                    <option value="3">Chủ nhiệm</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Tên giảng viên</label>
                <input type="text" name="name" class="form-control" placeholder="Họ Tên" required>
            </div>

            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="form-group">
                <label for="">Giới tính </label>
                <select name="gioitinh" id="" class="form-control" required>
                    <option value="">--Chọn giới tính--</option>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                    <option value="khác">Khác</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Ngày sinh</label>
                <input type="date" name="ngaysinh" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="">Số điện thoại</label>
                <input type="number" name="sodienthoai" class="form-control" placeholder="Số điện thoại" required>
            </div>

            <div class="form-group">
                <label for="">Khoa </label>
                <select name="khoa" id="khoa" class="form-control khoa" required>
                    <option value="">--Chọn khoa--</option>
                    @foreach ($khoas as $khoa)
                        <option value="{{ $khoa['id'] }}">{{ $khoa['tenkhoa'] }}</option>
                    @endforeach

                </select>
            </div>

            {{-- <div class="form-group">
                <label for="">Lớp chủ nhiệm</label>
                <div class="custom-control custom-checkbox lopchunhiem">
                    <input type="checkbox" value="" name="lopchunhiem" id="lopchunhiem">
                    <span class="custom-control-label" for="customCheck1"> A</span>
                </div>
            </div> --}}

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.khoa').change(function() {
                var id = $(this).val();
                console.log(id);
                var _token = $('input[name="_token"]').val();
                var div = $(this).parent().parent();

                var op = " ";
                $.ajax({
                    url: "/giangvien/add_ajax",
                    type: 'GET',
                    dataType: "JSON",
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        op += '<option value="">Please select</option>';
                        for (var i = 0; i < data.length; i++) {
                            op += '<option value="' + data[i].id + '">' + data[i]
                                .tenkhoa + '</option>';
                        }
                        div.find('.lopchunhiem').html(" ");
                        div.find('.lopchunhiem').append(op);
                    }
                    error: function(data) {
                        console.log('loiiii');
                        console.log(data);
                    }
                });
            });
        });

    </script>
@endsection

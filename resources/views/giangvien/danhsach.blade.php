@extends('master')
@section('title-page','Danh sách giảng viên')
@section('content')
    <div class="table-responsive">
        <div class="form-group">
            <a href="{{ route('giangvien.get_add') }}" class="btn btn-primary">Thêm giảng viên</a>

        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Giới tính</th>
                <th>Số điện thoại</th>
                <th>Chức vụ</th>
                <th>Thao tác</th>
            </tr>
            </thead>

            <tbody>
            <?php $stt = 0; ?>
            @foreach($giangviens as $item)
           
                <?php $stt++; ?>
                <tr>
                    <td>{{ $stt }}</td>

                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['gioitinh'] }}</td>
                    <td>{{ $item['sodienthoai'] }}</td>
                    <td>{{ $item['chucvu'] }}</td>
                    <td>
                        <a href="{{ route('giangvien.get_edit', $item['id']) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a onclick="return confirm('Bạn chắc chắn muốn xóa ?')" href="{{ route('giangvien.delete', $item['id']) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>

@endsection

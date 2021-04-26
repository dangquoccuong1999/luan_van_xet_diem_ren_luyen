@extends('master')
@section('title-page','Danh sách khoa')
@section('content')
    <div class="table-responsive">
        <div class="form-group">
            <a href="{{ route('khoa.get_add') }}" class="btn btn-primary">Thêm khoa</a>

        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>STT</th>
                <th>Tên khoa</th>
                <th>Thao tác</th>
            </tr>
            </thead>

            <tbody>
            <?php $stt = 0; ?>
            @foreach($khoa as $item)
                <?php $stt++; ?>
                <tr>
                    <td>{{ $stt }}</td>

                    <td>{{ $item['tenkhoa'] }}</td>
                    <td>
                        <a href="{{ route('khoa.get_edit', $item['id']) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a onclick="return confirm('Bạn chắc chắn muốn xóa ?')" href="{{ route('khoa.delete', $item['id']) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>

@endsection

@extends('master')
@section('title-page', 'Danh sách lớp')
@section('content')
    <div class="table-responsive">
        <div class="form-group">
            @if (Auth::user()->vaitro == 1)
                <a href="{{ route('lop.get_add') }}" class="btn btn-primary">Thêm lớp</a>
            @endif
        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên lớp</th>
                    <th>Khoa</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php $stt = 0; ?>
                @foreach ($lops as $item)
                    <?php $stt++; ?>
                    <tr>
                        <td>{{ $stt }}</td>

                        <td>{{ $item->tenlop }}</td>
                        <td>{{ $item->tenkhoa }}</td>
                        <td>
                            @if (Auth::user()->vaitro != 2)
                                <a href="{{ route('sinhvien.get_danhsach', $item->id) }}">DS sinh viên</a>
                            @else
                            <a href="{{ route('khoa.get_tonghop', $item->id) }}">Kết quả đánh giá </a>
                            @endif

                            @if (Auth::user()->vaitro == 1)
                                <a href="{{ route('lop.get_edit', $item->id) }}" class="btn btn-info btn-sm"><i
                                        class="fa fa-edit"></i> Edit</a>
                                <a onclick="return confirm('Bạn chắc chắn muốn xóa ?')"
                                    href="{{ route('lop.delete', $item->id) }}" class="btn btn-danger btn-sm"><i
                                        class="fa fa-trash"></i> Delete </a>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        {{ $lops->links() }}

    </div>

@endsection

@extends('master')
@section('title-page', 'Danh sách vi phạm')
@section('content')
    <div class="table-responsive">
        <div class="form-group">
            <a href="{{ route('vipham.get_add') }}" class="btn btn-primary">Thêm vi phạm</a>

        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Nội dung</th>
                    <th>Số điểm trừ</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php $stt = 0; ?>
                @foreach ($viPhams as $item)

                    <?php $stt++; ?>
                    <tr>
                        <td>{{ $stt }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['sodiemtru'] }}</td>
                        <td>
                            <a href="{{ route('vipham.get_edit_tieuchi', $item['id']) }}" class="btn btn-info btn-sm"><i
                                    class="fa fa-edit"></i> Edit</a>
                            <a onclick="return confirm('Bạn chắc chắn muốn xóa ?')"
                                href="{{ route('vipham.get_delete', $item['id']) }}"
                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>

@endsection

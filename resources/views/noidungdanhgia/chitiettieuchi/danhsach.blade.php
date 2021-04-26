@extends('master')
@section('title-page','Danh sách chi tiết tiêu chí')
@section('content')
    <div class="table-responsive">
        <div class="form-group">
            <a href="{{ route('chitiettieuchi.get_add') }}" class="btn btn-primary">Thêm chi tiết tiêu chí</a>

        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>STT</th>
                <th>Nội dung</th>
                <th>Số điểm</th> 
                <th></th>
            </tr>
            </thead>

            <tbody>
            <?php $stt = 0; ?>
            @foreach($tieuChis as $item)
           
                <?php $stt++; ?>
                <tr>
                    <td>{{ $stt }}</td>
                    <td>{{ $item['name'] }}</td> 
                    <td>{{ $item['sodiem'] }}</td>  
                    <td>
                        <a href="{{ route('chitiettieuchi.get_edit_tieuchi', $item['id']) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a onclick="return confirm('Bạn chắc chắn muốn xóa ?')" href="{{ route('chitiettieuchi.get_delete', $item['id']) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>

@endsection

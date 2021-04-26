@extends('master')
@section('title-page','Danh sách tiêu chuẩn')
@section('content')
    <div class="table-responsive">
        <div class="form-group">
            <a href="{{ route('tieuchuan.get_add_tieuchuan') }}" class="btn btn-primary">Thêm tiêu chuẩn</a>

        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>STT</th>
                <th>Nội dung</th> 
                <th></th> 
            </tr>
            </thead>

            <tbody>
            <?php $stt = 0; ?>
            @foreach($tieuChuans as $item)
           
                <?php $stt++; ?>
                <tr>
                    <td>{{ $stt }}</td>

                    <td>{{ $item['name'] }}</td>  
                    <td>
                        <a href="{{ route('tieuchuan.get_edit_tieuchuan', $item['id']) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit</a>
                        <a onclick="return confirm('Bạn chắc chắn muốn xóa ?')" href="{{route('tieuchuan.get_delete_tieuchuan',$item['id'])}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>

@endsection

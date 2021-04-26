@extends('master')
@section('title-page','Thêm lớp')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf

            <div class="form-group">
                <label for="">Khoa</label>
                <select name="khoa" id="" class="form-control" required>
                    <option value="">--Chọn khoa--</option>
                    @foreach($khoas as $item)
                        <option value="{{ $item['id'] }}">{{ $item['tenkhoa'] }}</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="">Tên lớp</label>
                <input type="text" name="tenlop" class="form-control" placeholder="Tên lớp" required>
            </div>

            {{-- <div class="form-group">
                <label for="">Hệ đào tạo</label>
                <select name="hedaotao" id="" class="form-control" required>
                    <option value="">--Chọn hệ dào tạo--</option>
                    <option value="1">Đại học</option>
                    <option value="2">Cao đẳng</option>
                </select>
            </div> --}}

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection
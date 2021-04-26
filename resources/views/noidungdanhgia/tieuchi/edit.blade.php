@extends('master')
@section('title-page', 'Cập nhật tiêu chí')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Tiêu chuẩn</label>
                <select name="tieuchuan_id" id="" class="form-control" required>      
                    <option value="{{ $tieuChuanHienTai['id'] }}">{{  $tieuChuanHienTai['name'] }}</option>          
                    @foreach ($tieuChuans as $item)
                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="">Nội dung</label>
                <input type="text" name="name" class="form-control" value="{{ $tieuChi['name'] }}" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection

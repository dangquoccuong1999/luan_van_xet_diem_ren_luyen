@extends('master')
@section('title-page','Cập nhật tiêu chuẩn')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Nội dung</label>
                <input type="text" name="name" class="form-control" value="{{$tieuchuan['name']}}" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
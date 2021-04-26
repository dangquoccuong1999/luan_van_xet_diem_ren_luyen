@extends('master')
@section('title-page','Thêm tiêu chuẩn')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Nội dung</label>
                <input type="text" name="name" class="form-control" placeholder="Nội dung tiêu chuẩn" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection
@extends('master')
@section('title-page','Thêm khoa')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Tên khoa</label>
                <input type="text" name="tenkhoa" class="form-control" placeholder="Tên khoa" required>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection
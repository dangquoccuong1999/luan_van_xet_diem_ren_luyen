@extends('master')
@section('title-page', 'Cập nhật học kì')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            
            <div class="form-group">
                <label for="">Học kì</label>
                <input type="number" name="name" class="form-control" step="1" required value="{{$hocKi['name']}}">
                @if (Session::has('hocki'))
                <p class="text-danger"> {{ Session('hocki') }}</p>
            @endif
            </div>

            <div class="form-group">
                <label for="">Năm học</label>
                <input type="number" name="nam" class="form-control"  step="1" required  value="{{$hocKi['nam']}}">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection

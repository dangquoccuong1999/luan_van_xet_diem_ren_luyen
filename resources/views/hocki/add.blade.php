@extends('master')
@section('title-page', 'Thêm học kì')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            
            <div class="form-group">
                <label for="">Học kì</label>
                <input type="number" name="name" class="form-control" step="1" required placeholder="Học kì 1 hoặc 2">
                @if (Session::has('hocki'))
                <p class="text-danger"> {{ Session('hocki') }}</p>
            @endif
            </div>

            <div class="form-group">
                <label for="">Năm học</label>
                <input type="number" name="nam" class="form-control"  step="1" required  placeholder="Năm học">
            </div>

            <div class="custom-control custom-radio">
                <input type="radio" name="active" class="custom-control-input" value="1">
                <span class="custom-control-label" for="customRadio1">Active</span>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" name="active" class="custom-control-input"  value="0">
                <span class="custom-control-label" for="customRadio1"> No Active</span>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
@endsection

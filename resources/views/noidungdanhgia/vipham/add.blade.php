@extends('master')
@section('title-page', 'Thêm vi phạm')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            
            <div class="form-group">
                <label for="">Nội dung</label>
                <input type="text" name="name" class="form-control" placeholder="Vi phạm" required>
            </div>

            <div class="form-group">
                <label for="">Số điểm trừ</label>
                <input type="number" name="sodiemtru" class="form-control" placeholder="Số điểm từ -25 đến 0" step="0.5" required>
                @if (Session::has('diemViPham'))
                    <p class="text-danger"> {{ Session('diemViPham') }}</p>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection

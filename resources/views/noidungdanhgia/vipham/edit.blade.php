@extends('master')
@section('title-page', 'Cập nhật vi phạm')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Nội dung vi phạm</label>
                <input type="text" name="name" class="form-control" value="{{ $viPham['name'] }}" required>
            </div>

            <div class="form-group">
                <label for="">Số điểm</label>
                <input type="number" name="sodiemtru" class="form-control" value="{{ $viPham['sodiemtru'] }}" step="0.5"
                    required>
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

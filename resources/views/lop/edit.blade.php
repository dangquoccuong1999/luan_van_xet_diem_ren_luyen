@extends('master')
@section('title-page', 'Cập nhật lớp')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Khoa</label>
                <select name="khoa" id="" class="form-control" required>
                    <option value="">--Chọn khoa--</option>
                    @foreach ($khoas as $item)
                        @if ($khoaHienTai == $item->id)
                            <option selected value="{{ $item['id'] }}">{{ $item['tenkhoa'] }}</option>
                        @else
                            <option value="{{ $item['id'] }}">{{ $item['tenkhoa'] }}</option>
                        @endif
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="">Tên lớp</label>
                <input type="text" name="tenlop" class="form-control" value="{{ $lops['tenlop'] }}" required>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection

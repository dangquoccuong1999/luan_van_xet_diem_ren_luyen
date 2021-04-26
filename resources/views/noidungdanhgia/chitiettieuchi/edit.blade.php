@extends('master')
@section('title-page', 'Cập nhật chi tiết tiêu chí')
@section('content')
    <div class="col-md-8 offset-md-2">
        <form action="" method="post">
            @csrf
            <div class="form-group">
                <label for="">Tiêu chí</label>
                <select name="tieuchi_id" id="" class="form-control" required>
                    <option value="{{ $tieuChiHienTai['id'] }}">{{ $tieuChiHienTai['name'] }}</option>
                    @foreach ($tieuChis as $item)
                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                    @endforeach

                </select>
            </div>
            <div class="form-group">
                <label for="">Nội dung chi tiết tiêu chí</label>
                <input type="text" name="name" class="form-control" value="{{ $tieuChi['name'] }}" required>
            </div>

            <div class="form-group">
                <label for="">Số điểm</label>
                <input type="number" name="sodiem" class="form-control" value="{{ $tieuChi['sodiem'] }}" step="0.5"
                    required>
                @if (Session::has('diemViPham'))
                    <p class="text-danger"> {{ Session('diemViPham') }}</p>
                @endif
            </div>

            <div class="form-group">
                <label for="">Vi phạm</label>
                @if ($tieuChi['vipham'] == 1)
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vipham" class="custom-control-input" checked="true" value="1">
                        <span class="custom-control-label" for="customRadio1">Có </span>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vipham" class="custom-control-input" value="0">
                        <span class="custom-control-label" for="customRadio1">Không</span>
                    </div>
                @else
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vipham" class="custom-control-input" value="1">
                        <span class="custom-control-label" for="customRadio1">Có </span>
                    </div>
                    <div class="custom-control custom-radio">
                        <input type="radio" name="vipham" class="custom-control-input" checked="true" value="0">
                        <span class="custom-control-label" for="customRadio1">Không</span>
                    </div>
                @endif

            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection

@extends('master')
@section('title-page', 'Danh sách học kì')
@section('content')
    <div class="table-responsive">
        <div class="form-group">
            <a href="{{ route('hocki.get_add') }}" class="btn btn-primary">Thêm học kì</a>
        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Học kì</th>
                    <th>Năm học</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php $stt = 0; ?>
                @foreach ($hocKis as $item)

                    <?php $stt++; ?>
                    <tr>
                        <td>{{ $stt }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['nam'] }}</td>
                        <td>
                            <div class="custom-control custom-radio">
                                @if ($item['active'] == 1)
                                    <input type="radio" name="active" class="custom-control-input" checked="true"
                                        value="{{ $item['active'] }}">
                                    <span class="custom-control-label" for="customRadio1">Active</span>
                                @else
                                    <input type="radio" name="active" class="custom-control-input"
                                        value="{{ $item['active'] }}">
                                    <span class="custom-control-label" for="customRadio1">No Active</span>
                                @endif

                            </div>
                        </td>
                        <td>
                            <a href="{{ route('hocki.get_edit', $item['id']) }}" class="btn btn-info btn-sm"><i
                                    class="fa fa-edit"></i> Edit</a>
                            <a onclick="return confirm('Bạn chắc chắn muốn xóa ?')"
                                href="{{ route('hocki.get_delete', $item['id']) }}" class="btn btn-danger btn-sm"><i
                                    class="fa fa-trash"></i> Delete </a>
                            <a href="{{ route('hocki.get_active', $item['id']) }}" class="btn btn-success btn-sm"><i
                                    class="fa fa-edit"></i> Active</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>

@endsection

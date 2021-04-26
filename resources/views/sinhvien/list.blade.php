@extends('master')
@section('title-page', 'Danh sách sinh viên')
@section('content')
    <div class="table-responsive">
        <div class="form-group">
            <?php if (Auth::user()->vaitro == 4 || Auth::user()->vaitro == 5) {
            $id_user = Auth::user()->id;
            $id_lop = DB::select("SELECT sinhviens.lop_id FROM `sinhviens` WHERE user_id = $id_user");
            } elseif (Auth::user()->vaitro == 3) {
            $id_user = Auth::user()->id;

            $id_giangvien = DB::select("SELECT id FROM `giangviens` WHERE user_id = $id_user");
            $id_giangvien = $id_giangvien[0]->id;
            $id_lop = DB::select("SELECT chunhiems.lop_id FROM `chunhiems` WHERE giangvien_id = $id_giangvien");
            } ?>
            <a href="{{ route('sinhvien.get_export', $id_lop[0]->lop_id) }}" class="btn btn-primary pull-right">Export</a>
        </div>

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Mã sinh viên</th>
                    <th>Tên sinh viên</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>chức vụ</th>
                    <th>Thao tác</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($sinhviens as $item)

                    <tr>
                        <td>{{ $item->maso }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->ngaysinh }}</td>
                        <td>{{ $item->gioitinh == 1 ? 'Nam' : 'Nữ' }}</td>

                        <td>{{ $item->email }}</td>

                        <td>{{ $item->sodienthoai }}</td>
                        <td>
                            @if ($item->chucvu == 5)
                                Lớp trưởng
                            @elseif($item->chucvu == 4)
                                Sinh viên
                            @endif
                        </td>
                        <td>
                            @if ($item->checkSV || $item->id == Auth::user()->id)
                                @if (Auth::user()->vaitro == 5)
                                    <a href="{{ route('sinhvien.get_loptruongtuchamdiem', $item->id) }}"
                                        class="btn btn-warning btn-sm">Chấm
                                        điểm</a>
                                    <a href="{{ route('sinhvien.getxemdiem', $item->id) }}"
                                        class="btn btn-success btn-sm">Xem điểm </a>
                                    @if ($item->checkCBL)
                                        <p class="text-success">Đã chấm </p>
                                    @else
                                        <p class="text-danger">Chưa chấm</p>
                                    @endif
                                @elseif (Auth::user()->vaitro == 3)
                                    @if ($item->checkCBL)
                                        <a href="{{ route('giangvien.get_chamdiemsinhvien', $item->id) }}"
                                            class="btn btn-warning btn-sm">Chấm
                                            điểm</a>
                                        <a href="{{ route('sinhvien.getxemdiem', $item->id) }}"
                                            class="btn btn-success btn-sm">Xem điểm </a>
                                            @if ($item->checkCV)
                                            <p class="text-success">Đã chấm </p>
                                        @else
                                            <p class="text-danger">Chưa chấm</p>
                                        @endif
                                    @else
                                        <a class="btn btn-secondary btn-sm" disabled>Chấm
                                            điểm</a>
                                        <a class="btn btn-secondary btn-sm" disabled>Xem điểm </a>
                                    @endif

                                   
                                @elseif (Auth::user()->vaitro == 1)
                                    <a class="btn btn-secondary btn-sm" disabled>Chấm
                                        điểm</a>
                                    <a href="{{ route('sinhvien.getxemdiem', $item->id) }}"
                                        class="btn btn-success btn-sm">Xem điểm </a>
                                @elseif (Auth::user()->vaitro == 2)
                                    <a class="btn btn-secondary btn-sm" disabled>Chấm
                                        điểm</a>
                                    <a href="{{ route('sinhvien.getxemdiem', $item->id) }}"
                                        class="btn btn-success btn-sm">Xem điểm </a>
                                @elseif (Auth::user()->vaitro == 4)
                                    <a class="btn btn-secondary btn-sm" disabled>Chấm
                                        điểm</a>
                                    <a href="{{ route('sinhvien.getxemdiem', $item->id) }}"
                                        class="btn btn-success btn-sm">Xem điểm </a>
                                @endif
                            @else
                                <a class="btn btn-secondary btn-sm" disabled>Chấm
                                    điểm</a>
                                <a class="btn btn-secondary btn-sm" disabled>Xem điểm </a>
                            @endif
                        </td>
                    </tr>

                @endforeach

            </tbody>
        </table>
        {{ $sinhviens->links() }}

    </div>

@endsection

@section('script')

    <script>
        $(document).ready(function() {

            $('#example').DataTable({
                data: data
            });
        });

    </script>
@endsection

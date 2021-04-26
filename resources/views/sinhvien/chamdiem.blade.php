@extends('master')
@section('title-page',
    'PHIẾU ĐÁNH GIÁ KẾT QUẢ RÈN LUYỆN CỦA SINH VIÊN HỆ ĐẠI HỌC CHÍNH QUY ( Chú ý điểm chấm phải nhỏ
    hơn thang điểm quy định )',)

@section('content')
    <div class="table-responsive">
        @if (Auth::user()->vaitro == 3)
            <form method="post" action="{{ route('giangvien.post_chamdiemsinhvien', $id_SV) }} ">
        @endif

        @if (Auth::user()->vaitro == 4)
            <form method="post" action="{{ route('sinhvien.post_tuchamdiem', Auth::user()->id) }} ">
        @endif

        @if (Auth::user()->vaitro == 5)
            <form method="post" action="{{ route('sinhvien.postLopTruongTuChamDiem', $id_SV) }} ">
        @endif

        @csrf
        <table class="table table-bordered" id="bangDiem">
            <thead>
                <tr>
                    <th colspan="6">Nội dung đánh giá</th>
                    <th>Thang điểm</th>
                    <th>Sinh viên</th>
                    <th>Lớp</th>
                    <th>Khoa</th>

                </tr>
            </thead>

            <tbody>
                <?php $j = 0; ?>
                @foreach ($tieuChuan as $key => $tieuchuan)
                    <tr style="font-weight: bold">
                        <td colspan="6">{{ $key + 1 }} . {{ $tieuchuan['name'] }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @foreach ($tieuChiDanhGia as $key => $tieuchidanhgia)
                        @if ($tieuchidanhgia['tieuchuan_id'] == $tieuchuan['id'])
                            <tr>
                                <td colspan="6"><i>{{ $key + 1 }} . {{ $tieuchidanhgia['name'] }}</i></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @foreach ($chiTietTieuChi as $chitiettieuchi)
                                @if ($chitiettieuchi['tieuchi_id'] == $tieuchidanhgia['id'])
                                    <tr>
                                        <td colspan="6"> - {{ $chitiettieuchi['name'] }}
                                            @if ($chitiettieuchi['vipham'] == 1)
                                                @foreach ($viPham as $vipham)
                                                    <p>+ {{ $vipham['name'] }} : {{ $vipham['sodiemtru'] }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $chitiettieuchi['sodiem'] }}</td>
                                        @if (Auth::user()->vaitro == 4)
                                            @if ($chitiettieuchi['vipham'] == 1)
                                                <td>
                                                    @if (empty($diemSV))
                                                        <input type="number" step="0.5" value="0"
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @else
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @endif
                                                    <?php
                                                    $id = $chitiettieuchi['id'];
                                                    $j++;
                                                    ?>
                                                    @if ($errors->has("diemvipham-$id"))
                                                        <p class="text-danger" required>
                                                            {{ $errors->first("diemvipham-$id") }}
                                                        </p>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="number" step="0.5" value="" disabled
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.5" value="" disabled
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                </td>
                                            @else
                                                <td>
                                                    @if (empty($diemSV))
                                                        <input type="number" step="0.5" value="0"
                                                            name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                    @else
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                    @endif

                                                    <?php
                                                    $id = $chitiettieuchi['id'];
                                                    $j++;
                                                    ?>
                                                    @if ($errors->has("diemSV-$id"))
                                                        <p class="text-danger" required>
                                                            {{ $errors->first("diemSV-$id") }}
                                                        </p>
                                                    @endif
                                                </td>
                                                <td><input type="number" disabled></td>
                                                <td><input type="number" disabled></td>
                                            @endif
                                        @endif

                                        @if (Auth::user()->vaitro == 3)
                                            @if ($chitiettieuchi['vipham'] == 1)
                                                <td>
                                                    @if (empty($diemSV))
                                                        <input type="number" step="0.5" value="0" disabled>
                                                    @else
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            disabled>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (empty($diemSV))
                                                        <input type="number" step="0.5" value="0" disabled
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @elseif(!empty($diemSV) && empty($diemCBL))
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            disabled name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @elseif(!empty($diemCBL))
                                                        <input type="number" step="0.5" value="{{ $diemCBL[$j]->diem }}"
                                                            disabled name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (empty($diemGV))
                                                        <input type="number" step="0.5" value="0"
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @elseif(!empty($diemCBL) && empty($diemGV))
                                                        <input type="number" step="0.5" value="{{ $diemCBL[$j]->diem }}"
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @elseif(!empty($diemGV))
                                                        <input type="number" step="0.5" value="{{ $diemGV[$j]->diem }}"
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @endif
                                                    <?php
                                                    $id = $chitiettieuchi['id'];
                                                    $j++;
                                                    ?>
                                                    @if ($errors->has("diemvipham-$id"))
                                                        <p class="text-danger" required>
                                                            {{ $errors->first("diemvipham-$id") }}
                                                        </p>
                                                    @endif
                                                </td>
                                            @else
                                                <td>
                                                    @if (empty($diemSV))
                                                        <input type="number" step="0.5" value="0" disabled>
                                                    @else
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            disabled>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($diemSV) && empty($diemCBL))
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            disabled name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                    @elseif(!empty($diemCBL))
                                                        <input type="number" step="0.5" value="{{ $diemCBL[$j]->diem }}"
                                                            disabled name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($diemCBL) && empty($diemGV))
                                                        <input type="number" step="0.5" value="{{ $diemCBL[$j]->diem }}"
                                                            name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                    @elseif(!empty($diemGV))
                                                        <input type="number" step="0.5" value="{{ $diemGV[$j]->diem }}"
                                                            name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                    @endif
                                                    <?php
                                                    $id = $chitiettieuchi['id'];
                                                    $j++;
                                                    ?>
                                                    @if ($errors->has("diemSV-$id"))
                                                        <p class="text-danger" required>
                                                            {{ $errors->first("diemSV-$id") }}
                                                        </p>
                                                    @endif
                                                </td>
                                            @endif
                                        @endif

                                        @if (Auth::user()->vaitro == 5)
                                            @if ($chitiettieuchi['vipham'] == 1)
                                                <td>
                                                    @if (empty($diemSV))
                                                        <input type="number" step="0.5" value="0" disabled>
                                                    @else
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            disabled>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (empty($diemSV))
                                                        <input type="number" step="0.5" value="0"
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @elseif(!empty($diemSV) && empty($diemCBL))
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @elseif(!empty($diemCBL))
                                                        <input type="number" step="0.5" value="{{ $diemCBL[$j]->diem }}"
                                                            name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                    @endif

                                                    <?php
                                                    $id = $chitiettieuchi['id'];
                                                    $j++;
                                                    ?>
                                                    @if ($errors->has("diemvipham-$id"))
                                                        <p class="text-danger" required>
                                                            {{ $errors->first("diemvipham-$id") }}
                                                        </p>
                                                    @endif
                                                </td>
                                                <td><input type="number" disabled></td>
                                            @else
                                                <td>
                                                    @if (empty($diemSV))
                                                        <input type="number" step="0.5" value="0" disabled>
                                                    @else
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            disabled>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($diemSV) && empty($diemCBL))
                                                        <input type="number" step="0.5" value="{{ $diemSV[$j]->diem }}"
                                                            name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                    @elseif(!empty($diemCBL))
                                                        <input type="number" step="0.5" value="{{ $diemCBL[$j]->diem }}"
                                                            name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                    @else
                                                        <input type="number" step="0.5" value="0"
                                                        name="diemSV-{{ $chitiettieuchi['id'] }}">                      
                                                    @endif

                                                    <?php
                                                    $id = $chitiettieuchi['id'];
                                                    $j++;
                                                    ?>
                                                    @if ($errors->has("diemSV-$id"))
                                                        <p class="text-danger" required>
                                                            {{ $errors->first("diemSV-$id") }}
                                                        </p>
                                                    @endif
                                                </td>
                                                <td><input type="number" disabled></td>
                                            @endif
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endforeach
                <tr>
                    <td colspan="6"><b>Tổng điểm sinh viên đạt được = Tổng điểm các phần 1 + 2 + 3 + 4 + 5 </b></td>
                    <td colspan="1"></td>
                    <td>{{ $tongDiemSV }}</td>
                    @if (Auth::user()->vaitro == 5 || Auth::user()->vaitro == 3 ||Auth::user()->vaitro == 2 ||Auth::user()->vaitro == 1)
                        <td>{{ $tongDiemCBL }}</td>
                    @endif
                    @if (Auth::user()->vaitro == 3 ||Auth::user()->vaitro == 2 ||Auth::user()->vaitro == 1)
                        <td>{{ $tongDiemGV }}</td>
                    @endif
                </tr>
                <tr>
                    <td colspan="6"><b>Xếp loại </b></td>
                    <td colspan="1"></td>
                    <td>{{ $xepLoaiSV }}</td>
                    @if (Auth::user()->vaitro == 5 || Auth::user()->vaitro == 3 ||Auth::user()->vaitro == 2 ||Auth::user()->vaitro == 1)
                        <td>{{ $xepLoaiCBL }}</td>
                    @endif
                    @if (Auth::user()->vaitro == 3 ||Auth::user()->vaitro == 2 ||Auth::user()->vaitro == 1)
                        <td>{{ $xepLoaiGV }}</td>
                    @endif
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td colspan="1"></td>
                    @if (Auth::user()->vaitro == 4 || Auth::user()->vaitro == 5)
                        <td>
                            <button type="submit" class="btn btn-primary" name="luu" value="0">Lưu</button>
                            <button type="submit" class="btn btn-danger" style="float: right;"name="luu" value="1">Nộp</button>
                        </td>
                        <td></td> 
                    @else
                    <td>
                        <button type="submit" class="btn btn-primary" name="luu" value="0">Lưu</button>
                    </td>               
                    @endif
                    <td></td>
                </tr>
            </tbody>
        </table>
        </form>
    </div>

@endsection

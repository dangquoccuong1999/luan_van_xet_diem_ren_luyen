@extends('master')
@section('title-page',
    'PHIẾU ĐÁNH GIÁ KẾT QUẢ RÈN LUYỆN CỦA SINH VIÊN HỆ ĐẠI HỌC CHÍNH QUY ( Chú ý điểm chấm phải nhỏ
    hơn thang điểm quy định )',)

@section('content')

    <div class="container" style="text-align:center">
        <form method="post" action="{{ route('sinhvien.postxemdiemtheoki', $id_SV) }}">
            @csrf
            <select class="form-select" aria-label="Default select example" name="kihoc" required>
                <option value="">--Chọn kì học--</option>
                @foreach ($hocKiAll as $item)
                    @if ($kihoc == $item->id)
                        <option selected value="{{ $item->id }}">{{ 'Kì ' . $item->name . ' - Năm ' . $item->nam }}
                        @else
                        <option value="{{ $item->id }}">{{ 'Kì ' . $item->name . ' - Năm ' . $item->nam }}
                    @endif
                    </option>
                @endforeach
            </select>
            <button type="submit">
                <div class="fa fa-search"></div>
            </button>
        </form>
    </div>

    <div class="table-responsive">
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
                                        @if ($chitiettieuchi['vipham'] == 1)
                                            <td>
                                                @if (empty($diemSV))
                                                    <input type="number" step="0.1" value="" disabled>
                                                @else
                                                    <input type="number" step="0.1" value="{{ $diemSV[$j]->diem }}"
                                                        disabled>
                                                @endif
                                            </td>
                                            <td>
                                                @if (empty($diemCBL))
                                                    <input type="number" step="0.1" value="" disabled
                                                        name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                @else
                                                    <input type="number" step="0.1" value="{{ $diemCBL[$j]->diem }}"
                                                        disabled name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($diemGV))
                                                    <input type="number" step="0.1" value="{{ $diemGV[$j]->diem }}"
                                                        disabled name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                @else
                                                    <input type="number" step="0.1" value="" disabled
                                                        name="diemvipham-{{ $chitiettieuchi['id'] }}">
                                                @endif
                                            </td>
                                            <?php $j++; ?>
                                        @else
                                            <td>
                                                @if (empty($diemSV))
                                                    <input type="number" step="0.1" value="" disabled>
                                                @else
                                                    <input type="number" step="0.1" value="{{ $diemSV[$j]->diem }}"
                                                        disabled>
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($diemCBL))
                                                    <input type="number" step="0.1" value="{{ $diemCBL[$j]->diem }}"
                                                        disabled name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                @else
                                                    <input type="number" step="0.1" value="" disabled
                                                        name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($diemGV))
                                                    <input type="number" step="0.1" value="{{ $diemGV[$j]->diem }}"
                                                        disabled name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                @else
                                                    <input type="number" step="0.1" value="" disabled
                                                        name="diemSV-{{ $chitiettieuchi['id'] }}">
                                                @endif
                                            </td>
                                            <?php $j++; ?>
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
                    <td>{{ $tongDiemCBL }}</td>
                    <td>{{ $tongDiemGV }}</td>
                </tr>
                <tr>
                    <td colspan="6"><b>Xếp loại </b></td>
                    <td colspan="1"></td>
                    <td>{{ $xepLoaiSV }}</td>
                    <td>{{ $xepLoaiCBL }}</td>
                    <td>{{ $xepLoaiGV }}</td>
                </tr>
                <tr>
                    <td colspan="6"><b>Ý kiến ban chủ nhiệm khoa </b></td>
                    <td colspan="1"></td>
                    @if (!empty($yKienBCN))
                        @if ($yKienBCN[0]->y_kien_bcn == 0)
                            <td>
                                <p class="text-danger">KHÔNG ĐỒNG Ý KẾT QUẢ </p>
                            </td>
                        @else
                            <td>
                                <p class="text-success">ĐỒNG Ý KẾT QUẢ </p>
                            </td>
                        @endif
                    @else
                        <td></td>
                    @endif
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td colspan="1"></td>
                    <td>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    </div>

@endsection

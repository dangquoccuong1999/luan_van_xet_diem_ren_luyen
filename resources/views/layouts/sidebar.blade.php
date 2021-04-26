<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ $ten }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menu</li>
            @if (Auth::user()->vaitro == 1)
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Khoa</span> <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('khoa.get_add') }}"><i class="fa fa-circle-o"></i> Thêm </a></li>
                        <li><a href="{{ route('khoa.get_danhsach') }}"><i class="fa fa-circle-o"></i> Danh sách </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Lớp</span> <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('lop.get_add') }}"><i class="fa fa-circle-o"></i> Thêm </a></li>
                        <li><a href="{{ route('lop.get_danhsach') }}"><i class="fa fa-circle-o"></i> Danh sách </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Giảng viên</span> <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('giangvien.get_add') }}"><i class="fa fa-circle-o"></i> Thêm </a></li>
                        <li><a href="{{ route('giangvien.get_danhsach') }}"><i class="fa fa-circle-o"></i> Danh sách
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Quản lý tiêu chuẩn</span> <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('tieuchuan.get_add_tieuchuan') }}"><i class="fa fa-circle-o"></i> Thêm
                            </a></li>
                        <li><a href="{{ route('tieuchuan.get_danhsach') }}"><i class="fa fa-circle-o"></i> Danh sách
                            </a></li>

                    </ul>
                </li>


                <li class="treeview">
                    <a href="">
                        <i class="fa fa-table"></i> <span>Quản lý tiêu chí</span> <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('tieuchi.get_add') }}"><i class="fa fa-circle-o"></i> Thêm </a></li>
                        <li><a href="{{ route('tieuchi.get_danhsach') }}"><i class="fa fa-circle-o"></i> Danh sách </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Quản lý chi tiết tiêu chí</span> <span
                            class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('chitiettieuchi.get_add') }}"><i class="fa fa-circle-o"></i> Thêm </a>
                        </li>
                        <li><a href="{{ route('chitiettieuchi.get_danhsach') }}"><i class="fa fa-circle-o"></i> Danh
                                sách </a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Quản lý vi phạm</span> <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('vipham.get_add') }}"><i class="fa fa-circle-o"></i> Thêm </a></li>
                        <li><a href="{{ route('vipham.get_danhsach') }}"><i class="fa fa-circle-o"></i> Danh sách </a>
                        </li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-table"></i> <span>Học kì</span> <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('hocki.get_add') }}"><i class="fa fa-circle-o"></i> Thêm </a></li>
                        <li><a href="{{ route('hocki.get_danhsach') }}"><i class="fa fa-circle-o"></i> Danh sách </a>
                        </li>
                    </ul>
                </li>

            @elseif (Auth::user()->vaitro == 3)
                <li class="">
                    <a href="{{ route('lop.get_danhsach') }}">
                        <i class="fa fa-table"></i> <span>Đánh giá điểm lớp chủ nhiệm</span>
                    </a>

                </li>


            @elseif (Auth::user()->vaitro == 5)
                <li class="">
                    <?php
                    $id_user = Auth::user()->id;
                    $id_lop = DB::select("SELECT sinhviens.lop_id FROM `sinhviens` WHERE user_id = $id_user");
                    ?>
                    <a href="{{ route('sinhvien.get_danhsachloptruongchamdiem', $id_lop[0]->lop_id) }}">
                        <i class="fa fa-table"></i> <span>Cán bộ lớp chấm</span>
                    </a>
                </li>
            @elseif (Auth::user()->vaitro == 2)
                <li class="">
                    <a href="{{ route('lop.get_danhsach') }}">
                        <i class="fa fa-table"></i> <span>Tông hợp kết quả đánh giá</span>
                    </a>
                </li>
            @elseif (Auth::user()->vaitro == 4)
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-angle-left pull-right"></i> <span>Sinh viên chấm điểm</span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('sinhvien.get_tuchamdiem', Auth::user()->id) }}"><i
                                    class="fa fa-circle-o"></i> Chấm điểm </a>
                        </li>                     
                    </ul>
                </li>

                <?php
                $id_user = Auth::user()->id;
                $id_lop = DB::select("SELECT sinhviens.lop_id FROM `sinhviens` WHERE user_id = $id_user");
                ?>
                
                <li class="treeview">
                    <a href="">
                        <i class="fa fa-angle-left pull-right"></i> <span>Danh sách sinh viên</span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{ route('sinhvien.get_danhsachloptruongchamdiem',  $id_lop[0]->lop_id) }}"><i
                                    class="fa fa-circle-o"></i> Xem điểm </a>
                        </li>
                    </ul>
                </li>

            @endif
            {{-- <li class="treeview">
                           <a href="#">
                               <i class="fa fa-table"></i> <span>Thống kê</span>
                           </a>

                        </li> --}}
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

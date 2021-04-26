@include('layouts.head')

<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

{{--    header--}}

@include('layouts.header')
<!-- =============================================== -->

    <!-- Left side column. contains the sidebar -->

@include('layouts.sidebar')
<!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">@yield('title-page')</h3>

                </div>
                <div class="box-body">
                    @yield('content')
                </div>
                <!-- /.box-body -->

            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@include('layouts.footer')
@yield('script')
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('admin/css/rtl.css')}}" rel="stylesheet">

    <!-- FavIcon -->
    <link href="{{asset('img/logo.jpg')}}" rel="shortcut icon"/>

    {{--Scroll css--}}
    <link rel="stylesheet" href="{{asset('css/scroller.css')}}">

</head>

<body>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    {{--    <div style="position:fixed; z-index:999; bottom:0; top: 0; overflow:auto;">--}}
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="sidebar-brand-text mx-3">البركة</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{Request::is('dashboard') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('admin.dashboard')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>لوحة المدير</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            تعاملات
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-users"></i>
                <span>العاملين</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">عن العاملين :</h6>
                    <a class="collapse-item" href="{{route('register')}}">اضافة عاملين</a>
                    <a class="collapse-item" href="cards.html">دفع مرتبات عاملين</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-apple-alt"></i>
                <span>المنتجات</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            التقارير
        </div>

        <!-- Nav Item -->
        <li class="nav-item {{Request::is('dashboard/general-report') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('general.report')}}">
                <i class="fas fa-file-alt"></i>
                <span>تقرير شامل</span></a>
        </li>

        <li class="nav-item {{Request::is('dashboard/sells-report') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('sells.report')}}">
                <i class="fas fa-file-alt"></i>
                <span>تقرير المبيعات</span></a>
        </li>

        <li class="nav-item {{Request::is('dashboard/expenses-report') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('expenses.report')}}">
                <i class="fas fa-file-alt"></i>
                <span>تقرير المصاريف</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-file-alt"></i>
                <span>تقرير دخول العاملين</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
{{--    </div>--}}
<!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 {{--fixed-top--}} shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul id="page-top" class="navbar-nav ml-auto">

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            {{--<div class="dropdown-divider"></div>--}}
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('تسجيل خروج') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->
            <div id="admin-content" style="height: 30em !important;">
            @yield('admin-content')
            <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                    <span>Copyright &copy; <a target="_blank"
                                              href="https://mrtechnawy.com/business">By Mr Technawy</a> {{now()->year}}</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

@if (!Request::is('dashboard'))
    <!-- Scroll to Top Button-->
    <a class="scroll-to-down rounded" href="#bottom">
        <i class="fas fa-angle-down"></i>
    </a>
@endif
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('admin/js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{asset('admin/vendor/chart.js/Chart.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('admin/js/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('admin/js/demo/chart-pie-demo.js')}}"></script>

<script>
    /*go down*/
    100 > $(this).scrollTop() ? $(".scroll-to-down").fadeIn() : $(".scroll-to-down").fadeOut();
    $('*').scroll(function () {
        100 > $(this).scrollTop() ? $(".scroll-to-down").fadeIn() : $(".scroll-to-down").fadeOut();
        100 < $(this).scrollTop() ? $(".scroll-to-top").fadeIn() : $(".scroll-to-top").fadeOut();
    });
    $('.scroll-to-top').click(function () {
        $("*").animate({scrollTop: 0}, "slow");
    });
    $('.scroll-to-down').click(function () {
        $("*").animate({scrollTop: $(".container-fluid").height()}, "slow");
    });
</script>
@stack('bottom-script')
</body>

</html>

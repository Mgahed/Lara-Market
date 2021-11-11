<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('datalist/dataList.js')}}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/fontawsome4.min.css')}}">

    <!-- FavIcon -->
    <link href="{{asset('img/logo.jpg')}}" rel="shortcut icon"/>

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('datalist/dataList.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/bell.css')}}">
    @stack('style')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container" style="max-width: 100%">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="rounded-circle" width="50px" src="{{asset('img/logo.jpg')}}" alt="Logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @if (auth()->user())
                        <li class="nav-item">
                            <a class="nav-link {{Request::is('home') ? 'active' : ''}} {{Request::is('sell/*') ? 'active' : ''}}"
                               {{-- request()->routeIs('home') --}}
                               href="{{ route('login') }}">{{ __('الرئيسية') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{Request::is('products') ? 'active' : ''}} {{Request::is('products/*') ? 'active' : ''}}"
                               href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                المنتجات
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{route('all.products')}}">عرض المنتجات</a>
                                <a class="dropdown-item" href="{{route('add.products.view')}}">اضافة منتج</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{Request::is('order/*') ? 'active' : ''}}"
                               {{-- request()->routeIs('home') --}}
                               href="{{ route('all.orders') }}">{{ __('عمليات البيع') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{Request::is('debt/*') ? 'active' : ''}}"
                               {{-- request()->routeIs('home') --}}
                               href="{{ route('all.debts') }}">{{ __('الديون') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{Request::is('company') ? 'active' : ''}} {{Request::is('company/*') ? 'active' : ''}}"
                               href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                الموزعين
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{route('all.companies')}}">عرض الموزعين</a>
                                <a class="dropdown-item" href="{{route('add.companies.view')}}">اضافة موزع</a>
                            </div>
                        </li>
                    @endif
                </ul>

                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('تسجيل الدخول') }}</a>
                            </li>
                        @endif

                        {{--                        @if (Route::has('register'))--}}
                        {{--                            <li class="nav-item">--}}
                        {{--                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
                        {{--                            </li>--}}
                        {{--                        @endif--}}
                    @else
                        <?php
                        $product_less_5 = DB::table('products')
                            ->where('quantity', '<=', 5)
                            ->get();
                        ?>
                        @if ($product_less_5->count())
                            <li class="nav-item">
                                <a href="{{route('will.finish')}}" class="nav-link" data-toggle="tooltip" data-placement="bottom"
                                   title="يوجد {{$product_less_5->count()}} منتج قارب على الانتهاء">
                                    <i class='bell fa fa-bell'></i>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->role == 'admin')
                                    <a class="dropdown-item"
                                       href="{{ route('admin.dashboard') }}">{{ __('صفحة المدير') }}</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('تسجيل خروج') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white" style="padding: 2rem 0; flex-shrink: 0;">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                    <span>Copyright &copy; <a target="_blank"
                                              href="https://mrtechnawy.com/business">By Mr Technawy</a> {{now()->year}}</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->
</div>
@stack('bottom-script')
</body>
</html>

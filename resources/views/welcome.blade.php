<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>البركة</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
    <meta name="author" content="Vincent Garreau"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="{{asset('css/welcome.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- js -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .container {
            width: 60%;
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        @media screen and (max-width: 450px) {
            .container {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<!-- particles.js container -->
<div id="particles-js" style="position: relative;">
    <div class="container">
        <div class="card" style="background-color: rgb(225,225,225,0.2);">
            <div class="card-body">
                <center>
                    <img src="{{asset('img/logo.jpg')}}" style="width: 50%; border-radius: 15px;" alt="logo" class="img-responsive">
                </center>
            </div>
            <div class="card-footer">
                <center>
                    <a href="{{route('home')}}" class="btn btn-primary">اذهب للصفحة الرئيسئة</a>
                </center>
            </div>
        </div>
    </div>
</div>
<center>

</center>

<!-- scripts -->
<script src="{{asset('js/particles.js')}}"></script>
<script src="{{asset('js/welcome.js')}}"></script>

<!-- stats.js -->
<script src="{{asset('js/lib/stats.js')}}"></script>

</body>
</html>

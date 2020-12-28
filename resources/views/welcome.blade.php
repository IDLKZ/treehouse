<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/front/favicon.ico" type="image/x-icon">
    <title>Welcome | Aquaponic House</title>
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="/css/front.css">
    <style>
        #map {
            width: 100%;
            height: calc(100vh * 0.8);
        }
    </style>
    @stack('styles')
</head>
<body>
<!-- Page loader -->
<div id="preloader"></div>
@include('front.header')
@yield('content')
@include('front.footer')
<!-- jquery main JS -->
<script src="/js/front.js"></script>
@stack('scripts')
</body>
</html>

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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">     <style>
        body {
            font-family: 'Roboto', sans-serif!important;
        }
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

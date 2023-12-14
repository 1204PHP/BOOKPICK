<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/common.js') }}" defer></script>
    <title>@yield('title', 'bookpick')</title>
</head>
<body class="body">
    @include('layout.sidebar')
    @yield('content')
</body>
</html>
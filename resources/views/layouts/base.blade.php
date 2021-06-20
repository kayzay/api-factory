<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$titleName ?? "API - test"}}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset("css/bootstrap.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("css/datatables.min.css") }}"/>

    <script type="text/javascript" language="javascript" src=" {{ asset("js/lib/jquery-3.5.1.js") }}"></script>
    <script type="text/javascript" src="{{ asset("js/lib/bootstrap.bundle.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("js/lib/datatables.min.js") }}"></script>
    @yield('elem_container')
</head>
<body>
<header class="d-flex justify-content-center py-3">
    <ul class="nav nav-pills">
        <li class="nav-item"><a href="/" class="nav-link">Главная</a></li>
        <li class="nav-item">  <a href="{{route('workers')}}" class="nav-link">Работники</a> </li>
        <li class="nav-item"> <a href="{{route('machines')}}" class="nav-link">Станки</a> </li>
    </ul>
</header>
<main class="container">
    @yield('content')
</main>
<div
    class="spinner-border" role="status"
    style="position: absolute; top: calc(50% - 28px);left: calc(50% - 28px);visibility: hidden">
    <span class="sr-only"></span>
</div>
</body>
</html>

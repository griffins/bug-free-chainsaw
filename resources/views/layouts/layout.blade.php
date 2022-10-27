<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> {{ config('app.name') }}</title>
    @yield('css_before')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="https://cdn.jsdelivr.net/npm/tabler@1.0.0-alpha.8/dist/css/tabler.css">
    @yield('css_after')
    @stack('css')
</head>
<body id="page-top" class="antialiased">
<div class="page">
    @yield('body')
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tabler@1.0.0-alpha.8/dist/js/tabler.min.js"></script>
@stack('js')
@yield('js_after')
</body>
</html>

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
    <link rel="stylesheet" href="https://preview.tabler.io/dist/css/tabler.min.css">
    <link rel="stylesheet" href="https://preview.tabler.io/dist/css/tabler-vendors.min.css">
    @yield('css_after')
    @stack('css')
    <script>
        function toggleTheme(theme){
            const value =`theme-${theme}`
            localStorage.setItem('theme', value)
            setTheme(value)
        }

        function setTheme(theme){
            let classes =  document.getElementsByTagName('body')[0].classList
            classes.remove('theme-light')
            classes.remove('theme-dark')
            classes.add(theme)
        }
    </script>
</head>
<body class="antialiased layout-fluid">
<div class="page">
    @yield('body')
</div>
<script>
    setTheme(localStorage.getItem('theme','theme-light'))
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://preview.tabler.io/dist/js/tabler.min.js"></script>
<script src="https://preview.tabler.io/dist/libs/litepicker/dist/litepicker.js"></script>
@stack('js')
@yield('js_after')
</body>
</html>

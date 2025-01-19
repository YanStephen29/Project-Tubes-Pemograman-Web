<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">
    <link rel="stylesheet" href="{{ asset('css/registform.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body class="bg-white flex justify-center items-center h-screen">
    <div class="circle orange"></div>
    <div class="circle cream-bottom"></div>
    <div class="circle cream-top"></div>
    <div class="circle orange-top"></div>
    <div class="circle white-top"></div>
    <div class="circle cream-righttop"></div>
    <div class="circle orange-right"></div>
    <div class="circle orange-bottom-left"></div>
    <div class="circle white-bottom"></div>
    @yield('content')
    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2/dist/js/select2.min.js"></script>
</body>
</html>

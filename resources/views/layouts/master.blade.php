<!DOCTYPE html>
<html lang="hu">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>php rts játék</title>
    <link href="{{ asset('css/bootstrap.min.css')
}}" rel="stylesheet">
</head>
<body>
@yield('navbar')
<div class="container">
    <div class="page-header">
        @yield('header')
    </div>
    <div class="row">
        @yield('content')
    </div>
</div>
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
</body>
</html>
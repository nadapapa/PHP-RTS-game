<!DOCTYPE html>
<html lang="hu">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>php rts játék</title>
    <link href="{{ asset('css/bootstrap.min.css')
}}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css')
}}" rel="stylesheet">
    <script src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>

</head>
<body>
@yield('navbar')
<div class="container">

    <div class="page-header">
        @yield('header')
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger fade in" role="alert">
                    {{ $error }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endforeach
        @endif

        @if (Session::has('status'))
            <div class="alert alert-info fade in" role="alert">{{ Session::get('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
</div>
        @yield('content')
    </div>
    <hr>
    <footer class="bs-docs-footer" role="contentinfo">
        <div class="container text-center">
            <p><br>
                <a href="https://github.com/nadapapa/PHP-RTS-game">GitHub <i class="fa fa-github fa-2x"></i>
                </a>
                <br>
            </p>
            </div>
        </footer>
</div>



</body>
</html>
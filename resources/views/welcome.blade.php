<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="_token" content="{{ csrf_token() }}"/>
        <title>php rts játék</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                padding-top : 70px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="title">Laravel 5</div>
                        hello
                        @if (Auth::check())
                            {{Auth::user()->name}}
                        @else
                            vendég!
                        @endif

                        <br><br>

                        <a href="/auth/login">bejelentkezés</a><br>
                        <a href="/auth/register">regisztráció</a><br>
                        <a href="/password/email">elfelejtett jelszó</a><br>
                    <br>
                        Bejelentkezés közösségi szolgáltatással<br>

                        <a class="btn btn-primary" href="{{ route('social.login', ['facebook']) }}">Facebook</a>
                        <a class="btn btn-primary" href="{{ route('social.login', ['google']) }}">Google</a>
                    </div>
                </div>
            </div>

        <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    </body>
</html>

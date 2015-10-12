<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>


    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>
                
                hello 
                @if (Auth::check())
                  {{Auth::user()->name}}
                @else
                  guest
                @endif
                  
                  <br><br>
                
                <a href="/auth/login">bejelentkezés</a><br>
                <a href="/auth/register">regisztráció</a><br>
                <a href="/auth/logout">kijelentkezés</a><br>

            </div>
        </div>
    </body>
</html>

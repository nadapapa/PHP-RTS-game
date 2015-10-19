
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


            <a href="/">főoldal</a><br>

            <h1>Hello {{$name}}</h1>

{{$city}}




<br>

            <a href="/auth/logout">kijelentkezés</a><br>


        </div>
    </div>
</div>
</body>
</html>
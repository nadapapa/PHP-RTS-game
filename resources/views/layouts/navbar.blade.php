
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Navigáció</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Főoldal</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/home">Profil</a>
                    </li>
                    <li>
                        <?php
                        if (isset($city)) {
                            $coord = "x" . $city->hex->x . "y" . $city->hex->y;
                        } else {
                            $coord = "x2y2";
                        }
                        ?>
                        <a href="/map/{{$coord}}">Térkép</a>
                    </li>

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/auth/logout">Kijelentkezés</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

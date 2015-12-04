@extends('layouts.master')
@section('head')
    <link href="{{ asset('css/help.css')
}}" rel="stylesheet">
@stop

@section('navbar')
    @include('partials.navbar')
@stop
@section('header')
    <div class="clearfix">
        <h1 class="pull-left">
            Segítség <br>
            <small>A térkép használata</small>
        </h1>
    </div>
@stop

@section('content')
    <div class="col-md-8 col-md-offset-1">
        <section id="hexagonok" class="group">
            <h2>Hexagonok</h2>

            <div id="hex_types" class="subgroup">
                <h4>Hexagonok típusai</h4>

                <p class="lead">
                    A térkép 11 féle hatszögből (hexagonok, röviden hex) áll.
                    A hexagon típusa befolyásolja, hogy egy hadsereg milyen gyorsan tud áthaladni rajta.
                </p>
                Az alábbi táblázat összefoglalja, hogy melyik hexagon milyen arányban lassítja a seregeket.
                <table class="table table-hover">
                    <tr>
                        <th>#</th>
                        <th>Hex</th>
                        <th>Típus</th>
                        <th>Lassítási szorzó</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/water/ocean-tile.png">
                        </td>
                        <td>mély víz</td>
                        <td>10</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/sand/beach.png">
                        </td>
                        <td>homokos part</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/grass/green.png">
                        </td>
                        <td>füves rét</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/forest/pine-tile.png">
                        </td>
                        <td>fenyőerdő</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/frozen/snow.png">
                        </td>
                        <td>hómező</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/hills/regular.png">
                        </td>
                        <td>dombvidék</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/hills/snow.png">
                        </td>
                        <td>havas dombok</td>
                        <td>3</td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/mountains/basic-tile.png">
                        </td>
                        <td>hegy</td>
                        <td>6</td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/water/coast-tile.png">
                        </td>
                        <td>sekély víz</td>
                        <td>6</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/frozen/ice.png">
                        </td>
                        <td>jég</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td>
                            <img src="https://raw.github.com/wesnoth/wesnoth/master/data/core/images/terrain/swamp/water-tile.png">
                        </td>
                        <td>mocsár</td>
                        <td>6</td>
                    </tr>
                </table>

                <p>
                    Tehát, ha egy hadsereg alapból <b>1 perc</b> alatt tesz meg egy hexet,
                    akkor egy <b>homokos part</b> típúsú hexen <b>2 perc</b> alatt ér át.
                    Ugyanennek a hadseregnek az átkelés egy mocsáron 6 perc, míg egy füves
                    réten egyáltalán nem lassul. (Egy hadsereg sebessége egyenlő a leglassabb
                    egységének a sebességével)
                </p>
            </div>

            <br>

            <div id="hex_info" class="subgroup">
                <h4>Információk egy hexagonról</h4>

                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="/img/help/map/infobox.jpg" alt="infobox">
                    </div>
                    <div class="media-body">
                        <p>
                            A térképen megtudhatod egy hexagon koordinátáit és típusát, ha rákattintasz.
                            Ilyenkor egy arany színű keret jelzi a kijelölt hexagont és a jobb felső sarokban
                            megjelennek az információk
                        </p>
                    </div>
                </div>
            </div>

        </section>


        <hr>
        <br>
        <section id="varos" class="group">
            <h2>Városok</h2>

            <div class="media">
                <div class="media-left">
                    <img class="media-object" src="/img/map/tiles/city.png" alt="city">
                </div>
                <div class="media-body">
                    <p>
                        Ez az ikon jelöli a városokat a térképen. Ha rákattintasz egy városra,
                        információkat tudhatsz meg róla. A város koordinátáit, tulajdonosának nevét
                        és azt, hogy melyik néphez tartozik.
                    </p>
                </div>
            </div>
            <div class="media">
                <div class="media-body">
                    <p>
                        Ha egy városban hadsereg van elszállásolva, akkor azt egy hadsereg ikon jelképezi.
                    </p>
                </div>
                <div class="media-right">
                    <img class="media-object" src="/img/help/map/city_army.jpg" alt="city">
                </div>
            </div>
        </section>


        <hr>
        <br>
        <section id="sereg" class="group">
            <h3>Hadseregek</h3>

            <div class="media">
                <div class="media-left">
                    <img class="media-object" src="/img/map/tiles/army.png" alt="city">
                </div>
                <div class="media-body">
                    <p>
                        Ez az ikon jelöli a hadseregeket a térképen. Ha rákattintasz egy hadseregre,
                        információkat tudhatsz meg róla és arról a hexről, amin éppen áll. Ha egy városban
                        van, akkor a városra jellemző információk jelennek meg.
                    </p>
                </div>
            </div>
            <p>
                Az, hogy mennyi információt tudhatsz meg egy hadseregről, attól függ, hogy a sereg a tiéd-e vagy másé.
                Ha másé, akkor csak a tulajdonos nevét és népét tudhatod meg. Ha a sereg a tiéd, akkor megtudhatod az
                összetételét is, tehát hogy milyen egységekből áll.
            </p>
            <br>

            <div id="sereg_mozgas" class="subgroup">
                <h4>Hadseregek mozgatása</h4>

                <div class="media">
                    <div class="media-body">
                        <p>
                            Csak a saját hadseregeidet tudod mozgatni és azok közül is csak azokat,
                            amik éppen nem hajtanak végre semmilyen feladatot (pl. mozgás, csata, ostrom).
                            Ha egy sereget mozgathatsz, azt onnan is tudhatod, hogy ha rákattintasz
                            megjelenik a "sereg áthelyezése" feliratú zöld gomb. A mozgatási folyamat
                            megkezdéséhez kattints erre a gombra.
                        </p>
                    </div>
                    <div class="media-right">
                        <img class="media-object" src="/img/help/map/army_move_popup.jpg" alt="city">
                    </div>
                </div>

                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="/img/help/map/army_move_popup2.jpg" alt="city">
                    </div>
                    <div class="media-body">
                        <p>
                            Ha rákattintottál a "sereg áthelyezése" feliratú zöld gombra, azzal kijelölted
                            a sereget a mozgatásra. Ezt a kijelölést bármikor visszavonhatod, úgy hogy újra
                            rákattintasz a seregre és a "kijelölés visszavonása" feliratú piros gombot választod.
                        </p>
                    </div>

                </div>

                <div class="media">
                    <div class="media-body">
                        <p>
                            Miután kijelölted az egyik seregedet, kattints egy tetszőleges hexre és megjelenik a
                            "pont hozzáadása az útvonalhoz" feliratú gomb.
                        </p>
                    </div>
                    <div class="media-right">
                        <img class="media-object" src="/img/help/map/army_move_popup3.jpg" alt="city">
                    </div>
                </div>

                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="/img/help/map/army_move_popup4.jpg" alt="city"><br>

                        <p>
                            Amikor végeztél az útvonal megtervezésével, kattints a "mehet" feliratú zöld gombra (az
                            információs menüt előhívhatod azzal is, ha rákattintasz bármelyik zöld hexre). A térkép
                            frissítése után, ha ugyanerre a hadseregre kattintasz, akkor a visszaszámlálás fog látszani,
                            ami az út megételéig hátralevő időt mutatja.<br><img class="media-object"
                                                                                 src="/img/help/map/army_move_popup5.jpg">
                        </p>
                    </div>
                    <div class="media-body">
                        <p>
                            Ezután megjelenik az egyenes útvonal a hadseereg jelenlegi helyzete és a kijelölt hex
                            között, illetve egy kis ablak az információkkal.
                            A fenti lépés megismétlésével újabb zöld hexeket adhatsz az útvonalhoz, a 'pont törlése'
                            gombbal pedig törölhetsz.
                            Az útvonal tervezésekor a zöld hexeket mozgathatod a térképen, az útvonal követni fogja a
                            pozíciójukat.
                            Tehát zöld hexek hozzáadásával és mozgatásával bármilyen útvonalat megtervezhetsz. Bármennyi
                            zöld hexet felhasználhatsz a tervezéskor, és ezek sehogy sem befolyásolják a sereg
                            sebességét.<br>
                            <img class="media-object" src="/img/help/map/army_path.jpg"><br>
                        </p>
                    </div>

                </div>


            </div>
        </section>

    </div>

    <nav class="col-md-2 bs-docs-sidebar">
        <ul id="sidebar" class="nav nav-stacked fixed">
            <li>
                <a href="#hexagonok">Hexagonok</a>
                <ul class="nav nav-stacked">
                    <li><a href="#hex_types">Hexagonok típusai</a></li>
                    <li><a href="#hex_info">Információk egy hexagonról</a></li>
                </ul>
            </li>
            <li>
                <a href="#varos">Városok</a>

            </li>
            <li>
                <a href="#sereg">Hadseregek</a>
                <ul class="nav nav-stacked">
                    <li><a href="#sereg_mozgas">Hadseregek mozgatása</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <script>
        $('body').scrollspy({
            target: '.bs-docs-sidebar',
            offset: 40
        });
    </script>
@stop


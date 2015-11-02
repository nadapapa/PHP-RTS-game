@extends('layouts.master')

@section('navbar')
    @include('layouts.navbar')
@stop
@section('header')
    <div class="clearfix">
        <h1 class="pull-left">
            <a href="/city/{{$city->id}}">
                {{$city->name}}
            </a>
        </h1>

        @include('layouts.resources')

    </div>
@stop
@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>
                    <p>{{App\Building::$building_names[$building->nation][$building->type]}}</p>
                </b>
            </div>

            <div class="panel-body">
                <form method="POST" action="{{Request::url()}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    {{App\Building::$building_description[$building->nation][$building->type]}}
                    <hr>
                    <p>A termelő épületek hozama = (épület szintje &times; épületben dolgozó munkások száma) % az épület
                        épsége </p>

                    <p>Fejlesztés ára = épület alapára &times; következő szint</p>

                    <p>Fejlesztés ideje = (épület építésének ideje &times; következő szint) &divide; épületben dolgozó
                        munkások száma</p>
                    <hr>

                    @if($building->type < 5)
                        <p>Hozam: {{($building->level * $building->workers) * ($building->health / 100)}}/óra</p>
                    @endif

                    <p @if($building->workers == 0)
                       class="bg-warning"
                            @endif> Munkások: <input placeholder="{{$building->workers}}" type="number" name="workers"
                                                     min="0" max="{{$building->level * 10}}"> fő
                        <button class="btn btn-info btn-xs" type="submit">Beállít</button>
                    </p>
                </form>

                <p>Szint: {{$building->level}}.

                    @if ($building->workers > 0)
                        <a href="{{Request::url()}}/levelup" class="btn btn-info btn-xs">Fejlesztés
                            a {{$building->level + 1}}. szintre</a> ára:
                        Élelmiszer: {{App\Building::$building_prices[$building->nation][$building->type]['food'] * ($building->level + 1)}}
                        ,

                        Vas: {{App\Building::$building_prices[$building->nation][$building->type]['iron'] * ($building->level + 1)}}
                        ,

                        Fa: {{App\Building::$building_prices[$building->nation][$building->type]['lumber'] * ($building->level + 1)}}
                        ,

                        Kő: {{App\Building::$building_prices[$building->nation][$building->type]['stone'] * ($building->level + 1)}}

                        Idő: {{(App\Building::$building_times[$building->nation][$building->type] * ($building->level + 1)) / $building->workers}}
                        másodperc
                    @endif
                </p>

                <p>Épség: {{$building->health}}%
                @if ($building->health < 100 && $building->workers > 0)
                    <form method="POST" action="{{Request::url()}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="number" name="health" min="0" max="{{100- $building->health}}">
                        <button class="btn btn-info btn-xs" type="submit">Javítás</button>
                        Ár: minden nyersanyag: százalékonként 1, Idő: százalékonként 1 másodperc
                    </form>
                @endif

                {{--barakk--}}
                @if($building->type == 5)
                    <hr>
                    <button class="btn btn-info btn-xs" type="submit">Katona képzése</button>
                @endif

                {{--fórum--}}
                @if($building->type == 7)
                    <hr>
                    <a href="{{Request::url()}}/worker" class="btn btn-info btn-xs">Munkás képzése</a>
                @endif

                <hr>
                <div class="text-right">
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">
                        Épület megsemmisítése
                    </button>

                </div>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Épület megsemmisítése</h4>
                            </div>
                            <div class="modal-body">
                                Biztos, hogy törölni akarod ezt az
                                épületet: {{App\Building::$building_names[$building->nation][$building->type]}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Nem</button>
                                <a href="{{Request::url()}}/delete" type="button" class="btn btn-danger">Igen</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
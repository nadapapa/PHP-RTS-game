@extends('layouts.master')
<?php
use Carbon\Carbon;
$now = Carbon::now();

?>
@section('navbar')
    @include('partials.navbar')
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
                    Fal
                </b>
            </div>

            <div class="panel-body">
                <p>
                    Védelem: {{$wall->level * 10}}
                </p>

                <p>Szint: {{$wall->level}}.

                    <a href="{{Request::url()}}/levelup" class="btn btn-info btn-xs">Fejlesztés
                        a {{$wall->level + 1}}. szintre</a> ára:
                    <b>Élelmiszer:</b> {{App\Building::$building_prices[$wall->nation][$wall->type]['food'] * ($wall->level + 1)}}
                    ,

                    <b>Vas:</b> {{App\Building::$building_prices[$wall->nation][$wall->type]['iron'] * ($wall->level + 1)}}
                    ,

                    <b>Fa:</b> {{App\Building::$building_prices[$wall->nation][$wall->type]['lumber'] * ($wall->level + 1)}}
                    ,

                    <b>Kő:</b> {{App\Building::$building_prices[$wall->nation][$wall->type]['stone'] * ($wall->level + 1)}}

                    <b>Idő:</b> {{(App\Building::$building_times[$wall->nation][$wall->type] * ($wall->level + 1))}}
                    másodperc

                </p>

                <p><b>Épség:</b> {{$wall->health}}%
                @if ($wall->health < 100)
                    <form method="POST" action="{{Request::url()}}/heal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="number" name="health" min="0" max="{{100- $wall->health}}">
                        <button class="btn btn-info btn-xs" type="submit">Javítás</button>
                        Ár: minden nyersanyag: százalékonként 1, Idő: százalékonként 1 másodperc
                    </form>
                @endif

            </div>
        </div>
    </div>
    @if($wall->task)
        <script src="{{asset('js/jquery.countdown.min.js')}}"></script>

        <script type="text/javascript">
            $('[data-countdown]').each(function () {
                var $this = $(this), finalDate = $(this).data('countdown');
                $this.countdown(finalDate, function (event) {
                    $this.html(event.strftime('%H:%M:%S'));
                })
                        .on('finish.countdown', function (event) {
                            $(this).parent().removeClass('disabled');
                            $(this).remove();
                            location.reload(true);
                        })
            });
        </script>
    @endif

@stop
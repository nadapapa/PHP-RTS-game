@extends('layouts.master')

@section('navbar')
    <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
    @include('layouts.navbar')
@stop
@section('header')
    <div class="clearfix">
        <h1 class="pull-left">
            {{$city->name}} <br>
            <small>szint: {{$city->level}}</small>
        </h1>

        <div class="panel panel-default pull-right">
            <div class="panel-heading text-center">
                <b>
                    Nyersanyagok
                </b>
            </div>

            <table class="panel-body table">
                <tr>
                    <td><b>Népesség:</b> {{$city->resources->population}}</td>
                    <td><b>Munkások:</b> {{$city->resources->workers}}</td>
                    <td><b>Élelmiszer:</b> {{$city->resources->food}}</td>
                    <td><b>Vas:</b> {{$city->resources->iron}}</td>
                    <td><b>Fa:</b> {{$city->resources->lumber}}</td>
                    <td><b>Kő:</b> {{$city->resources->stone}}</td>
                </tr>
            </table>

        </div>
    </div>
@stop

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>
                    Épületek
                </b>
            </div>
            <div class="panel-body">
                <?php
                use Carbon\Carbon;
                $i = 1;
                $now = Carbon::now();
                ?>
                @foreach ($building_slot as $value)

                    <div class="col-md-2">
                        <div>
                            @if($value > 0)
                                <?php
                                $building = $buildings->find($value);
                                ?>
                                @if($building->finished_at->gte($now))
                                    <div>
                                        <a href="/city/{{$city->id}}/building/{{$i}}"
                                           class="btn btn-primary disabled">{{App\Building::$building_names[$city->nation][$building->type]}}
                                            <br>
                                            <span data-countdown="{{$building->finished_at->format('Y/m/d/ H:i:s')}}"></span></a>

                                    </div>
                                @else
                                    <a href="/city/{{$city->id}}/building/{{$i}}"
                                       class="btn btn-primary">{{App\Building::$building_names[$city->nation][$building->type]}}
                                        ({{$building->level}})</a>
                                @endif

                            @else
                                <a href="/city/{{$city->id}}/build/{{$i}}" class="btn btn-primary">Építési
                                    hely {{$i}}</a>
                            @endif

                        </div>
                    </div>
                    <?php
                    $i++;
                    ?>
                @endforeach
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>
                    Hadsereg
                </b>
            </div>
            <div class="panel-body">

            </div>
        </div>
    </div>

    @if(isset($building))
        <script type="text/javascript">
            $('[data-countdown]').each(function () {
                var $this = $(this), finalDate = $(this).data('countdown');
                $this.countdown(finalDate, function (event) {
                    $this.html(event.strftime('%H:%M:%S'));
                })
                        .on('finish.countdown', function (event) {
                            $(this).parent().removeClass('disabled');
                            $(this).remove();
                        })
            });
        </script>
    @endif
@endsection
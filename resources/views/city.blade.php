@extends('layouts.master')

@section('navbar')
    <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
    @include('partials.navbar')
@stop
@section('header')
    <div class="clearfix">
        <h1 class="pull-left">
            {{$city->name}} <br>

        </h1>

        @include('layouts.resources')
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
            <div class="panel-body building-panel">
                <div class="row building-row">
                    <div class="col-md-10 col-md-offset-1">
                        <a href="/city/{{$city->id}}/wall" class="btn btn-primary btn-wall">Fal ({{$wall->level}})</a>
                    </div>
                </div>

            <?php
                use Carbon\Carbon;
                $i = 0;
                $now = Carbon::now();
                ?>
                @foreach ($building_slot as $value)

                    @if($i%5 == 0)
                        <div class="row building-row">
                            <div class="col-md-1">

                            </div>
                            @endif

                            <?php
                            $i++;
                            ?>
                            <div class="col-md-2 col-sm-2">
                                <div>
                                    @if($value > 0)
                                        <?php
                                        $building = $buildings->find($value);
                                        ?>
                                        @if($building->finished_at->gte($now))
                                            <div>
                                                <a href="/city/{{$city->id}}/slot/{{$i}}/building/{{$building->id}}"
                                                   class="btn btn-primary btn-building disabled">{{App\Building::$building_names[$city->nation][$building->type]}}
                                                    ({{$building->level}})
                                                    <br>
                                                    <span data-countdown="{{$building->finished_at->format('Y/m/d/ H:i:s')}}"></span></a>

                                            </div>
                                        @else
                                            <a href="/city/{{$city->id}}/slot/{{$i}}/building/{{$building->id}}"
                                               class="btn btn-building  btn-primary">{{App\Building::$building_names[$city->nation][$building->type]}}
                                                ({{$building->level}})</a>
                                        @endif

                                    @else
                                        <a href="/city/{{$city->id}}/slot/{{$i}}" class="btn btn-primary btn-building">Építési
                                            hely {{$i}}</a>
                                    @endif

                                </div>
                            </div>
                            @if($i%5 == 0)
                        </div>
                    @endif
                @endforeach

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>
                    A városban tartózkodó hadsereg
                </b>
            </div>

            @if($city->hex->army_id > 0)
            <table class="panel-body table">
                <tr>
                    @foreach(App\Army::$unit_names[$city->nation] as $key => $name)
                        <?php
                            $unit = "unit" . $key;
                        ?>
                        <td>
                            <b>{{$name}}:</b> {{$city->hex->army->$unit}}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td>
                        <b>Tábornok: </b>
                    @if($city->hex->army->general)
                        Van
                    @else
                        Nincs
                    @endif
                    </td>
                    <td>
                        <b>Élelmiszer: </b>{{$city->hex->army->food}}
                    </td>
                </tr>
            </table>

            <div class="panel-body">
                <form method="POST" action="{{Request::url()}}/army_food">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="number" id="army_food" name="army_food" min="0" max="{{$city->resources->food}}">

                    <button type="submit" class="btn btn-success btn-sm">Élelmiszer a seregnek</button>

                </form>
                </div>
            @else
                <br>
                <p class="text-center"><b>Jelenleg nem tartózkodik hadsereg a városban</b></p>
                <br>
            @endif




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
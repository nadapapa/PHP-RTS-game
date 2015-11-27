@extends('layouts.master')

@section('navbar')
    <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
    @include('partials.navbar')
@stop
@section('header')
    <div class="clearfix">
        <h1 class="pull-left">
            {{$city->name}} <br>
            <small>szint: {{$city->level}}</small>
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
                                        <a href="/city/{{$city->id}}/slot/{{$i}}/building/{{$building->id}}"
                                           class="btn btn-primary disabled">{{App\Building::$building_names[$city->nation][$building->type]}}
                                            ({{$building->level}})
                                            <br>
                                            <span data-countdown="{{$building->finished_at->format('Y/m/d/ H:i:s')}}"></span></a>

                                    </div>
                                @else
                                        <a href="/city/{{$city->id}}/slot/{{$i}}/building/{{$building->id}}"
                                       class="btn btn-primary">{{App\Building::$building_names[$city->nation][$building->type]}}
                                        ({{$building->level}})</a>
                                @endif

                            @else
                                <a href="/city/{{$city->id}}/slot/{{$i}}" class="btn btn-primary">Építési
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

            <table class="panel-body table">
                <tr>

                    @if($city->hex->army_id > 0)
                        @foreach(App\Army::$unit_names[$city->nation] as $key => $name)
                            <?php
                            $unit = "unit" . $key;
                            ?>
                            <td><b>{{$name}}:</b> {{$city->hex->army->$unit}}</td>
                        @endforeach

                    @else
                        @foreach(App\Army::$unit_names[$city->nation] as $key => $name)
                            <td><b>{{$name}}:</b> 0</td>
                        @endforeach
                    @endif
                </tr>
            </table>


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
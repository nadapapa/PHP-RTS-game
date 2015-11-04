@extends('layouts.master')

@section('navbar')
    @include('layouts.navbar')
@stop
@section('header')
    <h1>
        <a href="/city/{{$city->id}}">
            {{$city->name}}
        </a>
        <small>Építés</small>
    </h1>
@stop
@section('content')
    <div class="col-md-8 col-md-offset-2">
        <form method="POST" action="/city/{{$city->id}}/slot/{{$slot_num}}/build">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @foreach(App\Building::$building_names[$city->nation] as $num => $name)
                <div class="panel panel-default">
                    <div class="panel-heading table">
                        <div class="radio-sm">
                            <label>
                                <input type="radio" name="type" id="{{$num}}" value="{{$num}}">
                                <b>
                                    {{$name}}
                                </b>
                            </label>
                        </div>

                    </div>
                    <div class="panel-body">
                        {{App\Building::$building_description[$city->nation][$num]}}
                    </div>

                    <table class="panel-footer table">
                        <tr>
                            <td><b>vas:</b>
                                {{App\Building::$building_prices[$city->nation][$num]['iron']}}</td>
                            <td><b>élelmiszer:</b> {{App\Building::$building_prices[$city->nation][$num]['food']}}</td>
                            <td><b>fa:</b> {{App\Building::$building_prices[$city->nation][$num]['lumber']}}</td>
                            <td><b>kő:</b> {{App\Building::$building_prices[$city->nation][$num]['stone']}}</td>
                            <td><b>idő:</b> {{App\Building::$building_times[$city->nation][$num]}}</td>
                        </tr>
                    </table>
                </div>
            @endforeach
            <button class="btn btn-info" type="submit">Épít</button>
        </form>
    </div>

@stop
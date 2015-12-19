@extends('layouts.master')

@section('navbar')
    @include('partials.navbar')
@stop
@section('header')
    <div class="clearfix">
        <h1>
            <a href="/city/{{$city->id}}">
                {{$city->name}}
            </a>
            <small>Építés</small>
        </h1>
        @include('layouts.resources')
    </div>

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
                            @if($city->resources->food >= App\Building::$building_prices[$city->nation][$num]['food'])
                                <td class="bg-success">
                            @else
                                <td class="bg-danger">
                                    @endif
                                    <b>élelmiszer:</b> {{App\Building::$building_prices[$city->nation][$num]['food']}}
                                </td>

                                @if($city->resources->iron >= App\Building::$building_prices[$city->nation][$num]['iron'])
                                    <td class="bg-success">
                                @else
                                    <td class="bg-danger">
                                        @endif
                                        <b>vas:</b>
                                        {{App\Building::$building_prices[$city->nation][$num]['iron']}}
                                    </td>

                                    @if($city->resources->lumber >= App\Building::$building_prices[$city->nation][$num]['lumber'])
                                        <td class="bg-success">
                                    @else
                                        <td class="bg-danger">
                                            @endif
                                            <b>fa:</b> {{App\Building::$building_prices[$city->nation][$num]['lumber']}}
                                        </td>

                                        @if($city->resources->lumber >= App\Building::$building_prices[$city->nation][$num]['food'])
                                            <td class="bg-success">
                                        @else
                                            <td class="bg-danger">
                                                @endif
                                                <b>kő:</b> {{App\Building::$building_prices[$city->nation][$num]['stone']}}
                                            </td>

                                            <td><b>idő:</b> {{App\Building::$building_times[$city->nation][$num]}}</td>
                        </tr>
                    </table>
                </div>
            @endforeach
            <button class="btn btn-info" type="submit">Épít</button>
        </form>
    </div>

@stop
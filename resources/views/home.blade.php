@extends('layouts.master')
@section('navbar')
    @include('partials.navbar')
@stop

@section('header')
    <h1>Hello {{$username}} <br>
        <small>Információk az országodról</small>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <h2>Városok</h2>
            </div>

            <div class="row">
        @foreach ($cities as $city)
            <?php
            $food = 0;
            $iron = 0;
            $lumber = 0;
            $stone = 0;
            ?>
                <div class="col-md-3">
                    <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>
                    <a href="/city/{{$city->id}}">
                        {{$city->name}} (szint: {{$city->level}})
                    </a>
                </b>
            </div>

                <table class="table table-hover">

                    <tr>
                        <td><b>Népesség</b></td>

                        @if($city->human_resources->population <= 0)
                            <td class="bg-danger">
                        @else
                            <td>
                                @endif
                                {{$city->human_resources->population}}</td>

                            @if($productions[$city->id]['population'] <= 0)
                                <td class="bg-danger">
                            @else
                                <td>
                                    @endif
                                    {{$productions[$city->id]['population']}}/h
                                </td>
                    </tr>


                    <tr>
                        <td><b>Élelmiszer</b></td>

                        @if($city->resources->food <= 0)
                            <td class="bg-danger">
                        @else
                            <td>
                                @endif
                                {{$city->resources->food}}</td>

                            @if($productions[$city->id]['food'] <= 0)
                                <td class="bg-danger">
                            @else
                                <td>
                                    @endif
                                    {{$productions[$city->id]['food']}}/h
                                </td>
                    </tr>


                    <tr>
                        <td><b>Vas</b></td>
                        @if($city->resources->iron <= 0)
                            <td class="bg-danger">
                        @else
                            <td>
                                @endif
                                {{$city->resources->iron}}</td>

                            @if($productions[$city->id]['iron'] <= 0)
                                <td class="bg-danger">
                            @else
                                <td>
                                    @endif
                                    {{$productions[$city->id]['iron']}}/h
                                </td>

                    </tr>


                    <tr>
                        <td><b>Fa</b></td>
                        @if($city->resources->lumber <= 0)
                            <td class="bg-danger">
                        @else
                            <td>
                                @endif
                                {{$city->resources->lumber}}</td>

                            @if($productions[$city->id]['lumber'] <= 0)
                                <td class="bg-danger">
                            @else
                                <td>
                                    @endif
                                    {{$productions[$city->id]['lumber']}}/h
                                </td>

                    </tr>


                    <tr>
                        <td><b>Kő</b></td>
                        @if($city->resources->stone <= 0)
                            <td class="bg-danger">
                        @else
                            <td>
                                @endif
                                {{$city->resources->stone}}
                            </td>

                            @if($productions[$city->id]['stone'] <= 0)
                                <td class="bg-danger">
                            @else
                                <td>
                                    @endif
                                    {{$productions[$city->id]['stone']}}/h
                                </td>

                    </tr>
                </table>

                    </div>
            </div>
        @endforeach

            </div>
        </div>
    </div>

    <div class="row">
        <hr>
        <div class="col-md-10 col-md-offset-1">

            <div class="row">
                <h2>Hadseregek</h2>
            </div>

            <div class="row">
                @foreach($armies as $army)
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <b>
                                    <a href="/map/x{{$coords[$army->id]['x']}}y{{$coords[$army->id]['y']}}">
                                        koordináta: x: {{$coords[$army->id]['x']}}, y: {{$coords[$army->id]['y']}}
                                    </a>
                                </b>
                            </div>
                            <table class="panel-body table table-hover">

                                @foreach(App\Army::$unit_names[$city->nation] as $key => $name)
                                    <?php
                                    $unit = "unit" . $key;
                                    ?>
                                    <tr>
                                        <td><b>{{$name}}:</b></td>
                                        <td>{{$army->$unit}}</td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

@endsection


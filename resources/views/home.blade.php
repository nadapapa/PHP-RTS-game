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
    <div class="col-md-8 col-md-offset-1">
        <h2>Városok</h2>

        @foreach ($cities as $city)
            <?php
            $food = 0;
            $iron = 0;
            $lumber = 0;
            $stone = 0;
            ?>
            <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>
                    <a href="/city/{{$city->id}}">
                        {{$city->name}} (szint: {{$city->level}})
                    </a>
                </b>
            </div>
            <div class="panel-body">
                <table class="table table-hover">

                    <tr>
                        <td>Népesség</td>

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
                        <td>Élelmiszer</td>

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
                        <td>Vas</td>
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
                        <td>Fa</td>
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
                        <td>Kő</td>
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
            </div>
        @endforeach


    </div>

@endsection


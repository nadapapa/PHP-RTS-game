@extends('layouts.master')
@section('navbar')
    @include('layouts.navbar')
@stop

@section('header')
    <h1>Hello {{$username}} <br>
        <small>Információk az országodról</small>
    </h1>
@stop

@section('content')
    <div class="col-md-4 col-md-offset-1">
        <h2>Városok</h2>

        @foreach ($cities as $city)
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
                        <td>{{$city->resources->population}}</td>
                    </tr>
                    <tr>
                        <td>Élelmiszer</td>
                        <td>{{$city->resources->food}}</td>
                    </tr>
                    <tr>
                        <td>Vas</td>
                        <td>{{$city->resources->iron}}</td>
                    </tr>
                    <tr>
                        <td>Fa</td>
                        <td>{{$city->resources->lumber}}</td>
                    </tr>
                    <tr>
                        <td>Kő</td>
                        <td>{{$city->resources->stone}}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endforeach
    </div>

@endsection


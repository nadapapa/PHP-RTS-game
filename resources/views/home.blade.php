@extends('layouts.master')
@include('layouts.navbar')

@section('header')
    <h1>Hello {{$name}} <br>
        <small>Információk az országodról</small>
    </h1>
@stop

@section('content')
    <div class="col-md-4 col-md-offset-1">
        <h2>Városok</h2>

        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>{{$city->name}} (szint: {{$city->level}})</b>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <tr>
                        <td>Népesség</td>
                        <td>{{$city->population}}</td>
                    </tr>
                    <tr>
                        <td>Élelmiszer</td>
                        <td>{{$city->food}}</td>
                    </tr>
                    <tr>
                        <td>Vas</td>
                        <td>{{$city->iron}}</td>
                    </tr>
                    <tr>
                        <td>Fa</td>
                        <td>{{$city->lumber}}</td>
                    </tr>
                    <tr>
                        <td>Kő</td>
                        <td>{{$city->stone}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection


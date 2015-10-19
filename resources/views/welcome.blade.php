@extends('layouts.master')

@section('header')
    <div class="jumbotron text-center">
        <h1>RTS játék</h1>

        <p>Ide jön vmi szöveg. Jelenleg csak annyi, hogy a játék még nagyon kezdeti stádiumban van.</p>
    </div>
@stop


@section('content')
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>Bejelentkezés email címmel</b>
            </div>
            <div class="panel-body text-center">
                @include('auth.login')
                <br>
                <a class="btn btn-info" href="/password/email">Elfelejtett jelszó</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>Regisztráció</b>
            </div>
            <div class="panel-body text-center">
                @include('auth.register')
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>Bejelentkezés közösségi szolgáltatással</b>
            </div>
            <div class="panel-body text-center">
                <a class="btn btn-primary" href="{{ route('social.login', ['facebook']) }}">Facebook</a>
                <a class="btn btn-primary" href="{{ route('social.login', ['google']) }}">Google</a>
            </div>
        </div>
    </div>
@stop

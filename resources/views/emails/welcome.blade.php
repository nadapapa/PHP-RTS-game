{{-- resources/views/emails/welcome.blade.php --}}

@extends('layouts.email')

@section('title')
    Regisztráció megerősítése
@stop

@section('greeting')
    Hali {{ $user['name'] }}!
@stop
@section('content')
    Valaki (remélhetőleg te magad) ezzel az email-címmel regisztrált az RTS játékba. Ha nem te voltál, akkor nyugodtan hagyd figyelmen kívül ezt a levelet.
    </p>

    <p>
        Ha azonban te regisztráltál, akkor a megerősítéshez kattints az alábbi gombra.
    </p>
    <p>
        Jó játékot!
    </p>
@stop
@section('button')
    <a class="mcnButton "
       title="Megerősítés"
       href="{{ url('auth/verify', $user['verification_code']) }}"
       target="_blank"
       style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Kattints
        ide a regisztráció megerősítéséhez!</a>

@stop
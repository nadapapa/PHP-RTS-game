{{-- resources/views/emails/password.blade.php --}}
@extends('layouts.email')
@section('title')
    Jelszó-helyreállító email
    @endsection
@section('greeting')
Hali {{ $user['name'] }}!
@endsection
@section('content')
    <p>Kattints a gombra a jelszavad helyreállításához</p>
    <p>Jó játékot!</p>
@stop

@section('button')
    <a class="mcnButton "
       title="Megerősítés"
       href="{{ url('password/reset/'.$token) }}"
       target="_blank"
       style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Kattints ide a jelszóhelyreállításhoz!</a>

@stop
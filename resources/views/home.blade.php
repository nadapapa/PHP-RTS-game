@extends('layouts.master')
@include('layouts.navbar')

@section('header')
    <h1>Hello {{$name}}</h1>
@stop

@section('content')


    {{$city}}
@endsection


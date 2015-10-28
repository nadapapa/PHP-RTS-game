@extends('layouts.master')

@section('header')
	<div class="jumbotron text-center">
		<h1>RTS játék</h1>

		<p>Ide jön vmi szöveg. Jelenleg csak annyi, hogy a játék még nagyon kezdeti stádiumban van.</p>
	</div>
@stop


@section('content')
	<div class="col-md-4 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<b>Bejelentkezés</b>
			</div>
			<div class="panel-body text-center">

				@include('auth.login')
				<br>

				<div class="collapse" id="collapseExample">
					@include('auth.password')
				</div>
				<hr>
				<h4>Közösségi</h4>

				<div>
					<a class="btn btn-primary" href="{{ route('social.login', ['facebook']) }}">Facebook</a>
					<a class="btn btn-primary" href="{{ route('social.login', ['google']) }}">Google</a>
				</div>
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
@stop

<!-- resources/views/auth/reset.blade.php -->
@extends('layouts.master')

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <form method="POST" action="/password/reset">
            {!! csrf_field() !!}
            <input type="hidden" name="token" value="{{ $token }}">

            @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="Email">
            </div>

            <div class="form-group">
                <label for="password">Új jelszó</label>
                <input class="form-control" id="password" type="password" name="password" placeholder="Jelszó">
            </div>

            <div class="form-group">
                <label for="password">Jelszó újra</label>
                <input class="form-control" id="password" type="password" name="password_confirmation"
                       placeholder="Jelszó">
            </div>
            <div>
                <button class="btn btn-info" type="submit">Jelszó beállítása</button>
            </div>
        </form>

@endsection
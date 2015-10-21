{{--resources/views/user/validated.blade.php--}}

@extends('layouts.master')

@section('header')
    <h1>Gratulálok {{Auth::user()->name}}, a regisztráció sikerült
        <br>
        <small>Már csak néhány beállítás van hátra</small>
    </h1>
@endsection

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <h3>1. Válaszd ki melyik nép vezére akarsz lenni!</h3>

        <form method="POST" action="/setup">
            {!! csrf_field() !!}

            <div class="checkbox">
                <label>
                    <input type="radio" name="nation" value="1"> <b>Római</b>
                </label>
            </div>
            <span id="helpBlock" class="help-block">Ide kerül majd egy rövid ismertetés a nép előnyeiről és hátrányairól.</span><br>


            <div class="checkbox">
                <label>
                    <input type="radio" name="nation" value="2"> <b>Görög</b>
                </label>
            </div>
            <span id="helpBlock" class="help-block">Ide kerül majd egy rövid ismertetés a nép előnyeiről és hátrányairól.</span><br>

            <div class="checkbox">
                <label>
                    <input type="radio" name="nation" value="3"> <b>Germán</b>
                </label>
            </div>
            <span id="helpBlock" class="help-block">Ide kerül majd egy rövid ismertetés a nép előnyeiről és hátrányairól.</span><br>

            <div class="checkbox">
                <label>
                    <input type="radio" name="nation" value="4"> <b>Szarmata</b>
                </label>
            </div>
            <span id="helpBlock" class="help-block">Ide kerül majd egy rövid ismertetés a nép előnyeiről és hátrányairól.</span><br>


            <h3>2. Adj nevet a fővárosodnak!</h3>

            <div class="form-group">
                <label for="name">Fővárosod neve:</label>
                <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}"
                       placeholder="Fővárosod neve">
            </div>

            <button class="btn btn-primary" type="submit">Kész!</button>
        </form>
    </div>
@endsection

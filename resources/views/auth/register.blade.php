{{--resources/views/auth/register.blade.php--}}

<form method="POST" action="/auth/register">
    {!! csrf_field() !!}

    <div class="form-group">
        <label for="name">Név</label>
        <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Név">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
    </div>

    <div class="form-group">
        <label for="password">Jelszó</label>
        <input class="form-control" id="password" type="password" name="password" placeholder="Jelszó">
    </div>

    <div class="form-group">
        <label for="password">Jelszó újra</label>
        <input class="form-control" id="password" type="password" name="password_confirmation" placeholder="Jelszó">
    </div>

    <div>
        <button class="btn btn-info" type="submit">Regisztráció</button>
    </div>
</form>
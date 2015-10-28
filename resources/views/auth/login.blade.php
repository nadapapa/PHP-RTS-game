<!-- resources/views/auth/login.blade.php -->

<form method="POST" action="/auth/login">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
    </div>

    <div class="form-group">
        <label for="password">Jelszó</label>
        <input class="form-control" id="password" type="password" name="password" placeholder="Jelszó">
    </div>

    <div class="checkbox">
        <label>
        <input type="checkbox" name="remember"> Emlékezz rám!
        </label>
    </div>

    <div>
        <button class="btn btn-info" type="submit">Bejelentkezés</button>
        <a class="btn btn-info" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Elfelejtett jelszó</a>
    </div>
</form>
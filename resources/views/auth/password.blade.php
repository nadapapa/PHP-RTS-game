<!-- resources/views/auth/password.blade.php -->

<form method="POST" action="/password/email">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group">
        <label for="email">Email</label>
        <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email">
    </div>

    <div>
        <button class="btn btn-info" type="submit">
            Jelszó-helyreállító link küldése
        </button>
    </div>
</form>
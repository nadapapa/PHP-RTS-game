{{--resources/views/user/validated.blade.php--}}
<!DOCTYPE html>
<html>

Gratulálok {{Auth::user()->name}} a regisztráció sikerült <br>

{{--@if(Auth::user()->nation != 0)--}}
    {{--a néped: {{Auth::user()->nation}}--}}

{{--@else--}}
    válaszd ki melyik nép vezére akarsz lenni! <br>

    <form method="POST" action="/setup">
        {!! csrf_field() !!}
        <input type="radio" name="nation" value="1"> Római <br>
        <input type="radio" name="nation" value="2"> Görög <br>
        <input type="radio" name="nation" value="3"> Germán <br>
        <input type="radio" name="nation" value="4"> Kelta <br>
        <button type="submit">játék</button>
    </form>
{{--@endif--}}

</html>
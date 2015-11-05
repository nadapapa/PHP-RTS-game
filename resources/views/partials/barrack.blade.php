<hr>
<form method="POST" action="{{Request::url()}}/train">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    @foreach(App\Army::$unit_names[$city->nation] as $num => $name)
        <div class="panel panel-default">
            <div class="panel-heading table">
                <div class="radio-sm">
                    <label>
                        <input type="radio" name="type" id="{{$num}}" value="{{$num}}">
                        <b>
                            {{$name}}
                        </b>
                    </label>
                </div>

            </div>
            <div class="panel-body">

            </div>

            <table class="panel-footer table">
                <tr>
                    <td><b>vas:</b>
                        {{App\Army::$unit_prices[$city->nation][$num]['iron']}}</td>
                    <td><b>élelmiszer:</b> {{App\Army::$unit_prices[$city->nation][$num]['food']}}</td>
                    <td><b>fa:</b> {{App\Army::$unit_prices[$city->nation][$num]['lumber']}}</td>
                    <td><b>kő:</b> {{App\Army::$unit_prices[$city->nation][$num]['stone']}}</td>
                    <td><b>idő:</b> {{App\Army::$unit_times[$city->nation][$num]}}</td>
                </tr>
            </table>
        </div>
    @endforeach

    @if(!empty($task = $building->task->where('building_id', $building->id)->first()))
        <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
        <button class="btn btn-info disabled" type="submit">Képez <span
                    data-countdown="{{$task->finished_at->format('Y/m/d/ H:i:s')}}"></span></button>
    @else
        <button class="btn btn-info" type="submit">Képez</button>
    @endif
</form>

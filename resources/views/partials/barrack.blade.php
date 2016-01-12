<hr>

    @foreach(App\Army::$unit_names[$city->nation] as $num => $name)
        <div class="panel panel-default">
            <div class="panel-heading table">
                <b>
                    {{$name}}
                </b>
            </div>
            <div class="panel-body">
                <p>
                    {{App\Army::$unit_description[$city->nation][$num]}}
                </p>
                @if(count($building->task))
                    <a href="{{Request::url()}}/train/{{$num}}" class='btn btn-info disabled'>
                        @if($building->task->first()->type == ($num + 10))
                            <span data-countdown="{{$building->task->first()->finished_at->format('Y/m/d/ H:i:s')}}"></span>
                        @else
                            Képez
                        @endif
                    </a>
                @else
                    <a href="{{Request::url()}}/train/{{$num}}" class='btn btn-info'>Képez</a>
                @endif

            </div>

            <table class="panel-footer table">
                <tr>
                    @if($city->resources->food >= App\Army::$unit_prices[$city->nation][$num]['food'])
                        <td class="bg-success">
                    @else
                        <td class="bg-danger">
                            @endif
                            <b>élelmiszer:</b> {{App\Army::$unit_prices[$city->nation][$num]['food']}}
                        </td>

                        @if($city->resources->iron >= App\Army::$unit_prices[$city->nation][$num]['iron'])
                            <td class="bg-success">
                        @else
                            <td class="bg-danger">
                                @endif
                                <b>vas:</b>
                                {{App\Army::$unit_prices[$city->nation][$num]['iron']}}
                            </td>

                            @if($city->resources->lumber >= App\Army::$unit_prices[$city->nation][$num]['lumber'])
                                <td class="bg-success">
                            @else
                                <td class="bg-danger">
                                    @endif
                                    <b>fa:</b> {{App\Army::$unit_prices[$city->nation][$num]['lumber']}}
                                </td>

                                @if($city->resources->lumber >= App\Army::$unit_prices[$city->nation][$num]['food'])
                                    <td class="bg-success">
                                @else
                                    <td class="bg-danger">
                                        @endif
                                        <b>kő:</b> {{App\Army::$unit_prices[$city->nation][$num]['stone']}}
                                    </td>

                                    <td><b>idő:</b> {{App\Army::$unit_times[$city->nation][$num]}}</td>
                </tr>
            </table>
        </div>
    @endforeach

    @if(count($building->task))
        <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
    @endif

<hr>
@if($building->task)
    <script src="{{asset('js/jquery.countdown.min.js')}}"></script>

    <a href="{{Request::url()}}/worker" class="btn btn-info btn-xs disabled">Munkás képzése
        <br>
        <span data-countdown="{{$building->task->finished_at->format('Y/m/d/ H:i:s')}}"></span></a>
@else
    <a href="{{Request::url()}}/worker" class="btn btn-info btn-xs">Munkás képzése</a>
@endif
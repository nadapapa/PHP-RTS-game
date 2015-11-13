<hr>
@if(!empty($building->task))
    <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
@endif

@if ($building->task->contains('building_id', $building->id))
    <?php
    $task = $building->task->first();
    ?>
    @if (intval($task->type) == 1)
    <a href="{{Request::url()}}/worker" class='btn btn-info btn-xs disabled'>Munkás képzése
        <br><span data-countdown="{{$task->finished_at->format('Y/m/d/ H:i:s')}}"></span></a>
    <a href="{{Request::url()}}/settler" class="btn btn-info btn-xs disabled">Telepes képzése</a>

    @else
        <a href="{{Request::url()}}/worker" class="btn btn-info btn-xs disabled">Munkás képzése</a>

        <a href="{{Request::url()}}/settler" class='btn btn-info btn-xs disabled'>Telepes képzése
            <br><span data-countdown="{{$task->finished_at->format('Y/m/d/ H:i:s')}}"></span></a>
    @endif
@else
    <a href="{{Request::url()}}/worker" class="btn btn-info btn-xs">Munkás képzése</a>
    <a href="{{Request::url()}}/settler" class="btn btn-info btn-xs">Telepes képzése</a>
@endif

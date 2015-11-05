<hr>
@if(!empty($building->task))
    <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
@endif

@if ($building->task->contains('type', 1))
    <?php
    $task = $building->task->where('type', 1)->first();
    ?>
    <a href="{{Request::url()}}/worker" class='btn btn-info btn-xs disabled'>Munkás képzése
        <br><span data-countdown="{{$task->finished_at->format('Y/m/d/ H:i:s')}}"></span></a>
@else
    <a href="{{Request::url()}}/worker" class="btn btn-info btn-xs">Munkás képzése</a>
@endif

@if ($building->task->contains('type', 2))
    <?php
    $task = $building->task->where('type', 2)->first();
    ?>
    <a href="{{Request::url()}}/settler" class='btn btn-info btn-xs disabled'>Telepes képzése
        <br><span data-countdown="{{$task->finished_at->format('Y/m/d/ H:i:s')}}"></span></a>
@else
    <a href="{{Request::url()}}/settler" class="btn btn-info btn-xs">Telepes képzése</a>
@endif

@if($city->resources->settlers > 0)
    <hr>
    Telepesek: {{$city->resources->settlers}} <br>
    <a href="/city/{{$city->id}}/newcity" class="btn btn-info btn-xs">Új város alapítása</a>
@endif


<hr>
@if(!empty($building->task))
    <script src="{{asset('js/jquery.countdown.min.js')}}"></script>
@endif

<div class="panel panel-default">
    <div class="panel-heading table">
        Munkás
    </div>
    <div class="panel-body">
        Működteti az épületeket
    </div>

    <table class="panel-footer table">
        <tr>
            <td><b>vas:</b>
                {{App\HumanResource::$worker_price[$city->nation]['iron']}}</td>
            <td><b>élelmiszer:</b> {{App\HumanResource::$worker_price[$city->nation]['food']}}</td>
            <td><b>fa:</b> {{App\HumanResource::$worker_price[$city->nation]['lumber']}}</td>
            <td><b>kő:</b> {{App\HumanResource::$worker_price[$city->nation]['stone']}}</td>
            <td><b>idő:</b> {{App\HumanResource::$worker_time[$city->nation]}}</td>
        </tr>
    </table>
</div>

<div class="panel panel-default">
    <div class="panel-heading table">
        Telepes
    </div>
    <div class="panel-body">
        Új várost alapít
    </div>

    <table class="panel-footer table">
        <tr>
            <td><b>vas:</b>
                {{App\HumanResource::$settler_price[$city->nation]['iron']}}</td>
            <td><b>élelmiszer:</b> {{App\HumanResource::$settler_price[$city->nation]['food']}}</td>
            <td><b>fa:</b> {{App\HumanResource::$settler_price[$city->nation]['lumber']}}</td>
            <td><b>kő:</b> {{App\HumanResource::$settler_price[$city->nation]['stone']}}</td>
            <td><b>idő:</b> {{App\HumanResource::$settler_time[$city->nation]}}</td>
        </tr>
    </table>
</div>

<div class="panel panel-default">
    <div class="panel-heading table">
        Tábornok
    </div>
    <div class="panel-body">
        Hadsereget vezet.
        @if ($city->army() && $city->army()->general)
            <br>Már van egy a városban. Egyszerre csak egyetlen tábornok tartózkodhat egy városban
        @endif
    </div>

    <table class="panel-footer table">
        <tr>
            <td><b>vas:</b>
                {{App\HumanResource::$worker_price[$city->nation]['iron']}}</td>
            <td><b>élelmiszer:</b> {{App\HumanResource::$worker_price[$city->nation]['food']}}</td>
            <td><b>fa:</b> {{App\HumanResource::$worker_price[$city->nation]['lumber']}}</td>
            <td><b>kő:</b> {{App\HumanResource::$worker_price[$city->nation]['stone']}}</td>
            <td><b>idő:</b> {{App\HumanResource::$worker_time[$city->nation]}}</td>
        </tr>
    </table>
</div>




@if ($building->task->contains('building_id', $building->id))
    <?php
    $task = $building->task->first();
    ?>
    <a href="{{Request::url()}}/worker" class='btn btn-info btn-xs disabled'>Munkás képzése
        @if (intval($task->type) == 1)
        <br><span data-countdown="{{$task->finished_at->format('Y/m/d/ H:i:s')}}"></span>
        @endif
    </a>

    <a href="{{Request::url()}}/settler" class="btn btn-info btn-xs disabled">Telepes képzése
    @if (intval($task->type) == 2)
        <br><span data-countdown="{{$task->finished_at->format('Y/m/d/ H:i:s')}}"></span>
    @endif
    </a>


    <a href="{{Request::url()}}/general" class="btn btn-info btn-xs disabled">Tábornok képzése
        @if (intval($task->type) == 3)
            <br><span data-countdown="{{$task->finished_at->format('Y/m/d/ H:i:s')}}"></span>
        @endif
    </a>




@else
    <a href="{{Request::url()}}/worker" class="btn btn-info btn-xs">Munkás képzése</a>
    <a href="{{Request::url()}}/settler" class="btn btn-info btn-xs">Telepes képzése</a>

    @if (!($city->army() && $city->army()->general))
        <a href="{{Request::url()}}/general" class="btn btn-info btn-xs">Tábornok képzése</a>
    @endif

@endif

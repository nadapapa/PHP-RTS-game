@extends('layouts.master')
@section('navbar')
    @include('partials.navbar')
@stop

@section('header')
    <h1>Hello {{$username}} <br>
        <small>Információk az országodról</small>
    </h1>
@stop

@section('content')
    <div class="col-md-8 col-md-offset-1">
        <h2>Városok</h2>

        @foreach ($cities as $city)
            <?php
            $food = 0;
            $iron = 0;
            $lumber = 0;
            $stone = 0;
            ?>
            <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                <b>
                    <a href="/city/{{$city->id}}">
                        {{$city->name}} (szint: {{$city->level}})
                    </a>
                </b>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    @foreach($city->building_slot->building as $building)
                        <?php
                        $profit = ($building->level * $building->workers) * ($building->health / 100);
                        switch ($building->type) {
                            case 1:
                                $food += $profit;
                                break;
                            case 2:
                                $stone += $profit;
                                break;
                            case 3:
                                $iron += $profit;
                                break;
                            case 4:
                                $lumber += $profit;
                                break;
                        }
                        ?>
                    @endforeach
                    <tr>
                        <td>Népesség</td>
                        <td>{{$city->human_resources->population}}</td>
                        <td>0/h</td>
                    </tr>
                    <tr>
                        <td>Élelmiszer</td>
                        <td>{{$city->resources->food}}</td>
                        <td>{{$food}}/h</td>
                    </tr>
                    <tr>
                        <td>Vas</td>
                        <td>{{$city->resources->iron}}</td>
                        <td>{{$iron}}/h</td>

                    </tr>
                    <tr>
                        <td>Fa</td>
                        <td>{{$city->resources->lumber}}</td>
                        <td>{{$lumber}}/h</td>

                    </tr>
                    <tr>
                        <td>Kő</td>
                        <td>{{$city->resources->stone}}</td>
                        <td>{{$stone}}/h</td>

                    </tr>
                </table>
            </div>
        </div>
            </div>
        @endforeach


    </div>

@endsection


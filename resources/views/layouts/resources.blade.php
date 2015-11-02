<div class="panel panel-default pull-right">
    <div class="panel-heading text-center">
        <b>
            Nyersanyagok
        </b>
    </div>

    <table class="panel-body table">
        <tr>
            <td><b>Népesség:</b> {{$city->resources->population}}</td>
            <td><b>Munkások:</b> {{$city->resources->workers}}</td>
            <td><b>Élelmiszer:</b> {{$city->resources->food}}</td>
            <td><b>Vas:</b> {{$city->resources->iron}}</td>
            <td><b>Fa:</b> {{$city->resources->lumber}}</td>
            <td><b>Kő:</b> {{$city->resources->stone}}</td>
        </tr>
    </table>
    <div class="panel-heading text-center">
        <b>
            Hozamok
        </b>
    </div>
    <?php
    $food = 0;
    $iron = 0;
    $lumber = 0;
    $stone = 0;
    ?>
    <table class="panel-body table">
        <tr>
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
            <td><b>Népesség:</b> 0/h</td>
            <td><b>Élelmiszer:</b> {{$food}}/h</td>
            <td><b>Vas:</b> {{$iron}}/h</td>
            <td><b>Fa:</b> {{$lumber}}/h</td>
            <td><b>Kő:</b> {{$stone}}/h</td>
        </tr>
    </table>

</div>
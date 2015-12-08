<div class="panel panel-default pull-right">
    <div class="panel-heading text-center">
        <b>
            Nyersanyagok
        </b>
    </div>

    <table class="panel-body table">
        <tr>
            <td><b>Népesség:</b> {{$city->human_resources->population}}</td>
            <td><b>Munkások:</b> {{$city->human_resources->workers}}</td>
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
    <table class="panel-body table">
        <tr>
            <td><b>Népesség:</b> 0/h</td>
            <td><b>Élelmiszer:</b> {{$production['food']}}/h</td>
            <td><b>Vas:</b> {{$production['iron']}}/h</td>
            <td><b>Fa:</b> {{$production['lumber']}}/h</td>
            <td><b>Kő:</b> {{$production['stone']}}/h</td>
        </tr>
    </table>

</div>
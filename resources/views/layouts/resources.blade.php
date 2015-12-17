<div class="panel panel-default pull-right">
    <div class="panel-heading text-center">
        <b>
            Nyersanyagok
        </b>
    </div>

    <table class="panel-body table">
        <tr>
            @if($city->human_resources->population > 0)
                <td>
            @else
                <td class="bg-danger">
                    @endif
                    <b>Népesség:</b>{{ceil($city->human_resources->population)}}
                </td>

                @if($city->human_resources->workers > 0)
                    <td>
                @else
                    <td class="bg-danger">
                        @endif
                        <b>Munkások:</b> {{$city->human_resources->workers}}
                    </td>


                    @if($city->resources->food > 0)
                        <td>
                    @else
                        <td class="bg-danger">
                            @endif
                            <b>Élelmiszer:</b> {{number_format($city->resources->food, 2)}}
                        </td>


                        @if($city->resources->iron > 0)
                            <td>
                        @else
                            <td class="bg-danger">
                                @endif
                                <b>Vas:</b> {{number_format($city->resources->iron, 2)}}
                            </td>

                            @if($city->resources->lumber > 0)
                                <td>
                            @else
                                <td class="bg-danger">
                                    @endif
                                    <b>Fa:</b> {{number_format($city->resources->lumber, 2)}}
                                </td>


                                @if($city->resources->stone > 0)
                                    <td>
                                @else
                                    <td class="bg-danger">
                                        @endif
                                        <b>Kő:</b> {{number_format($city->resources->stone, 2)}}
                                    </td>
        </tr>
    </table>
    <div class="panel-heading text-center">
        <b>
            Hozamok
        </b>
    </div>
    <table class="panel-body table">
        <tr>
            @if($production['population'] > 0)
                <td>
            @else
                <td class="bg-danger">
                    @endif
                    <b>Népesség:</b> {{$production['population']}}/h
                </td>


                @if($production['food'] > 0)
                    <td>
                @else
                    <td class="bg-danger">
                        @endif
                        <b>Élelmiszer:</b> {{$production['food']}}/h
                    </td>

                    @if($production['iron'] > 0)
                        <td>
                    @else
                        <td class="bg-danger">
                            @endif
                            <b>Vas:</b> {{$production['iron']}}/h
                        </td>

                        @if($production['lumber'] > 0)
                            <td>
                        @else
                            <td class="bg-danger">
                                @endif
                                <b>Fa:</b> {{$production['lumber']}}/h
                            </td>

                            @if($production['stone'] > 0)
                                <td>
                            @else
                                <td class="bg-danger">
                                    @endif
                                    <b>Kő:</b> {{$production['stone']}}/h
                                </td>
        </tr>
    </table>

</div>
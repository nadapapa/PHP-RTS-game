<?php

// --- Define some constants
$MAP_WIDTH = $view_width;
$MAP_HEIGHT = $view_height;

$HEX_HEIGHT = 72;

// --- Use this to scale the hexes smaller or larger than the actual graphics
$HEX_SCALED_HEIGHT = $HEX_HEIGHT * 1.0;
$HEX_SIDE = $HEX_SCALED_HEIGHT / 2;
?>

        <!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <meta name="csrf_token" content="{{ $encrypted_csrf_token }}"/>
    <title>rts játék térkép</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style type="text/css">
        .hexmap {
            width: <?php echo $MAP_WIDTH * $HEX_SIDE * 1.5 + $HEX_SIDE/2; ?>px;
            height: <?php echo $MAP_HEIGHT * $HEX_SCALED_HEIGHT + $HEX_SIDE; ?>px;
            position: relative;
        }

        .hex {
            position: absolute;
            width: <?php echo $HEX_SCALED_HEIGHT ?>;
            height: <?php echo $HEX_SCALED_HEIGHT ?>;
        }
    </style>
</head>
<body>
@include('layouts.navbar')
<div class="container">
    <div class="page-header">
        <h2>Térkép</h2>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default text-center">
                <div id="up" class="btn btn-default"><i class="fa fa-arrow-up"></i></div>
                <br>

                <div id="left" class="btn btn-default"><i class="fa fa-arrow-left"></i></div>
                <div id="right" class="btn btn-default"><i class="fa fa-arrow-right"></i></div>
                <br>

                <div id="down" class="btn btn-default"><i class="fa fa-arrow-down"></i></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <b>
                        Ugrás koordinátára
                    </b>
                </div>
                <div class="panel-body">

                    <div class="form-group">

                        <label for="x">X:</label>
                        <input class="form-control" id="x" type="number" min="0" max="19" name="x"
                               value="{{ old('x') }}" placeholder="0-19">

                        <label for="y">Y:</label>
                        <input class="form-control" id="y" type="number" min="0" max="9" name="y" value="{{ old('y') }}"
                               placeholder="0-9">
                    </div>
                    <div>
                        <div id="coord" class="btn btn-info">Ugrás</div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div id='hexmap' class="panel-body hexmap">
                    <?php
                    foreach ($grid as $row) {

                        $title = null;
                        $x = $row['x'];
                        $y = $row['y'];
                        $id = $row['id'];

                        $army = $row['army_id'];

                        $nx = $row['nx'];
                        $ny = $row['ny'];

                        $tx = $nx * $HEX_SIDE * 1.5;
                        $ty = $ny * $HEX_SCALED_HEIGHT + ($nx % 2) * $HEX_SCALED_HEIGHT / 2;

                        // --- Style values to position hex image in the right location
                        $style = sprintf("left:%dpx;top:%dpx", $tx, $ty);
                        $img = "/img/grid/" . $row['layer1'] . ".png";

                        $city = "";
                        $owner_name = "";
                        $nation = '';
                        $layer1 = $row['layer1'];

                        if ($row['owner'] > 0) {

                            $owner_name = $row['owner_name'];
                            $nation = $row['nation'];
                        }

                        if ($row['city']) {
                            $city = $row['city'];
                        }

                        // --- Output the image tag for this hex
                        echo "<img id='$id' data-x='$x' data-y='$y' data-current_x='$nx' data-current_y='$ny' data-owner='$owner_name' data-nation='$nation' data-city='$city' data-layer1='$layer1' data-army='$army' src='$img' class='hex' style='z-index:1;$style'>\n";

                        if ($row['layer2'] > 0) {
                            $img = "/img/grid/" . $row['layer2'] . ".png";
                            print "<img $title src='$img' class='hex' style='z-index:2;$style'>\n";

                        }
                    }
                    ?>
                    <img id='highlight' class='hex' src='/img/grid/hex-highlight.png' style='z-index:100;display:none'>
                </div>


            </div>
        </div>

        <div class="col-md-2">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <b>
                        A hex adatai
                    </b>
                </div>
                <div class="panel-body hex_data">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <div id="army_panel" class="panel panel-default">
                <div class="panel-heading text-center">
                    Hadsereg mozgatása
                </div>
                <div id="army_movement" class="panel-body">
                    A sereg jelenlegi koordinátája: <span id="current_coord"></span><br>
                    Áthelezés ide: <span id="destination_coord"></span><br>
                    Távolság: <span id="travel_distance"></span><br>
                    Idő: <span id="travel_time"></span><br>
                    <div id="moving_button" class="btn btn-default">Mozgás!</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script>

    $.ajaxPrefilter(function (options, originalOptions, xhr) {
        var token = $('meta[name="csrf_token"]').attr('content');

        if (token) {
            return xhr.setRequestHeader('X-XSRF-TOKEN', token);
        }
    });


    var jump = 2;
    var HEX_HEIGHT = 72;
    var HEX_SCALED_HEIGHT = HEX_HEIGHT * 1.0;
    var HEX_SIDE = HEX_SCALED_HEIGHT / 2;

    var view_width = {{$view_width}};
    var view_height = {{$view_height}};

    var map_width = 20;
    var map_height = 10;

    x = {{$x-4}};
    y = {{$y-2}};

    // ajax
    $(function () {
        $('#army_panel').hide();
        $(".hexmap").on("buttonClick", function (event, direction) {
            var highlight = document.getElementById('highlight');

            switch (direction) {
                case "right":
                    x += jump;
                    highlight.dataset.x = parseInt(highlight.dataset.x) - jump;
                    break;
                case "left":
                    x -= jump;
                    highlight.dataset.x = parseInt(highlight.dataset.x) + jump;
                    break;
                case "up":
                    y -= jump;
                    highlight.dataset.y = parseInt(highlight.dataset.y) + jump;
                    break;
                case "down":
                    y += jump;
                    highlight.dataset.y = parseInt(highlight.dataset.y) - jump;
                    break;
                case "coord":
                    x = $('#x').val();
                    y = $('#y').val();

                    break;
            }

            switch (direction) {
                case "up":
                case "down":
                case "right":
                case "left":
                    if
                    (x < ((view_width - 1) / 2) - 1) {
                        x = (view_width - 1) / 2;
                        return;
                    }
                    if (y < ((view_height - 1) / 2) - 1) {
                        y = (view_height - 1) / 2;
                        return;
                    }

                    if (x > map_width - ((view_width - 1) / 2) + 1) {
                        x = map_width - ((view_width - 1) / 2);
                        return;
                    }
                    if (y > map_height - ((view_height - 1) / 2) + 1) {
                        y = map_height - ((view_height - 1) / 2);
                        return;
                    }
            }


            $.ajax({
                url: '/map',
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');

                    if (token) {
                        return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                    }
                },

                type: 'post',
                data: {
                    'x': x,
                    'y': y
                },

                success: function (data) {

                    $('.hexmap').contents(':not(#highlight)').remove();

                    var grid = JSON.parse(data);

                    for (var i in grid) {
                        tx = grid[i].nx * HEX_SIDE * 1.5;
                        ty = grid[i].ny * HEX_SCALED_HEIGHT + (grid[i].nx % 2) * HEX_SCALED_HEIGHT / 2;

                        var img = "/img/grid/" + grid[i].layer1 + ".png";
                        var style = "left:" + tx + "px;top:" + ty + "px";

                        var owner = "";
                        var nation = "";
                        var city = "";

                        if (typeof grid[i].owner_name != 'undefined') {
                            owner = grid[i].owner_name;
                            nation = grid[i].nation;
                            city = grid[i].city;
                        }

                        $('.hexmap').append(
                                "<img id='" + grid[i].id + "' data-current_x='" + grid[i].nx + "' data-current_y='" + grid[i].ny + "' data-x='" + grid[i].x + "' data-y='" + grid[i].y + "' data-owner='" + owner + "' data-nation='" + nation + "' data-city='" + city + "' data-layer1='" + grid[i].layer1 + "' data-army='" + grid[i].army_id + "' src='" + img + "' class='hex' style='z-index:10;" + style + "'>\n"
                        );

                        if (grid[i].city != 0) {
                            var img = "/img/grid/" + grid[i].layer2 + ".png";

                            $('.hexmap').append(
                                    "<img id='" + grid[i].id + "' data-x='" + grid[i].x + "' data-y='" + grid[i].x + "' src='" + img + "' class='hex' style='z-index:20;" + style + "'>\n"
                            )
                        }

                        if (direction === "coord" && grid[i].x == x && grid[i].y == y) {
                            highlight.style.left = tx + 'px';
                            highlight.style.top = ty + 'px';
                            highlight.style.display = 'inline';
                            highlight.dataset.hex_id = grid[i].id;
                        }

                        if (parseInt(highlight.dataset.hex_id) === parseInt(grid[i].id)) {
                            highlight.style.left = tx + 'px';
                            highlight.style.top = ty + 'px';
                            highlight.style.display = 'inline';
                            var hex_exist = true;
                        }

                    }

                    if (!hex_exist) {
                        highlight.style.display = 'none';
                    }

                },
                error: function (xhr, desc, err) {
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);
                }
            })
        });

        $("#right").click(function () {
            $(".hexmap").trigger("buttonClick", ["right"]);
        });
        $("#left").click(function () {
            $(".hexmap").trigger("buttonClick", ["left"]);
        });
        $("#up").click(function () {
            $(".hexmap").trigger("buttonClick", ["up"]);
        });
        $("#down").click(function () {
            $(".hexmap").trigger("buttonClick", ["down"]);
        });
        $("#coord").click(function () {
            $(".hexmap").trigger("buttonClick", ["coord"]);
        });

    });

    $('.hexmap').on('click', function (event) {
        var posx = 0;
        var posy = 0;
        if (event.pageX || event.pageY) {
            posx = event.pageX;
            posy = event.pageY;
        } else if (event.clientX || e.clientY) {
            posx = event.clientX + document.body.scrollLeft
                    + document.documentElement.scrollLeft;
            posy = event.clientY + document.body.scrollTop
                    + document.documentElement.scrollTop;
        }

        // --- Apply offset for the map div
        var map = document.getElementById('hexmap').getBoundingClientRect();

        posx = posx - map.left;
        posy = posy - map.top - window.scrollY;

        var hex_height = 72;
        var x = (posx - (hex_height / 2)) / (hex_height * 0.75);
        var y = (posy - (hex_height / 2)) / hex_height;
        var z = -0.5 * x - y;
        var y = -0.5 * x + y;

        ix = Math.floor(x + 0.5);
        iy = Math.floor(y + 0.5);
        iz = Math.floor(z + 0.5);
        s = ix + iy + iz;
        if (s) {
            abs_dx = Math.abs(ix - x);
            abs_dy = Math.abs(iy - y);
            abs_dz = Math.abs(iz - z);
            if (abs_dx >= abs_dy && abs_dx >= abs_dz) {
                ix -= s;
            } else if (abs_dy >= abs_dx && abs_dy >= abs_dz) {
                iy -= s;
            } else {
                iz -= s;
            }
        }

        // ----------------------------------------------------------------------
        // --- map_x and map_y are the map coordinates of the click
        // ----------------------------------------------------------------------
        map_x = ix;
        map_y = (iy - iz + (1 - ix % 2 ) ) / 2 - 0.5;

        if (map_x < 0 || map_y < 0) {
            return;
        }
        // ----------------------------------------------------------------------
        // --- Calculate coordinates of this hex.  We will use this
        // --- to place the highlight image.
        // ----------------------------------------------------------------------
        tx = map_x * HEX_SIDE * 1.5;
        ty = map_y * HEX_SCALED_HEIGHT + (map_x % 2) * HEX_SCALED_HEIGHT / 2;

        var highlight = document.getElementById('highlight');
        highlight.style.display = 'inline';

        // Set position to be over the clicked on hex
        highlight.style.left = tx + 'px';
        highlight.style.top = ty + 'px';

        highlight.dataset.x = map_x;
        highlight.dataset.y = map_y;

//        var hex = $("[data-current_x='" + map_x + "'][data-current_y='" + map_y + "']");
        var hex = document.querySelector("[data-current_x='" + map_x + "'][data-current_y='" + map_y + "']");
        var hex_x = hex.dataset.x;
        var hex_y = hex.dataset.y;

        highlight.dataset.hex_id = hex.id;

        // display hex data
        var terrain = "";
        var speed = 1;
        switch (parseInt(hex.dataset.layer1)) {
            case 0:
                terrain = "tenger";
                speed = 0.5;
                break;
            case 1:
                terrain = "jég";
                speed = 0.4;
                break;
            case 5:
                terrain = "erdő";
                speed = 0.5;
                break;
            case 8:
                terrain = "fenyves";
                speed = 0.5;
                break;
            case 10:
            case 21:
            case 22:
                terrain = "hegy";
                speed = 0.2;
                break;
            case 13:
                terrain = "havas fenyőerdő";
                speed = 0.4;
                break;
            case 41:
                terrain = "dombvidék";
                speed = 0.7;
                break;
            case 42:
                terrain = "sivatag";
                speed = 0.5;
                break;
            case 91:
                terrain = "füves mező";
                speed = 1;
                break;
            case 100:
                terrain = "város";
                break;
        }

        $(".hex_data").html("<p>Koordináták: <br> x: " + hex_x + " y: " + hex_y + "</p>");

        if (hex.dataset.city == "") {
//            $('#units_panel').hide();
            $(".hex_data").append("<p>Terület: " + terrain + "</p><p>Sebesség: " + speed + "</p>");
        }

        if (hex.dataset.city > "0") {
            $(".hex_data").append(
                    "<p><br>Város: " + hex.dataset.city + "<br>Tulajdonos: " + hex.dataset.owner + "<br>Nép: " + hex.dataset.nation + "</p>"
            );
        } else if (hex.dataset.owner > "0") {
            $(".hex_data").append(
                    "<p><br>Tulajdonos: " + hex.dataset.owner + "<br>Nép: " + hex.dataset.nation + "</p>"
            );
        }

        // display army data
        if (hex.dataset.army > 0){
        $.ajax({
            url: '/map/army',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                }
            },

            type: 'post',
            data: {
                'army': hex.dataset.army
            },

            success: function (data) {
                var units = JSON.parse(data);
                $('.hex_data').append("<p>Hadsereg: <br>");
                for (var i in units){
                    $('.hex_data').append(
                            i+": "+units[i]+"<br>");
                }
                $('.hex_data').append("<div id='move' class='btn btn-default'>Sereg mozgatása</div></p>");

            },

            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
        } else {
            $('#city_units').html('');
        }

        // destination calculation
        $('#destination_coord').html("x: "+ hex_x +" y: "+hex_y)


    });

    $(document).on('click', '#move', function(){
        $('#army_panel').show();
        var hex_id = $('#highlight').data('hex_id');
        var x = $('#'+hex_id).data('x');
        var y = $('#'+hex_id).data('y');
        $("#current_coord").html("x: "+ x +" y: "+y).data('x', x).data('y', y);



    });

</script>
</body>
</html>                            
<?php

// --- Define some constants
$MAP_WIDTH = 20;
$MAP_HEIGHT = 10;

$HEX_HEIGHT = 72;

// --- Use this to scale the hexes smaller or larger than the actual graphics
$HEX_SCALED_HEIGHT = $HEX_HEIGHT * 1.0;
$HEX_SIDE = $HEX_SCALED_HEIGHT / 2;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <!--    <meta name="_token" content="{{ csrf_token() }}"/>-->
    <title>php rts játék</title>
    <!-- Stylesheet to define map boundary area and hex style -->
    <style type="text/css">
        body {

            margin: 0;
            padding: 0;

        }

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


<a href="/">főoldal</a><br>

<h1>Hello {{Auth::user()->name}}</h1>

<div id='hexmap' class='hexmap'>


    <?php
    foreach ($grid as $row) {
        $title = null;
// --- Coordinates to place hex on the screen
        $x = $row['x'];
        $y = $row['y'];
        $id = $row['id'];
        $owner_id = $row['owner'];



        $tx = $x * $HEX_SIDE * 1.5;
        $ty = $y * $HEX_SCALED_HEIGHT + ($x % 2) * $HEX_SCALED_HEIGHT / 2;

        // --- Style values to position hex image in the right location
        $style = sprintf("left:%dpx;top:%dpx", $tx, $ty);
        $img = "img/grid/" . $row['type'] . ".png";

        if($owner_id > 0){
            $city = $row['city'];
            $owner_name = $row['owner_name'];
            $title = "title=
            'név: $city
tulajdonos: $owner_name'";

        }
        // --- Output the image tag for this hex
        print "<img id='$id' $title src='$img' class='hex' style='z-index:99;$style'>\n";

    }
    ?>
</div>

<a href="/auth/logout">kijelentkezés</a><br>


</body>
</html>                            
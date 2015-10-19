<?php

// --- Define some constants
$MAP_WIDTH = 20;
$MAP_HEIGHT = 20;


$HEX_Y = 52;
$HEX_X = 60;

$HEX_REAL_Y = 65;
$HEX_REAL_X = 60;

$HEX_Y_DIFF = 16;
$HEX_SIDE = 28;
$HEX_SIDE_DIFF = 12;

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
        width: <?php echo $MAP_WIDTH * $HEX_X; ?>px;
        height: <?php echo $MAP_HEIGHT * $HEX_SIDE_DIFF + $HEX_SIDE; ?>px;
        position: relative;

        }

        {{--.hex-key-element {--}}
            {{--width: <?php echo $HEX_X; ?>px;--}}
            {{--height: <?php echo $HEX_Y; ?>px;--}}
            {{--border: 1px solid #fff;--}}
            {{--float: left;--}}
            {{--text-align: center;--}}
        {{--}--}}

        .hex {
            position: absolute;
            width: 60px;
            height: 68px;
        }
    </style>
</head>
<body>



            <a href="/">főoldal</a><br>

            <h1>Hello {{Auth::user()->name}}</h1>

            <div id='hexmap' class='hexmap'>


<?php
            foreach($grid as $row){
// --- Coordinates to place hex on the screen
                $x = $row['x'];
                $y = $row['y'];

        $tx = $x * $HEX_X + ($y % 2) * ($HEX_X / 2);
        $ty = ($y * ($HEX_REAL_Y-$HEX_SIDE_DIFF-$HEX_Y_DIFF))+(($y%2)*($HEX_SIDE-$HEX_SIDE_DIFF-$HEX_Y_DIFF));

                // --- Style values to position hex image in the right location
                $style = sprintf("left:%dpx;top:%dpx", $tx, $ty);
$img = "img/grid/".$row['type'].".png";
                // --- Output the image tag for this hex
print "<img src='$img' class='hex' style='zindex:99;$style'>\n";

            }
            ?>
            </div>

            <a href="/auth/logout">kijelentkezés</a><br>


</body>
</html>                            
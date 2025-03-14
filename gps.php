<?php

function getCenterLatLng($coordinates)
{
    $x = $y = $z = 0;
    $n = count($coordinates);
    foreach ($coordinates as $point)
    {
        $lt = $point[0] * pi() / 180;
        $lg = $point[1] * pi() / 180;
        $x += cos($lt) * cos($lg);
        $y += cos($lt) * sin($lg);
        $z += sin($lt);
    }
    $x /= $n;
    $y /= $n;

    return [atan2(($z / $n), sqrt($x * $x + $y * $y)) * 180 / pi(), atan2($y, $x) * 180 / pi()];
}

/* 
** [[lat, lng], [lat, lng], ...]
** Example with Lat/Lng of US Zip codes in San Francisco, CA:
** 94102, 94103, 94104, 94105, 94107, 94108, 94109
*/
$coordinates = [
    [45.7578137, 4.8320114],
    [45.1875602, 5.7357819],
    [44.9003613, 5.0187071]
];

print_r(getCenterLatLng($coordinates));

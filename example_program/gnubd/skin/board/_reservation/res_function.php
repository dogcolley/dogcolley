<?php

function is_season($start,$end)
{
	$start = strtotime($start);
    $end = strtotime($end);

    while ($start <= $end) {
        echo date("Y-m-d", $start);
        $start = strtotime("+1 day", $start);
        
    }
}
?>
<?php

function convertSecToHours($a)
{
    $h = floor($a/3600);
    $m = floor(($a-($h*3600))/60);
    $s = floor($a%60);
    if($h<10)
    {
        $h ="0".$h;
    }
    if($m<10)
    {
        $m = "0".$m;
    }
    if($s<10)
    {
        $s = "0".$s;
    }
    return $h.":".$m.":".$s;
}
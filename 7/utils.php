<?php

function rupiah($price)
{

    $res = "Rp. " . number_format($price, 2, ',', '.');
    return $res;
}

<?php

$connection = mysqli_connect("localhost", "root", "", "audio");

if (!$connection) {
    echo "Error: " . mysqli_connect_error();
    exit();
}

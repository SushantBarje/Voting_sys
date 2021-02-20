<?php
    session_start();

    $data = file_get_contents("store/data.json");
    echo $data;
?>
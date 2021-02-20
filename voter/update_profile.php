<?php
    session_start();
    require "../connection.php";
    include "voter_controller.php";
    $con = connect();

    if($_SERVER["REQUEST_METHOD"] != "POST"){
        die(json_encode(array('error'=>'server')));
    }else{
        
    }
?>
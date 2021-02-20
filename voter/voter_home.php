<?php
    session_start();
    include '../admin/poll/main2.php';

    $con = connect();
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        die(json_encode(array('error' => 'server error')));
    }else{

        $n = new Node();
        if(!($r = $n->retrivePollif())){
            die(json_encode(array('error'=>'no_poll')));
        }else{
            if(!($s = $n->standfor($r->getPollId()))){
                die(json_encode(array('error'=>'no_candidate')));
            }else{
                die(json_encode($s));
            }
        }
    }
    
?>
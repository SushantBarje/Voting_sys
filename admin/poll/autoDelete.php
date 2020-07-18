<?php 
	session_start();
	require "main.php";

	$con = connect();

	if($_SERVER['REQUEST_METHOD'] != "POST"){
		die(json_encode(array('error' => 'server')));
	}else{

		$id = $_POST['data'];

		$o = new Node;
		if($s = $o->retrivePoll($id)){
			echo json_encode($s);
			if($s->deletePoll()){
				die(json_encode(array('error','none')));
			}else{
				die(json_encode(array('error','not_delete')));
			}
		}else{
			die(json_encode(array('error','not_found')));
		}
		
	}

 ?>
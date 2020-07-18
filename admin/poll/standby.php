<?php 

	require 'main.php';

	if($_SERVER['REQUEST_METHOD'] != "POST"){
		die(json_encode(array('error' => 'server')));
	}else{

		$id = $_POST['data'];

		$o = new Node;
		if($r = $o->retrivePoll($id)){
			die(json_encode(array(
				'error' => 'none',
				'id' => $r->getPollId(),
				'start_date' => $r->getStartDate(),
				'start_time' => $r->getStartTime(),
				'end_date' => $r->getEndDate(),
				'end_time' => $r->getEndTime(),
				'status' => $r->getPollStatus(),

			)));
		}else{
			die(json_encode(array('error' => 'no_record_start')));
		}
	}

 ?>
<?php 

	include "main2.php";
	$con = connect();
	if($_SERVER['REQUEST_METHOD'] != "POST"){
		die(json_encode(array('error' => 'server')));
	}else{
		
		if (empty($_POST)){
			die(json_encode(array('error' => 'no_data')));
		}else{
			$id = $_POST['id'];
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
				die(json_encode(array('error' => 'no_data')));
			}
		}
		
	}

 ?>
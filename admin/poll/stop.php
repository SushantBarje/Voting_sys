<?php 
	session_start();
	require 'main2.php';
	$con = connect();
	if($_SERVER['REQUEST_METHOD'] != "POST"){
		die(json_encode(array('error' => 'server')));
	}else{

		$id = $_POST['data'];

		$o = new Node();

		/* if($o->checkPoll("check",2) === false){
			die(json_encode(array('error','already_update')));
		} */

		if($r = $o->retrivePoll($id)){
			date_default_timezone_set("Asia/Kolkata");
			$startd = date("Y-m-d");
			$startt = date("H:i:s");
			if($r->getEndDate() === $startd){
				$sql = "UPDATE poll SET status = 2 WHERE id = $id";
				$result = $con->query($sql);
				if(!$con->affected_rows){
					die(json_encode(array('error'=>'went_worng')));
				}else{
					$pollid = $r->getPollId();
					if(!($o->fileProcess($pollid))){
						die(json_encode(array('error'=>'file')));
					}

					die(json_encode(array(
						'error' => 'none',
						'id' => $r->getPollId(),
						'end_date' => $r->getEndDate(),
						'end_time' => $r->getEndTime(),
						'status' => $r->getPollStatus(),
					)));
				}
			}else{
				//echo json_encode("omert");
			}
		}else{
			die(json_encode(array('error' => 'no_record_start')));
		}
	}
 ?>
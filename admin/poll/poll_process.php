<?php 
	session_start();

	include_once "main.php";

	if($_SERVER['REQUEST_METHOD'] != 'POST'){
		die(json_encode(array('error' => 'server')));
	}

		$candidate = array();
		$isValidate = NULL;

		function validate($check,$type){
			die(json_encode(array($check=>$type)));
		}

		foreach ($_POST as $p) {
			if(empty($p)){
				validate('error','empty');
			}else{
				$isValidate = 1;
			}
		}

		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		function validDate($s,$e,$st,$et){
			date_default_timezone_set("Asia/Kolkata");
			$current_date = date("Y-m-d");	
			$current_time = date("h:i");
			if($s < $current_date){
				validate('error','current');
			}
			if($s == $current_date && $st < $current_time){
				validate('error','current_time');
			}
			if($s > $e){
				validate('error','date');
			}
			if($s === $e && $st > $et){
				validate('error','same');
			}	
		}

		if($isValidate == 1){
			$poll_type = test_input($_POST['poll_type']);
			$start_date = test_input($_POST['start']);
			$start_time = test_input($_POST['stime']);
			$end_date = test_input($_POST['end']);
			$end_time = test_input($_POST['etime']);
			validDate($start_date,$end_date,$start_time,$end_time);
			if(!isset($_POST['candidate'])) validate('error','select');
			foreach($_POST['candidate'] as $p){
				$candidate[] = $p;
			}

			$o = new Node($poll_type,$start_date,$start_time,$end_date,$end_time,$candidate) or validate('error','already');


			if($r = $o->checkPoll("retrive",0)){
				if(!($c = $o->retriveCandidate(1))){
					validate("error",'candidate');
				}
				die(json_encode(array('error' => 'none','status'=>$r->getPollStatus(),'id'=>$r->getPollId(),'type'=>$r->getPollType(),'start_date' => $r->getStartDate(), 'start_time' => $r->getStartTime(), 'end_date' => $r->getEndDate(), 'end_time'=> $r->getEndTime(),$c)));
			}
		}
	
 ?>
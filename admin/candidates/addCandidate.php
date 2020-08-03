<?php
    session_start();
    include_once 'controller.php';
    $con = connect();

    //
    if($_SERVER["REQUEST_METHOD"] != "POST"){
		die(json_encode(array('error'=>'server')));
		mysqli_close($con);
    }else{

		$v_id=$name=$pname=$position="";
		$isValidate= NULL;

		function validate($check,$type){	
			die(json_encode(array($check=>$type)));
			mysqli_close($con);
		}

		foreach($_POST as $p){
			if(empty($p)){
				validate('error','empty');
			}else{
				$isValidate = 1;
			}
		}

		function test_input($data){
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		if($isValidate == 1){
			$v_id = test_input($_POST['v_id']);
			$name = test_input($_POST['c_name']);
			$pname = test_input($_POST['c_pname']);
			$position = test_input($_POST['c_position']);
        }

        $n = new NodeC($v_id,$name,$pname,$position);
		$last_id = mysqli_real_escape_string($con,$n->getCandidateId());
		$r = $n->retriveCandidate($last_id);
        die(json_encode(array('error'=>'none','id'=>$r->getCandidateId(),'vote_id'=>$r->getVoteId(),'name'=>$r->getName(),'p_name'=>$r->getParty(),'position'=>$r->getPosition())));
    }
?>
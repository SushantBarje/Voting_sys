<?php 
	session_start();
	require '../connection.php';

	if($_SERVER['REQUEST_METHOD'] != 'POST'){
		die(json_encode(array('error' => 'server')));
	}else{

		$data = "";
		$isValidate = NULL;

		function test_input($data){
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

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

		if($isValidate == 1){
			$data = test_input($_POST['check']);
		}

		$session = $_SESSION['id'];

		$sql1 = "SELECT * FROM voter_reg WHERE voter_id = $session";
		$result1 = mysqli_query($con,$sql1);

		if(mysqli_num_rows($result1) < 0){
			validate('error','no_result');
		}

		$sql2 = "UPDATE voter_reg SET flag = 1 WHERE voter_id = $session";
		$result2 = mysqli_query($con,$sql2);

		if(!mysqli_affected_rows($con)){
			validate('error','not_affected');
		}

		$sql3 = "SELECT count FROM candidate WHERE candidate_id = $data";
		$result3 = mysqli_query($con,$sql3);

		if(mysqli_num_rows($result3) > 0){
			while($row = mysqli_fetch_assoc($result3)){
				$count = $row['count'];
			}
		}else{
			validate('error','no_result2');
		}


		$sql4 = "UPDATE candidate SET count = $count + 1 WHERE candidate_id = $data";

		$result4 = mysqli_query($con,$sql4);

		if(!mysqli_affected_rows($con)){
			validate('error','not_updated');
		}
		die(json_encode(array('error'=>'none')));
	}
 ?>
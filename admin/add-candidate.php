	<?php 
	session_start();
	require "../connection.php";
	$con = connect();
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

		$sql = "SELECT * FROM candidate WHERE vote_id = ?";

		if(!($stmt = mysqli_stmt_init($con))){
			validate('error','SQL');
		}
		if(!(mysqli_stmt_prepare($stmt,$sql))){
			validate('error','SQL');
		}
		if(!(mysqli_stmt_bind_param($stmt,'s',$v_id))){
			vaildate('error','SQL');
		}
		if(!mysqli_stmt_execute($stmt)){
			validate('error','SQL');
		}
		if(!($result = mysqli_stmt_get_result($stmt))){
			validate('error','SQL');
		}

		if(mysqli_num_rows($result) > 0){
			validate('error','already');
		}else{

			$sql = "INSERT INTO candidate (vote_id,candidate_name,party_name,position) VALUES (?,?,?,?)";
			if(!($stmt = mysqli_stmt_init($con))){
				validate('error','SQL');
			}
			if(!(mysqli_stmt_prepare($stmt,$sql))){
				validate('error','SQL');
			}
			if(!(mysqli_stmt_bind_param($stmt,'ssss',$v_id,$name,$pname,$position))){
				vaildate('error','SQL');
			}
			if(!mysqli_stmt_execute($stmt)){
				validate('error','SQL');
			}
			if(!(mysqli_affected_rows($con))){
				validate('error','insert');
			}else{

				$id = mysqli_insert_id($con);
				

				$sql = "SELECT * FROM candidate WHERE candidate_id = '$id'";
				$result = mysqli_query($con,$sql);
				$count = mysqli_num_rows($result);
			
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$arr = array(
							'error'=>'none',
							'count'=>$count,
							'last_id'=>$id,
							"id" => $row['candidate_id'],
							"vot_id"=>$row['vote_id'],
							"name"=>$row['candidate_name'],
							"p_name"=>$row['party_name'],
							"position"=>$row['position'],
						);
					}
					die(json_encode($arr));
				}
			}

		}
		
	}
	
 ?>	
<?php 
	session_start();
	
	require "../connection.php";
	$con = connect();
	
	if($_SERVER["REQUEST_METHOD"] != "POST"){
		die(json_encode(array('error'=>'server')));
		mysqli_close($con);
	}else{

		$voter_fname=$voter_id=$voter_gender=$voter_email=$voter_password=$confirm_password="";
		$voter_contact=$isValidate= NULL;

		function validate($check,$type){ 
			die(json_encode(array($check=>$type)));
		}

		foreach($_POST as $p){
			if(empty($p)){
				mysqli_close($con);
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
			$voter_fname = test_input($_POST['voter_fname']);
			$voter_id = test_input($_POST['voter_id']);	
			$voter_gender = test_input($_POST['gender']);
			$voter_email = test_input($_POST['voter_email']);
			$voter_contact = test_input($_POST['voter_contact']);
			$voter_password = test_input($_POST['voter_password']);
			$confirm_password = test_input($_POST['confirm_password']);
		}

		
		if($voter_password === $confirm_password){

			//Search if Duplicate is present
				$sql = "SELECT * FROM voter_reg where voter_id = ? AND email = ?";
				$stmt = mysqli_stmt_init($con);
				if(!mysqli_stmt_prepare($stmt,$sql)){
					validate('error','SQL');
					mysqli_close($con);
				}else{
					mysqli_stmt_bind_param($stmt,'ss',$voter_id,$voter_email);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);

					if(mysqli_affected_rows($con)){
						validate('error','already');
					}else{
						$sql = "INSERT INTO voter_reg(fname,voter_id,gender,email,contact,password) VALUES(?,?,?,?,?,?)";

						$stmt = mysqli_stmt_init($con);
							
						if(!mysqli_stmt_prepare($stmt,$sql)){
							validate('error','SQL');
						}else{

							mysqli_stmt_bind_param($stmt,'ssssis',$voter_fname,$voter_id,$voter_gender,$voter_email,$voter_contact,$voter_password);
							mysqli_stmt_execute($stmt);
							
							if(!mysqli_affected_rows($con)){
								validate('error','SQL');
							}
							die(json_encode(array('error'=>'none')));
						}
 					}
				}
			}else{
				validate('error','incorrect');
			}
		}
	
 ?>
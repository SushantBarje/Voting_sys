	<?php 
	session_start();
	require "../connection.php";

	if($_SERVER["REQUEST_METHOD"] != "POST"){
		echo "Error while submiting";
	}else{
		$voter_id=$voter_password ="";
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

		if($isValidate == 1){
			$voter_id = test_input($_POST['voter_id']);
			$voter_password = test_input($_POST['voter_password']);
		}
		

		$sql = "SELECT * FROM voter_reg where voter_id = ? AND password = ?";

		$stmt = mysqli_stmt_init($con);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			echo "SQL Error";
			mysqli_close($conn);
		}else{
			mysqli_stmt_bind_param($stmt,'ss',$voter_id,$voter_password);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			if(!mysqli_affected_rows($con)){
				validate('error','Invalid');
			}else{
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$_SESSION['id'] = $row['voter_id'];
						$_SESSION['password'] = $row['password'];
						echo json_encode(array("error"=>"none"));
					}
				}
 			}
		}
	}
	
 ?>
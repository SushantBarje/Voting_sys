<?php 
	session_start();
	require "../connection.php";
	$con = connect();
	if($_SERVER["REQUEST_METHOD"] != "POST"){
		echo "Error while submiting";
	}else{
		$admin_email=$admin_password ="";
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
			$admin_email = test_input($_POST['admin_email']);
			$admin_password = test_input($_POST['admin_password']);
		}
		

		$sql = "SELECT * FROM admin_login where email = ? AND password = ?";

		$stmt = mysqli_stmt_init($con);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			echo "SQL Error";
			mysqli_close($conn);
		}else{
			mysqli_stmt_bind_param($stmt,'ss',$admin_email,$admin_password);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			if(!mysqli_affected_rows($con)){
				validate('error','Invalid');
			}else{
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$_SESSION['email'] = $row['email'];
						$_SESSION['password'] = $row['password'];
						echo json_encode(array("error"=>"none"));
					}
				}
 			}
		}
	}
	
 ?>
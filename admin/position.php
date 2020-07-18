<?php 	
		session_start();
		require '../connection.php';
		$con = connect();
		if(!$_SERVER["REQUEST_METHOD"] == 'POST'){
				die(json_encode(array('error'=>'server','level'=>'post')));
				mysqli_close($con);
		}else{

			$pos ="";

			function validate($check,$type){
				die(json_encode(array($check => $type)));
				mysqli_close($con);
			}

			function test_input($data){
				$data = trim($data);
				$data = stripcslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			if(empty($_POST)){
				validate('error','empty');
			}else{
				$pos = test_input($_POST['position']);
			}

			$sql = "SELECT * FROM position WHERE pos = ?";
			$stmt = mysqli_stmt_init($con);

			if(!mysqli_stmt_prepare($stmt,$sql)){
				validate('error','SQL');
			}else{
				mysqli_stmt_bind_param($stmt,'s',$pos);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				if(mysqli_num_rows($result) > 0){
					validate('error','already');
				}else{
					$query = "INSERT INTO position (pos) VALUES (?)";

					$stmt = mysqli_stmt_init($con);
					if(!mysqli_stmt_prepare($stmt,$query)){
						validate('error','SQL:1');
					}
					if(!(mysqli_stmt_bind_param($stmt,'s',$pos))){
						validate('error',"bind");
					}
					if(!mysqli_stmt_execute($stmt)){
						validate('error','execute');
					}else{
						 die(json_encode(array("error"=>"none","dat"=>$pos)));
					}

				}
			}
		}
 ?>
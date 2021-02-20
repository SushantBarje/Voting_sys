<?php 

	session_start();
	require "../connection.php";
	$con = connect();
	if($_SERVER['REQUEST_METHOD'] != 'POST'){
		die(json_encode(array('error' => 'server')));
	}else{

		function validate($check,$type){
			die(json_encode(array($check=>$type)));
		}

		$id = $_POST['remove_c'];
	
		if(empty($id)){
			die(json_encode(array('error'=>'empty')));
		}else{

			$sql = "DELETE FROM candidate WHERE candidate_id = ?";

			if(!($stmt = mysqli_stmt_init($con))){
				validate('error','SQL:1');
			}
			if(!(mysqli_stmt_prepare($stmt,$sql))){
				validate('error','SQL:2');
			}
			if(!(mysqli_stmt_bind_param($stmt,'s',$id))){
				validate('error','SQL:3');
			}
			if(!mysqli_stmt_execute($stmt)){
				validate('error','SQL:4');
			}
			if(!(mysqli_affected_rows($con))){
				validate('error','SQL:5');
			}else{

				$sql = "SELECT * FROM candidate";

				$result = mysqli_query($con,$sql);
				$count = mysqli_num_rows($result);

				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$arr[] = $row;
					}

					die(json_encode($arr));
				}else{
					die(json_encode(array('error'=>'no_c')));
				}
			}
		}
	}

 ?>
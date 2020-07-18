<?php 	
	session_start();
	require "../connection.php";

	$session = $_SESSION['id'];

	$sql = "SELECT * FROM candidate WHERE status = 1";
	$result = mysqli_query($con,$sql);

	$arr = [];
	$i = 0;
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$arr[$i] = array(
				'id' => $row['candidate_id'],
				'name' => $row['candidate_name'],
				'party' => $row['party_name'],
				'position' => $row['position'],
			);
			$i++;
		}
	}else{
		echo "error";
	}

	$sql = "SELECT flag FROM voter_reg WHERE voter_id = $session"; 
	$result = mysqli_query($con,$sql);

	$flag = "";
	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			if($row['flag'] == 1){
				$flag = 'none';
			}
		}
	} 
	$arr[$i] = array('error'=>$flag);
	die(json_encode($arr));
	
 ?>
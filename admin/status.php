<?php 

	require "../connection.php";
	$con = connect();
	if($_SERVER["REQUEST_METHOD"] != "POST"){
		die(json_encode(array('error' => 'server')));
	}else{

		$data = $_POST['data'];
		
		if($data == 1){

			$sql = "UPDATE poll SET status = $data;";

			$result = mysqli_query($con,$sql);

			if(!mysqli_affected_rows($con)){
				die(json_encode(array('error' => 'not')));
			}

			$sql = "SELECT * FROM poll";

			$result = mysqli_query($con,$sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$status = $row['status'];
				}
			}

			

			die(json_encode(array('error'=>'none','status' => $status)));
		}

		if($data == 2){
			$sql = "UPDATE poll SET status = $data";

			$result = mysqli_query($con,$sql);

			if(!mysqli_affected_rows($con)){
				die(json_encode(array('error' => 'not')));
			}

			$sql = "SELECT * FROM poll";

			$result = mysqli_query($con,$sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$status = $row['status'];
				}
			}
			die(json_encode(array('error'=>'none','status' => $status)));
		}
	}

 ?>
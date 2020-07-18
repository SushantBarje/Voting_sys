<?php 

	require "../connection.php";

	$sql = "SELECT * FROM poll";
	$result = mysqli_query($con,$sql);

	if(mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_assoc($result)){
			$arr = array(
				'id' => $row['id'],
				'start_date' => $row['start_date'],
				'start_time' => $row['start_time'],
				'end_date' => $row['end_date'],
				'end_time' => $row['end_time'],
				'status' => $row['status'],
				'error' => 'none'
			);	
		}
		die(json_encode($arr));
	}
 ?>
<?php 

	include_once 'main2.php';
	$con = connect();

	if($_SERVER['REQUEST_METHOD'] != "GET"){
		die(json_encode(array('error' => 'server')));
	}else{

		$data = $_GET['data'];
		
		$sql = "DELETE FROM stands_for WHERE poll_id = $data;DELETE FROM poll where id = $data;UPDATE candidate SET status = 0 WHERE status = 1;";
		
		$result = mysqli_multi_query($con,$sql);

		if(!mysqli_affected_rows($con)){
			die(json_encode(array('error' => 'SQL')));
		}
		else{
			$o = new Node();
			die(json_encode(array('error'=>'none')));
		}
	}

 ?>
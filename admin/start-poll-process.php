<?php 	

		session_start();
		require '../connection.php';
		$con = connect();
		if($_SERVER["REQUEST_METHOD"] != "POST"){
				echo json_encode(array('error' => 'server'));
		}else{

			$isValidate = NULL;
			$set = 0;

			function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			function validate($check, $type){
				die(json_encode(array($check => $type)));
			}

			foreach($_POST as $p){
				if(empty($p)){
					die(json_encode(array('error'=>'empty')));
				}else{
					$isValidate = 1;
				}
			}

			if($isValidate == 1){
				$poll_type = test_input($_POST['poll_type']);
				$start_date = test_input($_POST['start']);
				$start_time = test_input($_POST['stime']);
				$end_date = test_input($_POST['end']);
				$end_time = test_input($_POST['etime']);
			}

			$sql = "SELECT * FROM poll";
			$result = mysqli_query($con,$sql);

			if(mysqli_num_rows($result) > 0){
				validate('error','max');
			}else{

			$sql = "INSERT INTO poll (poll_type,start_date,start_time,end_date,end_time) VALUES (?,?,?,?,?)";
		
			if(!($stmt = mysqli_stmt_init($con))){
				validate('error','SQL:init');
			}
			if(!(mysqli_stmt_prepare($stmt,$sql))){
				validate('error','SQL:prepare');
			}
			if(!(mysqli_stmt_bind_param($stmt,'sssss',$poll_type,$start_date,$start_time,$end_date,$end_time))){
				vaildate('error','SQL:bind');
			}
			if(!mysqli_stmt_execute($stmt)){
				validate('error','SQL:execute');
			}else{

				$last_id = mysqli_insert_id($con);

				$sql = "SELECT * FROM poll where id = ?";

				if(!($stmt = mysqli_stmt_init($con))){
					validate('error','SQl:init');
				}
				if(!mysqli_stmt_prepare($stmt,$sql)){
					validate('error','SQL:prepare');
				}
				if(!mysqli_stmt_bind_param($stmt,'i',$last_id)){
					validate('error','SQL:bind');
				}
				if(!mysqli_stmt_execute($stmt)){
					validate('error','SQL:execute');
				}else{
					$result = mysqli_stmt_get_result($stmt);

					while($row = mysqli_fetch_assoc($result)){
						$id = $row['id'];
						$poll_type = $row['poll_type'];
						$sd = strtotime($row['start_date']);
						$st = strtotime($row['start_time']);
						$ed = strtotime($row['end_date']);
						$et = strtotime($row['end_time']);	
						$status = $row['status'];
					}

					$fsd = date("d-m-Y",$sd);
					$fst = date("h:i:sa",$st);
					$fed = date("d-m-Y",$ed);
					$fet = date("h:i:sa",$et);
			}
		}
	}

	$i = 0;
	foreach ($_POST['candidate'] as $key){
		$sql = "UPDATE candidate SET status = 1 where candidate_id = $key";
		$result = mysqli_query($con,$sql);

		if(!mysqli_affected_rows($con)){
			die(json_encode(array('error'=>'SQL')));
		}

		$sql = "SELECT * FROM candidate";
		$result = mysqli_query($con,$sql);
		$arr = [];
		$i = 0;
		if(mysqli_num_rows($result) > 0){
			while($row = mysqli_fetch_assoc($result)){
				$arr[$i++] = array(
					'name' => $row['candidate_name'],
					'party_name' => $row['party_name'],
					'$position' => $row['position']
				);
			}
		}
	}
	
echo json_encode($arr);

	die(json_encode(array(
			'candidate' => $arr,
			'error' => 'none',
			'id' => $id,
			'poll_type' => $poll_type,
			'start_date' => $fsd,
			'start_time' => $fst,
			'end_date' => $fed,
			'end_time' => $fet,
			'set'=> $set,
			'status' => $status
		)));			
	}

 ?>







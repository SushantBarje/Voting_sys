<?php 

	include_once "../connection.php";
	include "delete-poll.php";

	if($_SERVER["REQUEST_METHOD"] != "POST"){
		die(json_encode(array('error' => 'server')));
	}else{

		$data = $_POST['data'];
		$c_id=$c_name=$c_party=$status=$position="";
		
		//When Poll Starts

		if($data == 1){

			$sql = "SELECT status FROM poll";
			$result = mysqli_query($con,$sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$status = $row['status'];
				}
			}
			echo $status;
			if($status == 0){
				$sql = "UPDATE poll SET status = $data;";

				$result = mysqli_query($con,$sql);

				if(!mysqli_affected_rows($con)){
					die(json_encode(array('error' => 'not')));
				}
			}

			if($status == 1){

				$sql = "SELECT * FROM candidate WHERE status = $status";
				$result = mysqli_query($con,$sql);
				if(mysqli_num_rows($result) > 0){
					while($row = mysqli_fetch_assoc($result)){
						$c_id = $row['candidate_id'];
						$c_name = $row['candidate_name'];
						$c_party = $row['party_name'];
						$position = $row['position'];
					}
				}
			}

			die(json_encode(array(
				'error'=>'none',
				'id' => $c_id,
				'name' => $c_name,
				'party' => $c_party,
				'position' => $position,
				'status' => $status
			)));
		}


		/* When Poll Ends*/

		if($data == 2){

			$sql = "SELECT status FROM poll";
			$result = mysqli_query($con,$sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$status = $row['status'];
				}
			}else{
				echo "2nd if";
			}

			if($status == 1){
				$sql = "UPDATE poll SET status = $data";
				$result = mysqli_query($con,$sql);
				if(!mysqli_affected_rows($con)){
					die(json_encode(array('error' => 'not')));
				}else{
					echo "3rd";
				}
			}else{
				echo "4th";
			}

			$sql = "SELECT status from poll";
			$result = mysqli_query($con,$sql);
			if(mysqli_num_rows($result) > 0){
				while($row = mysqli_fetch_assoc($result)){
					$status = $row['status'];
				}
			}

			if($status == 2){
				
				$sql = "SELECT * FROM poll";
				$result = mysqli_query($con,$sql);

				if(mysqli_num_rows($result) > 0){
					echo "done";

					$sql = "SELECT * FROM candidate WHERE status = 1";
					$result = mysqli_query($con,$sql);
					$arr_cand = [];
					$i=0;
					if(mysqli_num_rows($result) > 0){
						while($row = mysqli_fetch_assoc($result)){
							$arr_cand[$i] = array(
								'c_id' => $row['candidate_id'],
								'c_name' => $row['candidate_name'],
								'party' => $row['party_name'],
								'position' => $row['position'],
								'count' => $row['count']
							);
							$i++;
						}
					}else{
						die(json_encode(array('error'=>'no_row')));
					}

					$arr1 = array('candidate' => $arr_cand);

					$sql = "SELECT * FROM poll";
					$result = mysqli_query($con,$sql);
					$id = NULL;
					if(mysqli_num_rows($result) > 0){
						while($row = mysqli_fetch_assoc($result)){
							$id = $row['id'];
							$poll_arr = array(
								'poll_id' => $row['id'],
								'poll_type' => $row['poll_type'],
								'start_date' => $row['start_date'],
								'start_time' => $row['start_time'],
								'end_date' => $row['end_date'],
								'end_time' => $row['end_time'],
								'result' => $arr1, 
							);
						}
					}else{
						echo "7th";
					}
					/*
						CREATE A FILE TO STORE THE EXPIRED RECORDS....

					*/
					if(file_exists('store/data.json')){
						$is = NULL;
						$current_data = file_get_contents('store/data.json');
						$array_data = json_decode($current_data,true);
						if (trim($current_data) == false) {
    						echo "The file is empty too";
    						$array_data[] = $poll_arr;
							$final_data = json_encode($array_data,JSON_PRETTY_PRINT);
						 	if(file_put_contents('store/data.json', $final_data))  
                			{		  
                     			echo "write"; 
                			}else{
                				echo "notwrite";
                			}
						}else{
							foreach($array_data as $key) {
							if($key['poll_id'] == $poll_arr['poll_id']){
								echo "match";
								$is = 0;
								deletePoll();
								break;
							}else{
								$is = 1;
							}
						}
					}
						if($is == 1){
							$array_data[] = $poll_arr;
							$final_data = json_encode($array_data,JSON_PRETTY_PRINT);
						 	if(file_put_contents('store/data.json', $final_data))  
                			{		  
                     			echo "write"; 
                     			deletePoll();
                			}else{
                				echo "notwrite";
                			}
						}
					}
				}else{
					echo "6th";
				}
			}else{
				echo "5th";
			}
		}else{
			echo "1st if";
		}
		die(json_encode(array('error'=>'none','status' => $status)));
	}
 ?>


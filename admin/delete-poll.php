<?php 
	session_start();
	
	function deletePoll(){
		include "../connection.php";

		$sql = "DELETE FROM poll";
		$result = mysqli_query($con,$sql);
		if(!mysqli_affected_rows($con)){
			echo "not deleted";
		}else{
			echo "delete";
		}
	}

	deletePoll();
 ?>
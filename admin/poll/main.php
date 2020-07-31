<?php 
	
include "../../connection.php";

class Node {

	private $poll_id;
	private $poll_type;
	private $start_date;
	private $start_time;
	private $end_date;
	private $end_time;
	private $poll_status;
	private $candidate = array();

    function __construct() {  
      // Allow multiple constructors with different number of arguments
      $a = func_get_args();
      $i = func_num_args();
      if (method_exists($this,$f='__construct'.$i)) {
        call_user_func_array(array($this,$f),$a); 
      }
    }


	function __construct6($poll_type,$start_date,$start_time,$end_date,$end_time,$candidate){
		$this->setPollType($poll_type);
		$this->setStartDate($start_date);
		$this->setStartTime($start_time);
		$this->setEndDate($end_date);
		$this->setEndTime($end_time);
		$this->setCandidate($candidate);
		if($this->insertPoll() === false){
			echo false;
		}
	}


	function retrivePoll($id){
		$con = connect();
		$sql = "SELECT object FROM poll where id = $id";
		$result = $con->query($sql);

		if($con->errno){
			return array('error'=>'connect');
		}else{
			if($result->num_rows > 0){
				$row = $result->fetch_assoc()['object'];
				return unserialize($row);
			}else{
				echo "here";
				return false;
			}
		}
	}

	function checkPoll($f,$s){
		/* ----------------------------------------------------------------------------
			Allows only one Poll is in queue.
			Returns false if poll exists.
			Check if call is for insert or retrive.
		---------------------------------------------------------------------------	
		*/

		$con = connect();
		

		if($con->connect_errno) {
			return false;
		}
		$sql = "SELECT * FROM poll where status = $s";
		$result = $con->query($sql);
		if($con->errno) {
			return false;
		}

		if($f == "insert"){
			if($result->num_rows > 0) {
				return false;
			}
		}else if($f == "retrive"){

			$row = $result->fetch_assoc();
			$this->poll_id = $row['id'];
			$this->poll_type = $row['poll_type'];
			$this->start_date = $row['start_date'];
			$this->start_time = $row['start_time'];
			$this->end_date = $row['end_date'];
			$this->end_time = $row['end_time'];
			$this->poll_status = $row['status'];

			return $this;

		}else if($f == "check"){
			if($result->num_rows > 0){
				return false;
			}else{
				return true;
			}
		}

		return $this;
	}

	function insertPoll(){

		$con = connect();

		$poll_type = $this->getPollType();
		$start_date = $this->getStartDate();
		$start_time = $this->getStartTime();
		$end_date = $this->getEndDate();
		$end_time = $this->getEndTime();
		$candidate = $this->getCandidate();

		if($this->checkPoll("insert",0) === false){
			die('checkpoll');
			return false;
		}

		$object = serialize($this);
		echo $object;
		$sql = "INSERT INTO poll (poll_type,start_date,start_time,end_date,end_time,object) VALUES(?,?,?,?,?,?);";
		
			if(!($stmt = mysqli_stmt_init($con))){
				return false;
			}
			if(!(mysqli_stmt_prepare($stmt,$sql))){
				return false;
			}
			if(!(mysqli_stmt_bind_param($stmt,'ssssss',$poll_type,$start_date,$start_time,$end_date,$end_time,$object))){
				die('bind');
				return false;
			}
			if(!mysqli_stmt_execute($stmt)){
				die('execute');
				return false;
			}else{
				$last_id = mysqli_insert_id($con);

				foreach($candidate as $p){
					$sql = "UPDATE candidate SET status = 1 WHERE candidate_id = $p";
					$result = $con->query($sql);
					if(!mysqli_affected_rows($con)){
						return false;
					}
				}		
				return true;
			}		
		}

	function deletePoll(){

		/*
			Delete the Poll Which are Expired..
		*/
		$con = connect();

		if($con->connect_errno){
			return false;
		}else{

			$id = $this->getPollId();

			$sql = 'DELETE FROM poll WHERE poll_id = "'.$id.'"';
			$result = $con->query($sql);

			if($result && $con->affected_rows){
				return true;
			}else{
				return false;
			}
		}
		
	}

	function retriveCandidate($status){

		/*
			Retrive the Candidate with there status;
			Return false if No Candidate is Selected;
		*/

		$con = connect();
		$obj = array();
		$sql = "SELECT * FROM candidate where status = $status";
		$result = $con->query($sql);

		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$obj[] = array(
					'id' => $row['candidate_id'],
					'name' => $row['candidate_name'],
					'party_name' => $row['party_name'],
					'position' => $row['position'],
					'status' => $row['status'],
					'count' => $row['count'],
				);
			}
			return $obj;
		}else{
			return false;
		}
	}


	function checkPollinit(){

		/*
			Check If Poll is present.
			Generally This Query trigger when page is load.
		*/

		$con = connect();
		$sql = "SELECT * FROM poll";
		$result = $con->query($sql);

		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			$this->poll_id = $row['id'];
			$this->poll_type = $row['poll_type'];
			$this->start_date = $row['start_date'];
			$this->start_time = $row['start_time'];
			$this->end_date = $row['end_date'];
			$this->end_time = $row['end_time'];
			$this->poll_status = $row['status'];

			return $this;

		}else{
			return false;
		}
	}

/*
-------------------------------------------------------------
	//SETTERS
-------------------------------------------------------------
*/

public function setPollType($v){
	$this->poll_type = $v;
}

public function setStartDate($v){
	$this->start_date = $v;
}

public function setStartTime($v){
	$this->start_time = $v;
}

public function setEndDate($v){
	$this->end_date = $v;
}

public function setEndTime($v){
	$this->end_time = $v;
}

public function setCandidate(array $v = []){
	foreach($v as $s){
		$this->candidate[] = $s;
	}
}

/*
----------------------------------------------------------------
	//GETTERS
----------------------------------------------------------------
*/

public function getPollId(){
	return $this->poll_id;
}

public function getPollType(){
	return $this->poll_type;
}

public function getStartDate(){
	return $this->start_date;
}

public function getStartTime(){
	return $this->start_time;
}

public function getEndDate(){
	return $this->end_date;
}

public function getEndTime(){
	return $this->end_time;
}

public function getCandidate(){
	return $this->candidate;
}

public function getPollStatus(){
	return $this->poll_status;
}

}

?>
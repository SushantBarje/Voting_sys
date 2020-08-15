<?php 
	
include_once "define.php";

class Node{

	private $poll_id;
	private $poll_type;
	private $start_date;
	private $start_time;
	private $end_date;
	private $end_time;
    private $poll_status;
    private $lastid;
    private $nominee;
    private $candidate = array();
    private $polls = array();

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
    }


    public function validate($e,$t){
        return array($e => $t);
    }

    /* THIS is to check wheather there is poll already present in database
        if yes->return false
        else -> call insertPoll()
    */
    public function checkPoll(){
        $sql = "SELECT * FROM poll";
        $result = $con->query($sql);
        if($result->num_rows > 0){
            return false;
        }else{
            return true;
        }
    }

    /* 
        Method For Updating or Insert the new Poll.
        This also check whether the is poll in queue 
        If->TRUE: Return False;
        Else insert poll;   
    */
    public function insertPoll(){
        $con = connect();
        if($con->connect_errno){
            return $this->validate('error','server');
        }

        $poll_type = $this->getPollType();
		$start_date = $this->getStartDate();
		$start_time = $this->getStartTime();
		$end_date = $this->getEndDate();
		$end_time = $this->getEndTime();
        $candidates = $this->getCandidate();

        if($this->checkPoll() == false){
            return $this->validate('error','already');
        }else{
            $sql = "SELECT * FROM poll WHERE poll_type = ? AND start_date = ? AND start_time = ? AND end_date = ? AND end_time = ?";
            if(!($stmt = $con->prepare($sql))){
                echo "2;";
            }
            if(!$stmt->bind_param('sssss',$poll_type,$start_date,$start_time,$end_date,$end_time)){
                echo "3;";
            }
            if(!$stmt->execute()){
                echo "4;";
            }
            $result = $stmt->get_result();
            $stmt->close();
            if($result->num_rows > 0){
                $sql = "UPDATE poll SET poll_type = ?, start_date = ?, start_time = ?, end_date = ?, end_time = ?";
                if(!($stmt = $con->prepare($sql))){
                    echo "5;";
                }
                if(!$stmt->bind_param('sssss',$poll_type,$start_date,$start_time,$end_date,$end_time)){
                    echo "6;";
                }
                if(!$stmt->execute()){
                    echo "7;";
                }
                
                $stmt->close();
            }else{
                $sql = "SELECT * FROM poll";
                $result = $con->query($sql);
                if($result->num_rows > 0){
                    echo "8;";
                }
    
                $sql = "INSERT INTO poll(poll_type,start_date,start_time,end_date,end_time) VALUES(?,?,?,?,?);";
                if(!($stmt = $con->prepare($sql))){
                    echo "9;";
                }
                if(!$stmt->bind_param('sssss',$poll_type,$start_date,$start_time,$end_date,$end_time)){
                    echo "10;";
                }
                if(!$stmt->execute()){
                    echo "11;";
                }
                if($con->errno){
                    return false;
                }else{
                    $last_id = $con->insert_id;
                    $this->setPollLastId($last_id);
                    $id = $this->getPollLastId();
                    foreach($candidates as $candidate){
                        $sql = "INSERT INTO stands_for(poll_id,candidate_id) VALUES(?,?)";
                        if(!($stmt = $con->prepare($sql))){
                            echo "12;";
                        }
                        if(!$stmt->bind_param('ss',$id,$candidate)){
                            echo "13;";
                            
                        }
                        if(!$stmt->execute()){
                            echo "14;";
                        }
                    }           
                }
                if($con->errno){
                    return false;
                }else{
                    return true;
                }
                $stmt->close();
            }
        }
    return false;
    }

    public function retrivePoll($id){
        $con = connect();
        if($con->connect_errno){
            return false;
        }else{
            $id = mysqli_real_escape_string($con,$id);
            // $sql = "SELECT * FROM stands_for as a JOIN candidate as b ON a.candidate_id = b.candidate_id AND a.poll_id = ? JOIN poll as c ON a.poll_id = c.poll_id AND c.id = ? JOIN position as d ON d.position_id = b.position";
            $sql = "SELECT * FROM poll WHERE id = ?";
            if(!($stmt = $con->prepare($sql))){
                echo "15;";
            }
            if(!$stmt->bind_param('s',$id)){
                echo "16;";
            }
            if(!$stmt->execute()){
                echo "17;";
            }
            $result = $stmt->get_result();
            $count = $result->num_rows;
            if($result->num_rows){
                while($row = $result->fetch_assoc()){
                    $this->setPollId($row['id']);
                    $this->setPollType($row['poll_type']);
                    $this->setStartDate($row['start_date']);
                    $this->setStartTime($row['start_time']);
                    $this->setEndDate($row['end_date']);
                    $this->setEndTime($row['end_time']);
                    $this->setPollStatus($row['status']);
                }
            }

            if($con->errno){
                return false;
            }else{
                return $this;
            }
        }          
        return false; 
    }

/*
-------------------------------------------------------------
	//SETTERS
-------------------------------------------------------------
*/

public function setPollId($v){
    $this->poll_id = $v;
}

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

public function setPollLastId($v){
    $this->lastid = $v;
}

public function setNominee($v){
    $this->nominee = $v;
}


public function setPollStatus($v){
    $this->poll_status = $v;
}

public function setPoll(){
    $con = connect();
    $sql = "SELECT * FROM poll";
    $result = $con->query($sql);
    if($result && $result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $this->polls[] = $row['id'];
        }
    }else{
        return false;
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

public function getPollLastId(){
    return $this->lastid;
}

public function getNominee(){
    return $this->nominee;
}

public function getPoll(){
    return $this->polls;
}
}

?>
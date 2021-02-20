<?php

include_once 'define.php';
class NodeC{

    private $candidate_id;
    private $vote_id;
    private $candidate_name;
    private $party_name;
    private $position;
    private $addpos;
    private $pos_id;
    private $pos = array();
    private $canidates = array();
    public $error = array();

    function __construct() {  
        // Allow multiple constructors with different number of arguments
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
          call_user_func_array(array($this,$f),$a); 
        }
      }
  
    /* Constructor for Managing Candidates*/
    function __construct4($id,$name,$party,$pos){
        $this->setVoteId($id);
        $this->setName($name);
        $this->setParty($party);
        $this->setPosition($pos);
        if($this->insertCandidate() === false){
            echo false;
        }
    }

    /* Constructor for Managing Position */
    function __construct1($addpos){
        $this->setAddPosition($addpos);
        if($this->managePosition() === false){
            echo false;
        }
    }
    /*
        Return an array of error while performing opration.
    */ 
    public function validate($e,$t){
        return array($e => $t);
    }

    /* 
        Method to UPDATE the Candidate Details if already Present.
        Else insert the Candidate into Database.
    */
    public function insertCandidate(){
        $con = connect();
        if($con->connect_errno){
            return false;
        }
        $id = $this->vote_id;
        $name = $this->candidate_name;
        $party = $this->party_name;
        $position = $this->position;
        $sql = "SELECT * FROM candidate WHERE vote_id = ?";
        if(!($stmt = $con->prepare($sql))){
            $err = $this->validate('error','prepare1');
            return $err;
        }
        if(!$stmt->bind_param('s',$id)){
            $err = $this->validate('error','bind1');
            return $err;
        }
        if(!$stmt->execute()){
            $err = $this->validate('error','execute1');
            return $err;
        }
        $result = $stmt->get_result();
        $stmt->close();
        if($result->num_rows){
            $sql = "UPDATE candidate SET candidate_name = ?, party_name = ?, position = ? WHERE vote_id = ?";
            if(!($stmt = $con->prepare($sql))){
                $err = $this->validate('error','prepare2');
                return $err;
            }
            if(!$stmt->bind_param('ssss',$name,$party,$position,$id)){
                $err = $this->validate('error','bind2');
                return $err;
            }
            if(!$stmt->execute()){
                $err = $this->validate('error','execute2');
                return $err;
            }
            $stmt->close();
        }else{
            $sql = "INSERT INTO candidate(vote_id,candidate_name,party_name,position,obj) VALUES(?,?,?,?,?)";
            if(!($stmt = $con->prepare($sql))){
                $err = $this->validate('error','prepare2');
                return $err;
            }
            $obj = $con->real_escape_string(serialize($this));
            if(!$stmt->bind_param('sssss',$id,$name,$party,$position,$obj)){
                $err = $this->validate('error','bind2');
                return $err;
            }
    
            if(!$stmt->execute()){
                $err = $this->validate('error','execute2');
                return $err;
            }
        }
        if($con->errno){
            return false;
        }else{
            $this->setCandidateId($con->insert_id);
            return true;
        }
        return false;
    }

    /* Retirve Candidate With Valid Candidate Id.*/
    public function retriveCandidate($c_id){
        $con = connect();
        $c_id = mysqli_real_escape_string($con,$c_id);
        $sql = "SELECT a.candidate_id,a.vote_id,a.candidate_name,a.party_name,b.pos FROM candidate as a JOIN position as b ON a.candidate_id = $c_id AND a.position = b.position_id";
        $result = $con->query($sql);
        $count = $result->num_rows;
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $this->setCandidateId($row['candidate_id']);
                $this->setVoteId($row['vote_id']);
                $this->setName($row['candidate_name']);
                $this->setParty($row['party_name']);
                $this->setPosition($row['pos']);
            }
            return $this;
        }
    }


    /* Manages Position if already present Update it Else Insert into the Database.*/
    public function managePosition(){

        $con = connect();
        if($con->connect_errno){
            return $this->validate('error','connect');
        }
        $pos = $this->addpos;
        $sql = "SELECT * FROM position WHERE pos = ?";
        if(!($stmt = $con->prepare($sql))){
            return $this->validate('error','prepare1');
        }

        if(!$stmt->bind_param('s',$pos)){
            return $this->validate('error','bind1');
        }

        if(!$stmt->execute()){
            return $this->validate('error','execute1');
        }
        $result = $stmt->get_result();
        $id = $result->fetch_assoc['id'];
        $stmt->close();
        if($result->num_rows){
            $sql = "UPDATE position SET pos = ? WHERE position_id = ?";
            if(!($stmt = $con->prepare($sql))){
                return $this->validate('error','prepare2');
            }
    
            if(!$stmt->bind_param('ss',$pos,$id)){
                return $this->validate('error','bind2');
            }
    
            if(!$stmt->execute()){
                return $this->validate('error','execute2');
            }
            $stmt->close();
        }else{
            $sql = "INSERT INTO position(pos) VALUES(?)";
            if(!($stmt = $con->prepare($sql))){
                return $this->validate('error','prepare2');
            }
            if(!$stmt->bind_param('s',$pos)){
                return $this->validate('error','bind2');
            }
    
            if(!$stmt->execute()){
                return $this->validate('error','execute2');
            } 
        }
        if($con->errno){
            return false;
        }else{
            return true;
        }
        return false;
    }

    /* Retrive Position Based on Id*/
    public function retrivePosition($pos_id){
        $con = connect();
        echo $pos_id;
        if($con->connect_errno){
            return $this->validate('error','connect');
        }else{
            $pos_id = mysqli_real_escape_string($con,$pos_id);
            $sql = "SELECT * FROM position WHERE position_id = $pos_id";
            $result = $con->query($sql);
            $count = $result->num_rows;
            if($result->num_rows > 0){  
                while($row = $result->fetch_assoc()){
                    $this->setPosId($row['position_id']);
                    $this->setAddPosition($row['pos']);
                }
                return $this;
            }
        }
    }

    //Setter

    public function setCandidateId($v){
        $this->candidate_id = $v;
    }

    public function setVoteId($v){
        $this->vote_id = $v;
    }

    public function setName($v){
        $this->candidate_name = $v;
    }

    public function setParty($v){
        $this->party_name = $v;
    }

    public function setPosition($v){
        $this->position = $v;
    }

    public function setCandidates(){
        $con = connect();
        if($con->connect_errno){
            return $this->validate('error','connect');
        }
        $sql = "SELECT candidate_id FROM candidate";
        $result = $con->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $this->candidates[] = $row['candidate_id'];
            }
        }else{
            return false;
        }
    }

    public function setAddPosition($v){
        $this->addpos = $v;
    }

    public function setPos(){
        $con = connect();
        if($con->connect_errno){
            return $this->validate('error','connect');
        }
        $sql = "SELECT * FROM position";
        $result = $con->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $this->pos[] = $row['position_id'];
            }
        }else{
            return false;
        }
    }

    public function setPosId($v){
        $this->pos_id = $v;
    }
    
    //Getter

    public function getCandidateId(){
        return $this->candidate_id;
    }

    public function getVoteId(){
        return $this->vote_id;
    }

    public function getName(){
        return $this->candidate_name;
    }

    public function getParty(){
        return $this->party_name;
    }

    public function getPosition(){
        return $this->position;
    }

    public function getCandidates(){
        return $this->candidates;
    }

    public function getAddPosition(){
        return $this->addpos;
    }

    public function getPos(){
        return $this->pos;
    }

    public function getPosId(){
        return $this->pos_id;
    }
};

?>
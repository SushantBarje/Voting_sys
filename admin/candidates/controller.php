<?php

require "../../connection.php";

class NodeC{

    private $candidate_id;
    private $vote_id;
    private $candidate_name;
    private $party_name;
    private $position;
    private $canidates = array();

    function __construct() {  
        // Allow multiple constructors with different number of arguments
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i)) {
          call_user_func_array(array($this,$f),$a); 
        }
      }
  
  
    function __construct4($id,$name,$party,$pos){
        $this->setVoteId($id);
        $this->setName($name);
        $this->setParty($party);
        $this->setPosition($pos);
        if($this->insertCandidate() === false){
            echo false;
        }
    }

    /* 
        Method to Insert Candidate into database
    */

    public function validate($e,$t){
        return array($e => $t);
    }

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
            $this->validate('error','prepare1');
        }

        if(!$stmt->bind_param('s',$id)){
            $this->validate('error','bind1');
        }

        if(!$stmt->execute()){
            $this->validate('error','execute1');
        }
        $result = $stmt->get_result();
        $stmt->close();
        if($result->num_rows){
            $sql = "UPDATE candidate SET candidate_name = ?, party_name = ?, position = ? WHERE vote_id = ?";
            if(!($stmt = $con->prepare($sql))){
                $this->validate('error','prepare2');
            }
    
            if(!$stmt->bind_param('ssss',$name,$party,$position,$id)){
                $this->validate('error','bind2');
            }
    
            if(!$stmt->execute()){
                $this->validate('error','execute2');
            }
            $stmt->close();
        }else{
            $sql = "INSERT INTO candidate(vote_id,candidate_name,party_name,position,obj) VALUES(?,?,?,?,?)";
            if(!($stmt = $con->prepare($sql))){
                $this->validate('error','prepare2');
            }
            $obj = $con->real_escape_string(serialize($this));
            if(!$stmt->bind_param('sssss',$id,$name,$party,$position,$obj)){
                $this->validate('error','bind2');
            }
    
            if(!$stmt->execute()){
                $this->validate('error','execute2');
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

    public function retriveCandidate($c_id){
        $con = connect();
        
        $sql = "SELECT * FROM candidate where candidate_id = $c_id";
        $result = $con->query($sql);
        $count = $result->num_rows;
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $this->setCandidateid($row['candidate_id']);
                $this->setVoteId($row['vote_id']);
                $this->setName($row['candidate_name']);
                $this->setParty($row['party_name']);
                $this->setPosition($row['position']);
            }
            return $this;
        }
    }

    public function retriveCandidateall(){
        $con = connect();
        if($con->connect_errno){
            $this->validate('error','server');
        }
        $sql = "SELECT * FROM candidiate";
        $result = $con->query($sql);
        if($result->num_rows > 0){
            $arr[] = array(
                'id'=> $row['canidate_id'],
                'vote_id' => $row['vote_id'],
                'name' => $row['candidate_name'],
                'party' => $row['party_name'],
                'position' => $row['position'],
                'status' => $row['status'],
                'count' => $row['count'],
            );
        }else{
            $this->validate('error','no_records');
        }
        if($con->errno){
            $this->validate('error','no');
        }else{
            return $arr;
        }
        return false;
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

};

?>
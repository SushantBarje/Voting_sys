<?php
    
    include "admin/candidates/controller.php";

    class Node extends NodeC{

        private $voter_id;
        private $fullname;
        private $gender;
        private $email;
        private $contact;

        function __construct() {  
            // Allow multiple constructors with different number of arguments
            $a = func_get_args();
            $i = func_num_args();
            if (method_exists($this,$f='__construct'.$i)) {
              call_user_func_array(array($this,$f),$a); 
            }
        }
          
        function __construct6($voter_id,$fullname,$gender,$email,$contact){
            $this->setVoterId($voter_id);
            $this->setFullname($fullname);
            $this->setGender($gender);
            $this->setEmail($email);
            $this->setContact($contact);
        }

        /*
            Return an array of error while performing opration.
        */ 
        public function validate($e,$t){
            return array($e => $t);
        }


        public function checkVoter(){
            $con = connect();

            $id  = $this->voter_id;
            $fullname = $this->fullname;
            $gender = $this->gender;
            $email = $this->email;
            $contact = $this->contact;

            $sql = "SELECT * FROM voter_reg WHERE voter_id = ?";
            if(!($stmt = $con->prepare($sql))){
                $err = $this->validate("error", "prepare1");
                return $err;
            }
            if(!$stmt->bind_param('s',$id)){
                $err = $this->validate("error","prepare2");
                return $err;
            }
            if(!$stmt->execute()){
                $err = $this->validate('error','execute1');
                return $err;
            }
            $result = $stmt->get_result();
            $stmt->close();
            if($result->num_rows){
                $err = $this->validate('error','already');
                return $err;
                $stmt->close();
            }
            else{
                return true;
            } 
        }

        public function insertVoter(){
            $con = connect();

            $id  = $this->voter_id;
            if($this->checkVoter($id)){
                $fullname = $this->fullname;
                $gender = $this->gender;
                $email = $this->email;
                $contact = $this->contact;

                $sql = "INSERT INTO voter(fname,voter_id,gender,email,contact)";
                if(!($stmt = $con->prepare($sql))){
                    $this->validate('error','prepare');
                }
                if(!$stmt->bind_param('ssssi',$fullname, $gender, $email, $contact)){
                    $this->validate('error','bind');
                }
                if(!$stmt->execute()){
                    $this->validate('error','execute');
                }
            }
            if($con->errno){
                return false;
            }else{
                $this->setVoterId($con->insert_id);
                return true;
            }
            return false;
        }

        public function updateVoter(){
            $con = connect();

            
        }

        public function retriveVoter($id){
            $con = connect();
            
            $this->setVoterId($id);
            $voter_id = $this->getVoterId();
            $voter_fullname = $this->getFullName();
            $voter_gender = $this->getGender();
            $voter_email = $this->getEmail();
            $voter_contact =  $this->getContact();

            $sql = "SELECT * FROM voter_reg WHERE voter_id = ?";

            if(!($stmt = $con->prepare($sql))){
                $err = $this->validate('error','prepare');
            }
            if(!$stmt->bind_param('s',$voter_id)){
                $err = $this->validate('error','bind');
            }
            if(!$stmt->execute()){
                $err = $this->validate('error','execute');
            }
            $result = $stmt->get_result();
            $stmt->close();
            if($result->num_rows){
                while($row = $result->fetch_assoc()){
                    $this->setVoterId($row['voter_id']);
                    $this->setFullName($row['fname']);
                    $this->setGender($row['gender']);
                    $this->setEmail($row['email']);
                    $this->setContact($row['contact']);
                }
                return $this;
            }
        }

//Setters
        public function setVoterId($v){
            $this->voter_id = $v;
        }

        public function setFullName($v){
            $this->fullname = $v;
        }

        public function setGender($v){
            $this->gender = $v;
        }

        public function setEmail($v){
            $this->email = $v;
        }

        public function setContact($v){
            $this->contact = $v;
        }

        //Getters
        public function getVoterId(){
            return $this->voter_id;
        }

        public function getFullName(){
            return $this->fullname;
        }

        public function getGender(){
            return $this->gender;
        }

        public function getEmail(){
            return $this->email;
        }

        public function getContact(){
            return $this->contact;
        }
    }

?>
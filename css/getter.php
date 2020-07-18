<?php 

	class Node{

		private $name;
		private $roll;

		public function setName($name){
			$this->name = $name;
		}

		public function setRoll($roll){
			$this->roll = $roll;
		}

		public function getName(){
			return $this->name;
		}

		public function getRoll(){
			return $this->roll;
		}
	}

	$node = new Node();
	$node->setName('Sushant');
	$node->setRoll(12);
	
	echo $node->getName();
	echo $node->getRoll();

 ?>
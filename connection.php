<?php 
function connect(){
 	$host = 'localhost';
 	$username = 'root';
 	$password = '';
 	$database = 'voting';

 	
 		$con = mysqli_connect($host,$username,$password,$database);

 		if(!$con){
 			$con->close();
 		}

 		return $con;
 	}
 ?>	
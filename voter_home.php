<?php 
	session_start();
	if(!isset($_SESSION['voter_id'])){
		header('Location:index.php');
	}else{
		$id = $_SESSION['voter_id'];
	}
 ?>

 <?php
	include "voter/voter_controller.php";
	$n = new Node;
	$con = connect();
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<script type="" src="js/jquery.min.js"></script>
	<script src="js/voter-home.js"></script>
	<script type="" src="js/poll/timer.js"></script> 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/css/layout.css">
</head>
<body>
	<div class="container-fluid">
		<div class="header">
			<h2>Online Voting System</h2>
			<div class="navbar">
				<ul>
					<li><a href="voter_home.php">Home</a></li>
					<li><a href="voter_profile.php">Profile</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>	
		</div>
	</div>
	<div class="container">
		<div class="main">
			<h2 id="demo"></h2>
			<h2 id="demo2"></h2>
			<h2>Vote Meter</h2>
			<ol>
				<li>Below is the list of Candidate.</li>
				<li>Voter can give <strong>Only one vote from all.</strong></li>
			</ol>
			<div><h2 id="message"></h2></div>
			<form id="vote-form">
				<table class="table table-hover" border="1" id="vote-meter">	
					<thead>
						<th>Candidate ID</th>
						<th>Party Name</th>
						<th>Candidate Name</th>
						<th>Position</th>
						<th>Vote</th>
					</thead>
					<tbody id="vote-table">
					<?php
						if($n->setCandidates() === false) die('<tr><td colspan="5">No Candidates</td</tr>');
						$candidates = $n->getCandidates();
						foreach($candidates as $candidate){
							$data = $n->retriveCandidate($candidate);
							$id = $data->getCandidateId();
							$name = $data->getName();
							$party = $data->getParty();
							$position = $data->getPosition();
							echo '
								<tr>
									<td>'.$id.'</td>
									<td>'.$party.'</td>
									<td>'.$name.'</td>
									<td>'.$position.'</td>
									<td><input type="checkbox" name="vote"></td>
								</tr>
							';
						}
					?>
					</tbody>
				</table>
					<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</body>
</html>



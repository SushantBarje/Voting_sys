<?php 
	session_start();
	require 'connection.php';
	$con = connect();
	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}else{
		$email = $_SESSION['email'];
	}

 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Manage Voter</title>
 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"></script>
 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.js"></script>
 	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
					<li><a href="home.php">Home</a></li>
					<li>Poll
						<ul>
							<li><a href="poll.php">Start Poll</a></li>
							<li><a href="#">Last Poll</a></li>
						</ul>
					</li>
					<li><a href="manage_candidate.php">Manage Candidates</a></li>
					<li><a href="manage_voter.php">Manage Voter</a></li>
					<li><a href="logout.php">Log Out</a></li>
					<li> <a href="#">Welcome, <?php echo $email ?></a></li>
				</ul>
			</div>
			
		</div>
		<div class="main">
			<h2>Manage Voter</h2>
			<table id="voter-table" border="1">
				<thead>
					<th>Voter ID</th>
					<th>Full Name</th>
					<th>Voter ID</th>
					<th>Gender</th>
					<th>Email</th>
					<th>Contact No.</th>
				</thead>
				<tbody>	
					<?php 	
						$sql = "SELECT * FROM voter_reg";

						$result = mysqli_query($con,$sql);

						if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)){
								echo "<tr>
										<td>".$row['id']."</td>
										<td>".$row['fname']."</td>
										<td>".$row['voter_id']."</td>
										<td>".$row['gender']."</td>
										<td>".$row['email']."</td>
										<td>".$row['contact']."</td>
									</tr>";
							}
						}
					 ?>
				</tbody>
			</table>
		</div>
 	</div>
 </body>
 </html>
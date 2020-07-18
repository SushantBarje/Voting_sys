<?php 

	session_start();
	if(!isset($_SESSION['email'])){
		include 'connection.php';
		$con = connect();
		header('Location: index.php');
	}else{
		$email = $_SESSION['email'];
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin Home</title>
 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"></script>
 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.js"></script>
 	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="header">
			<h2>Online Voting System</h2>
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
			</ul>
		</div>
		<div class="main">
			<h2>Welcome, <?php echo $email ?></h2>
			<div class="edit-admin">
				<form id="admin-edit-profile">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="text" name="ad_email" value=<?php echo $email ?>> 
					</div>

					<!-- for password change -->
				</form>
			</div>
		</div>
	</div>
</body>
</html>



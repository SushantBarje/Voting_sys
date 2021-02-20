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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/css/layout.css">
	<link rel="stylesheet" href="css/css/admin/home.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
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
							<li><a href="last_poll.php">Last Poll</a></li>
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
			<div class="row">
				<div class="col-sm-1"></div>
				<div class="col-sm-10">
					
				</div>
				<div class="col-sm-2"></div>
			</div>
			<div class="row mt-5">
				<div class="col-sm-4"></div>
				<div class="col-sm-4">
					<div class="edit-admin">
						<form id="admin-edit-profile">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="text" class="form-control" name="ad_email" value=<?php echo $email ?>> 
							</div>
							
							<!-- for password change -->
						</form>
					</div>
				</div>
				<div class="col-sm-4"></div>
			</div>
			
		</div>
	</div>

	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>



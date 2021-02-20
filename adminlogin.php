<?php  
	session_start();
	if(isset($_SESSION['email'])){
		header('location:home.php');
	}
?>

<!DOCTYPE html>
<html>
<head>	
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/admin-login-auth.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/css/layout.css">
	<link rel="stylesheet" href="css/css/admin/adminlogin.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>
	<div class="container-fluid">
		<div class="header">
			<h2>Voting System</h2>
			<div class="navbar">
				<ul>
					<li><a href="index.php">Home</a></li>
					<li>Log In
						<ul>
							<li><a href="adminlogin.php">Admin</a></li>
							<li><a href="voterlogin.php">Voter</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<div class="alert alert-danger hidden" id="alert" style="visibility:hidden">
      		<span class="message"></span>
      		<button type="button" class="close" onclick="$('.alert').css('visibility','hidden');">&times;</button>
    	</div>
		<div class="login-form">
			<h2>Admin Log In</h2>
			<form id="admin-login" method="post">
				<div class="form-group col-sm-12">
					<label for="admin_email">Email:</label>
					<div class="form-input">
						<input type="email" class="form-control shadow-none" name="admin_email" placeholder="Enter Email">
					</div>
				</div>
				<div class="form-group col-sm-12">
					<label for="admin_password">Password:</label>
					<div class="form-input">
						<input type="password" class="form-control shadow-none" name="admin_password" placeholder="Enter Password">
					</div>
				</div>
				<div class="admin-login-btn">
					<button type="submit" class="btn btn-primary shadow-none" name="admin-login-submit" id="admin-login-submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>	
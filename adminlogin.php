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
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"></script>
 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.js"></script>
 	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/admin-login-auth.js"></script>

</head>
<body>
	<div class="container">
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
		<span class="message"></span>
		<div class="login-form">
			<form id="admin-login" method="post">
				<div class="form-group">
					<label for="admin_email">Email:</label>
					<div class="form-input">
						<input type="email" name="admin_email" placeholder="Enter Email">
					</div>
				</div>
				<div class="form-group">
					<label for="admin_password">Password:</label>
					<div class="form-input">
						<input type="password" name="admin_password" placeholder="Enter Password">
					</div>
				</div>
				<div class="admin-login-btn">
					<button type="submit" name="admin-login-submit" id="admin-login-submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
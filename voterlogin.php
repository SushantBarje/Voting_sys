<?php 
	session_start();
	if(isset($_SESSION['voter_id'])){
		header('Location:voter_home.php');
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
	<title>Voter Log In</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 	<script type="text/javascript" src="js/jquery.min.js"></script>
 	<script type="text/javascript" src="js/voter-login.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/css/layout.css">
	<link rel="stylesheet" href="css/css/voter/voterlogin.css">
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
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-3">
				<div class="login-form">
					<h2>Voter Log In</h2>
					<form id="voter-login" method="post">
						<div class="form-group">
							<label for="voter_id">Voter ID:</label>
							<div class="form-input">
								<input type="text" class="form-control shadow-none" name="voter_id" placeholder="Enter Voter ID">
							</div>
						</div>
						<div class="form-group">
							<label for="voter_password">Password:</label>
							<div class="form-input">
								<input type="password" class="form-control shadow-none" name="voter_password" placeholder="Enter Password">
							</div>
						</div>
						<div class="voter-login-btn">
							<button type="submit" class="btn" name="voter_login_submit" id="voter-login-submit">Log In</button>
						</div>
					</form>
					<div class="form-footer">
						<a href="#">Forget Password?</a>
					</div>
				</div>
			</div>
			<div class="col-sm-3"></div>
			<div class="col-sm-4">
				<div class="signup-form">
					<h2>Registration</h2>
					<form id="signup">
						<div class="form-group">
							<label for="voter-fname">Full Name:</label>
							<div class="form-input">
								<input type="text" class="form-control shadow-none" name="voter_fname" placeholder="Enter Full Name">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-7">
								<label for="voter-id">Voter ID:</label>
								<div class="form-input">
									<input type="text" class="form-control shadow-none" name="voter_id" placeholder="Enter Voter ID">
								</div>
							</div>
							<div class="form-group col-md-5">
								<label for="voter-fname">Gender:</label>
								<div class="form-input">
									<input type="radio" name="gender" value="Male"> Male
									<input type="radio" name="gender" value="Female"> Female
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-5">
								<label for="voter-email">Phone no:</label>
								<div class="form-input">
									<input type="number" class="form-control shadow-none" name="voter_contact" placeholder="Enter Phone No.">
								</div>
							</div>
							<div class="form-group col-md-7">
								<label for="voter_email">Email:</label>
								<div class="form-input">
									<input type="email" class="form-control shadow-none" name="voter_email" placeholder="Enter Email">
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-sm-6">
								<label for="voter-password">Password:</label>
								<div class="form-input">
									<input type="password" class="form-control shadow-none" name="voter_password" placeholder="Enter Password">
								</div>
							</div>
							<div class="form-group col-sm-6">
								<label for="confirm-password">Confirm Password:</label>
								<div class="form-input">
									<input type="password" class="form-control shadow-none" name="confirm_password" placeholder="Enter Password">
								</div>
							</div>
						</div>
						<div class="voter-signup-btn">
							<button type="submit" class="btn" name="voter_signup_submit" id="voter-signup-submit">Submit</button>
						</div>
					</form>
				</div>
				<div class="col-sm-1"></div>
			</div>
		</div>
	</div>
 </body>	
 </html>
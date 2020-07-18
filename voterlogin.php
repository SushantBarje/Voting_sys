<?php 

	session_start();
	if(isset($_SESSION['id'])){
		header('Location: voter_home.php');
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Voter Log In</title>
 	<script type="text/javascript" src="js/jquery.min.js"></script>
 	<script type="text/javascript" src="js/voter-login.js"></script>
 	 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"></script>
 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.js"></script>
 	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
			<form id="voter-login" method="post">
				<div class="form-group">
					<label for="voter_id">Voter ID:</label>
					<div class="form-input">
						<input type="text" name="voter_id" placeholder="Enter Voter ID">
					</div>
				</div>
				<div class="form-group">
					<label for="voter_password">Password:</label>
					<div class="form-input">
						<input type="password" name="voter_password" placeholder="Enter Password">
					</div>
				</div>
				<div class="admin-login-btn">
					<button type="submit" name="admin_login_submit" id="admin-login-submit">Submit</button>
				</div>
			</form>
			<div class="form-footer">
				<a href="#">Forget Password?</a>
			</div>
		</div>

		<div class="signup-form">
			<form id="signup">
				<div class="form-group">
					<label for="voter-fname">Full Name:</label>
					<div class="form-input">
						<input type="text" name="voter_fname" placeholder="Enter Full Name">
					</div>
				</div>
				<div class="form-group">
					<label for="voter-id">Voter ID:</label>
					<div class="form-input">
						<input type="text" name="voter_id" placeholder="Enter Voter ID">
					</div>
				</div>
				<div class="form-group">
					<label for="voter-fname">Gender:</label>
					<div class="form-input">
						<input type="radio" name="gender" value="Male"> Male
						<input type="radio" name="gender" value="Female"> Female
					</div>
				</div>
				<div class="form-group">
					<label for="voter-email">Phone no:</label>
					<div class="form-input">
						<input type="number" name="voter_contact" placeholder="Enter Phone No.">
					</div>
				</div>
				<div class="form-group">
					<label for="voter_email">Email:</label>
					<div class="form-input">
						<input type="email" name="voter_email" placeholder="Enter Email">
					</div>
				</div>
				<div class="form-group">
					<label for="voter-password">Password:</label>
					<div class="form-input">
						<input type="password" name="voter_password" placeholder="Enter Password">
					</div>
				</div>
				<div class="form-group">
					<label for="confirm-password">Confirm Password:</label>
					<div class="form-input">
						<input type="password" name="confirm_password" placeholder="Enter Password">
					</div>
				</div>
				<div class="admin-login-btn">
					<button type="submit" name="voter_signup_submit" id="voter-signup-submit">Submit</button>
				</div>
			</form>
		</div>
	</div>
 </body>	
 </html>
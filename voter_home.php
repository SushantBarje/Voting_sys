<?php 

	session_start();
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="" src="js/jquery.min.js"></script>
 	<script type="" src="js/give-vote.js"></script>
 	
 	<script type="text/javascript" src="js/poll_timing.js"></script>
</head>
<body>
	<div class="container">
		<div class="header">
			<ul>
				<li><a href="voter_home.php">Home</a></li>
				<li><a href="profile.php">Profile</a></li>
				<li><a href="logout.php">Log out</a></li>
			</ul>
		</div>
		<div class="main">
			<?php echo $_SESSION['id']; ?>
			<h2 id="demo"></h2>
			<h2 id="demo2"></h2>
			<h2>Vote Meter</h2>
			<ol>
				<li>Below is the list of Candidate.</li>
				<li>Voter can give <strong>Only one vote from all.</strong></li>
			</ol>
			<div><h2 id="message"></h2></div>
			<form id="vote-form">
				<table border="1" id="vote-meter">	
					<thead>
						<th>Candidate ID</th>
						<th>Party Name</th>
						<th>Candidate Name</th>
						<th>Vote</th>
					</thead>
					<tbody id="table-body"></tbody>
				</table>
					<button type="submit">Submit</button>
			</form>
		</div>
	</div>
</body>
</html>



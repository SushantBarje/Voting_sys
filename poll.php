<?php 

	session_start();
	require "connection.php";
	$con = connect();
	$pollFlag = 0;
	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}else{
		$email = $_SESSION['email'];
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Poll</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="" src="js/poll/timer.js"></script>
 	<script type="text/javascript" src="js/poll/standby_poll.js"></script>
 	<script type="text/javascript" src="js/poll/deletePoll.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>	
	<link rel="stylesheet" href="css/css/layout.css">
	<link rel="stylesheet" href="css/css/admin/poll.css">
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
					<li><a href="#">Welcome, <?php echo $email ?></a></li>
				</ul>
			</div>	
		</div>
		<span><h2 id="demo"></h2></span>
		<span><h2 id="demo2"></h2></span>
		<div class="row">
			<div class="col-sm-0 ml-5"></div>
			<div class="col-sm-11">
				<h2 id="header2">Start Poll</h2>
			</div>
			<div class="col-sm-0"></div>
		</div>
		<div class="row">
			<div class="col-sm-2"></div>
			<div class="col-sm-8">
				<div class="alert alert-danger hidden" id="alert" style="visibility:hidden">
					<span class="message"></span>
					<button type="button" class="close" onclick="$('.alert').css('visibility','hidden');">&times;</button>
				</div>
			</div>
			<div class="col-sm-2"></div>
		</div>
		<div class="main">
			<div class="row ml-5">
				<div class="col-sm-0"></div>
				<div class="col-sm-5">
					<form id="form-poll">
						<div class="form-group row ml-2">
							<label for="poll-type" class="col-xs-2">Poll Type</label>
							<div class="col-xs-10 ml-3">
								<input type="text" class="form-control shadow-none left-border-none" name="poll_type" id="poll-type" class="form-ele start_date">
							</div>
						</div>
						<div class="form-row ml-3">
							<div class="form-group row">
								<label for="start-date" class="col-xs-2 col-form-label ">Start Date</label>
								<div class="col-xs-10 ml-3">
									<input type="date" class="form-control shadow-none" name="start" id="start-date" class="form-ele">
								</div>
							</div>
							<div class="form-group row">
								<label for=stime class="col-xs-2 col-form-label ml-5">Start Time</label>
								<div class="col-xs-10 ml-3">
									<input type="time" class="form-control shadow-none" name="stime" id="start-time" class="form-ele">
								</div>
							</div>
						</div>
						<div class="form-row ml-3">
							<div class="form-group row">
								<label for="end" class="col-xs-2 col-form-label ml-1">End Date</label>
								<div class="col-xs-10 ml-3">
									<input type="date" class="form-control shadow-none" name="end" id="end-date" class="form-ele">
								</div>
							</div>
							<div class="form-group row">
								<label for="etime" class="col-xs-2 col-form-label ml-5">End Time</label>
								<div class="col-xs-10 ml-4">
									<input type="time" class="form-control shadow-none" name="etime" id="end-time" class="form-ele">
								</div>
							</div>
						</div>
						<div class="form-group ml-0">
							<div class="table-responsive">
								<table class=" candidate-table table table-bordered table-hover table-sm" border="1" class="form-ele">
									<thead>
										<th>Select Candidate</th>
										<th>Candidate ID</th>
										<th>Candidate Name</th>
										<th>Position Name</th>
										<th>Party Name</th>
									</thead>			
									<tbody>
										<?php 
											$sql = "SELECT * FROM candidate";

											$result = mysqli_query($con,$sql);
											if(mysqli_num_rows($result) > 0){
												while($row = mysqli_fetch_assoc($result)){
													?><tr>
														<td>
														<label for="candidate"></label>
														<input type="checkbox" name="candidate[]" class="candidate-select" <?php echo "id=".$row['candidate_id'] ?> value=<?php echo $row['candidate_id']; ?>></td>
														<td><?php echo $row['candidate_id'] ?></td>
														<td><?php echo $row['candidate_name'] ?></td>
														<td><?php echo $row['position'] ?></td>
														<td><?php echo $row['party_name'] ?></td>
													</tr>
												<?php }
											}
											$result->free();
										?>
									</tbody>			
								</table>
							</div>
							<button class="btn btn-primary" type="submit" id="startpoll">Start Poll</button>
						</div>
					</form>
				</div>
				<div class="col-sm-6">
					<div class="table-responsive">
						<table class="table table-bordered table-hover table-sm" border="1" id="myTable">
							<thead>
								<th>Poll Id</th>
								<th>Poll Type</th>
								<th>Candidates</th>
								<th>Start Date</th>
								<th>Start Time</th>
								<th>End Date</th>
								<th>End Time</th>
								<th>Status</th>
								<th>Action</th>
								<th>Result</th>
							</thead>
							<tbody id="poll-queue">
								<?php 

									$sql = "SELECT * FROM poll";

									$result = mysqli_query($con,$sql);
									if(!(mysqli_num_rows($result) > 0))
									{	
										echo "<tr><td colspan='9'>NO POLL</td></tr>";
									}else{
										while($row = mysqli_fetch_assoc($result)){
											echo "<tr>
												<td id='data-id'>".$row['id']."</td>
												<td>".$row['poll_type']."</td>
												<td>Not selected</td>
												<td>".$row['start_date']."</td>
												<td>".$row['start_time']."</td>
												<td>".$row['end_date']."</td>
												<td>".$row['end_time']."</td>";
											if($row['status'] == 0){
												echo "<td id='status'>Not Active</td>";
												echo '<td><button type="button" class="btn-remove btn btn-danger btn-sm" id="'.$row['id'].'">Remove</button></td>';
												echo "<td></td>";
											}
											if($row['status'] == 1){
												echo "<td id='status'>Active</td>";
												echo '<td><button type="button" class="btn-remove btn btn-danger btn-sm" id="'.$row['id'].'">Remove</button></td>';
												echo "<td></td>";
											}
											if($row['status'] == 2){
												echo "<td id='status'>Poll Expired</td>";
												echo '<td><button type="button" class="btn-remove btn btn-danger btn-sm" id="'.$row['id'].'">Remove</button></td>';
												echo "<td><a href='poll_result".$row['id']."'><button type='button' id=".$row['id']." class='result-btn btn btn-success btn-sm'>Result</button></a></td>
												</tr>";
											}
										}
									}
									mysqli_close($con);
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
 	</div>	
 </body>

 </html>
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
		<span><h2 id="demo"></h2></span>
		<span><h2 id="demo2"></h2></span>
		
		<h2>Start Poll</h2>
		<span id="message"></span>
		<div class="main">
			<form id="form-poll">
				<div class="form-group">
					<label for="poll-type">Poll Type</label>
					<input type="text" name="poll_type" id="poll-type" class="form-ele start_date">
				</div>
				<div class="form-group">
					<label for="start-date">Start Date</label>
					<input type="date" name="start" id="start-date" class="form-ele">
					<label for=stime>Time</label>
					<input type="time" name="stime" id="start-time" class="form-ele">
				</div>
				<div class="form-group">
					<label for="end">End Date</label>
					<input type="date" name="end" id="end-date" class="form-ele">
					<label for=etime>Time</label>
					<input type="time" name="etime" id="end-time" class="form-ele">
				</div>
				<div class="form-group">
					<table class="candidate-table" border="1" class="form-ele">
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
					<button type="submit" id="startpoll">Start Poll</button>
				</div>
			</form>

			<table border="1" id="myTable">
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
									<td>NOt SELECTED</td>
									<td>".$row['start_date']."</td>
									<td>".$row['start_time']."</td>
									<td>".$row['end_date']."</td>
									<td>".$row['end_time']."</td>";
								if($row['status'] == 0){
									echo "<td id='status'>Not Active</td>";
									echo '<td><button type="button" class="btn-remove" id="'.$row['id'].'">Remove</button></td>';
								}
								if($row['status'] == 1){
									echo "<td id='status'>Active</td>";
									echo '<td><button type="button" class="btn-remove" id="'.$row['id'].'">Remove</button></td>';
								}
								if($row['status'] == 2){
									echo "<td id='status'>Poll Expired</td>";
									echo "<td><a href='poll_result".$row['id']."'><button type='button' id=".$row['id']." class='result-btn'>Result</button></a></td>";
									echo '<td><button type="button" class="btn-remove" id="'.$row['id'].'">Remove</button></td>
								</tr>';
								}
							}
						}
						mysqli_close($con);
					 ?>
				</tbody>
			</table>
		</div>
 	</div>	
 </body>

 </html>
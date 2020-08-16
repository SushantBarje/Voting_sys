<?php 

	session_start();
	$pollFlag = 0;
	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}else{
		$email = $_SESSION['email'];
	}
 ?>

<?php
	
	include_once 'admin/candidates/controller.php';
	include_once 'admin/poll/main2.php';
	$con = connect();
	$nodeC = new NodeC;
	$nodeP = new Node;
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
								<table class="candidate-table table table-bordered table-hover table-sm" border="1" class="form-ele">
									<thead>
										<th>Select Candidate</th>
										<th>Candidate ID</th>
										<th>Candidate Name</th>
										<th>Position Name</th>
										<th>Party Name</th>
									</thead>			
									<tbody>
										<?php
											if($nodeC->setCandidates() === false) die('<tr><td colspan="5">No Candidates</td</tr>');
											$candidates = $nodeC->getCandidates();
											foreach($candidates as $candidate){
												$data = $nodeC->retriveCandidate($candidate);
												$id = $data->getCandidateId();
												$name = $data->getName();
												$party = $data->getParty();
												$position = $data->getPosition();
												echo '
													<tr>
														<td>
															<label for="candidate"></label>
															<input type="checkbox" name="candidate[]" class="candidate-select" id='.$id.' value='.$id.'>
														</td>
														<td>'.$id.'</td>
														<td>'.$name.'</td>
														<td>'.$position.'</td>
														<td>'.$party.'</td>
													</tr>
												';
											}
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
								<th colspan="2">Poll Active</th>
							</thead>
							<tbody id="poll-queue">
								<?php
									if($nodeP->setPoll() === false) die('<tr><td>No Poll</td></tr>');
									$polls = $nodeP->getPoll();
									foreach($polls as $poll){
										$data = $nodeP->retrivePoll($poll);
										$pollid = $data->getPollId();
										$ptype = $data->getPollType();
										$startdate = $data->getStartDate();
										$starttime = $data->getStartTime();
										$enddate = $data->getEndDate();
										$endtime = $data->getEndtime();
										$status = $data->getPollStatus();
										echo '
												<tr>
													<th>Poll ID:</th>
													<td id="pollid">'.$pollid.'</td>
												</tr>
												<tr>
													<th>Poll Type:</th>
													<td id="ptype">'.$ptype.'</td>
												</tr>
												<tr>
													<th>Start Date:</th>
													<td id="sdate">'.$startdate.'</td>
												</tr>
												<tr>
													<th>Start Time:</th>
													<td id="stime">'.$starttime.'</td>
												</tr>
												<tr>
													<th>End Date:</th>
													<td id="edate">'.$enddate.'</td>
												</tr>
												<tr>
													<th>End Time:</th>
													<td id="endtime">'.$endtime.'</td>
												</tr>
												<tr>
													<th>Status:</th>';
										echo '		<td id="status">';
													if($status == 0) echo 'Standby';
													else if($status == 1) echo 'Active';
													else if($status == 2) echo 'Expired';
										echo '		</td>
												</tr>';			
										echo '
												</tr>
												<tr>
													<th>Action</th>
													<td id="action">';
														if($status == 0){
															echo '<button type="button" class="btn-remove btn btn-danger btn-sm" id="'.$pollid.'">Remove</button>';
															echo '<button type="button" class="btn-remove btn btn-success btn-sm" id="'.$pollid.'">Edit</button>';
														}else if($status == 1 || $status == 2){
															echo '<button type="button" class="btn-remove btn btn-danger btn-sm" id="'.$pollid.'">Remove</button>';
														}
										echo '		</td>
												<tr>';
										echo '  <tr>
													<th>Result</th>
													<td id="result">';
														if($status == 2) echo'<button type="button" id="'.$pollid.'" class="result-btn btn btn-success btn-sm">Result</button>';
														else echo'--';
										echo '		</td>
												</tr>';
									}
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
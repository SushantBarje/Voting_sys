<?php 

	session_start();
	include 'connection.php';
	$con = connect();
	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}else{
		$email = $_SESSION['email'];
	}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 	<title>Manage Candidate</title>
 	<script type="text/javascript" src="js/jquery.min.js"></script>
 	<script type="text/javascript" src="js/position.js"></script>
 	<script type="text/javascript" src="js/remove-candidate.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/css/layout.css">
	<link rel="stylesheet" href="css/css/admin/managecandidate.css">
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
					<li> <a href="#">Welcome, <?php echo $email ?></a></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-0 ml-5"></div>
			<div class="col-sm-11">
				<h2 id="header2">Candidate Details</h2>
			</div>
			<div class="col-sm-0"></div>
		</div>
		<div class="row" id="row2">
			<div class="col-sm-0 ml-5"></div>
			<div class="col-sm-3" id="col1">
				<div class="alert alert-danger hidden mt-2" id="alert" style="visibility:hidden">
      				<span class="message"></span>
      				<button type="button" class="close" onclick="$('.alert').css('visibility','hidden');">&times;</button>
    			</div>
				<div class="add-candidate"> 
					<h2 id="header3">Add Candidate</h2>
					<form class="form-horizontal" id="add-cd" >
						<div class="input-group">
							<label class="control-label col-sm-3" for="v_id">Voter ID</label>
							<span>:</span>
							<div class="col-sm-8">
								<input type="text" class="form-control shadow-none" name="v_id" form="add-cd">
							</div>
						</div>
						<div class="input-group">
							<label class="control-label col-sm-3" for="c_name">Candidate Name</label>
							<span>:</span>
							<div class="col-sm-8">
								<input type="text" class="form-control shadow-none" name="c_name" form="add-cd">
							</div>
						</div>
						<div class="input-group">
							<label class="control-label col-sm-3" for="c_pname">Party Name</label>
							<span>:</span>
							<div class="col-sm-8">
								<input type="text" class="form-control shadow-none" name="c_pname" form="add-cd">
							</div>
						</div>
						<div class="input-group">
							<label class="control-label col-sm-3" for="c_position">Position</label>
							<span>:</span>
							<div class="col-sm-6">
								<select id="position_select" class="form-control input-select-sm"  name="c_position" form="add-cd">
									<option>Not Selected</option>
									<?php 
										$sql = "SELECT * FROM position;";
										$result = mysqli_query($con,$sql);

										if(mysqli_num_rows($result) > 0){
											while ($row = mysqli_fetch_assoc($result)) {
												?>
									<option <?php echo "value='".$row['pos']."'" ?>><?php echo $row['pos'] ?></option>
											<?php }
										}else{
											echo "<option value=''>No Positions</option>";
										}
									?>
								</select>
							</div>																											
						</div>
						<div class="btn-submit">
							<button type="submit" class="btn mt-3" form="add-cd">Submit</button>
						</div>
					</form>
					<!--<form id="pos-form">
						<div class="input-group">
							<label class="control-label col-sm-3" for="manage"></label>
							<div class="col-sm-9">
								<input type="button" id="manage_pos" class="btn btn-primary" value="Manage Position" form="pos-form"></input>
							</div>
						</div>	
						<button type="button" id="add-btn" form="pos-form" hidden>Add Position</button>
						<span id="pos-msg"></span>
					</form>-->
					
					<span id="candidate_id"></span>
				</div>
			</div>
			<div class="col-sm-7 ml-5" id="col2">
				<h2 id="header3">Candidates</h2>
				<table border=1 id="candidate_table" class="table table-hover table-bordered table-sm">
					<thead>
						<th>Candidate ID</th>
						<th>Voter ID</th>
						<th>Candidate Name</th>
						<th>Party Name</th>
						<th>Position</th>
						<th>Action</th>
					</thead>
					<tbody id="tbody">
						<?php  
						$sql = "SELECT * FROM candidate;";
						$result = mysqli_query($con,$sql);
						if(mysqli_num_rows($result) > 0){
							while($row = mysqli_fetch_assoc($result)){
								?><tr>
									<td><?php echo $row['candidate_id']; ?></td>
									<td><?php echo $row['vote_id'] ?></td>
									<td><?php echo $row['candidate_name']; ?></td>
									<td><?php echo $row['party_name'] ?></td>
									<td><?php echo $row['position'] ?></td>
									<td><button type="button" id=<?php echo $row['candidate_id']?> class="target btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">Remove</button></td>
									
								</tr>
							<?php }
						}else{
							?> <tr id="no">
								<td colspan="6">No Candidates</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
		</div>
 	</div>
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Remove</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Are You Sure You Want to Remove <?php echo $row['candidate_name']?></h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<button type="submit"  id="confirm-btn" name="remove_c" class=".delete btn btn-danger">Yes</button>
				</div>
			</div>
		</div>
	</div>

 	<script type="text/javascript" src="js/add-candidate.js"></script>

 	<script type="text/javascript">
 		$(document).ready(function(){
 			$('#manage_pos').click(function(){
				$(this).attr('type','input');
				$(this).attr('class','form-control shadow-none') 
 				$('#add-btn').removeAttr('hidden');
 				$(this).attr('value','');
				$('#add-btn').attr('type','submit');
				$('#add-btn').attr('class','btn btn-primary')
 				$(this).attr('name','position');
 				$('#pos-msg').empty();
 			});
 		});
 	</script>
 </body>
 </html>
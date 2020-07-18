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
 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js"></script>
 	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.js"></script>
 	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
		<div class="main">

			<h2>Candidate Details</h2>
			<span id="message"></span>
			<table border=1 id="candidate_table">
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
								<td><button type="button" name="remove_c" class="remove-btn" id=<?php echo $row['candidate_id'] ?>>Remove</button></td>
							</tr>
						<?php }
					}else{
						?> <tr id="no">
							<td colspan="6">No Candidates</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
			<span id="message"></span>
			<h2>Add Candidate</h2>
			<div class="add-candidate"> 
				<form id="add-cd">
					<div class="form-group">
						<label for="v_id">Voter ID</label>
						<input type="text" name="v_id" form="add-cd">
					</div>
					<div class="form-group">
						<label for="c_name">Candidate Name</label>
						<input type="text" name="c_name" form="add-cd">
					</div>
					<div class="form-group">
						<label for="c_pname">Party Name</label>
						<input type="text" name="c_pname" form="add-cd">
					</div>
					<div class="form-group">
						<label for="c_position">Position</label>
						<select id="position_select" name="c_position" form="add-cd">
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
					<button type="submit" form="add-cd">Submit</button>
				</form>
				<form id="pos-form">
						<label for="manage"></label>
						<input type="button" id="manage_pos" value="Manage Position" form="pos-form"></input>
						<button type="button" id="add-btn" form="pos-form" hidden>Add Position</button>
						<span id="pos-msg"></span>
				</form>
				<span id="candidate_id"></span>
			</div>
		</div>
 	</div>

 	<script type="text/javascript" src="js/add-candidate.js"></script>

 	<script type="text/javascript">
 		$(document).ready(function(){
 			$('#manage_pos').click(function(){
 				$(this).attr('type','input');
 				$('#add-btn').removeAttr('hidden');
 				$(this).attr('value','');
 				$('#add-btn').attr('type','submit');
 				$(this).attr('name','position');
 				$('#pos-msg').empty();
 			});
 		});
 	</script>
 </body>
 </html>
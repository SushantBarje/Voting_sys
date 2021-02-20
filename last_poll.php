<?php 

	session_start();
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
        <script src="js/history.js"></script>
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
                                <li><a href="last_poll.php">Last Poll</a></li>
                            </ul>
                        </li>
                        <li><a href="manage_candidate.php">Manage Candidates</a></li>
                        <li><a href="manage_voter.php">Manage Voter</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                        <li><a href="#">Welcome, <?php echo $email ?></a></li>
                    </ul>
                </div>	
            </div>
            <div class="main">
                <div class="row">
                    <div class="col-sm-1"></div>
                        <div class="col-sm-10">
                            <table class="table table-bordered mt-5">
                                <thead>
                                    <tr>
                                        <th>Poll ID</th>
                                        <th>Poll Type</th>
                                        <th>Candidates</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>More</th>
                                    </tr>
                                </thead>
                                <tbody>
                            
                                </tbody>
                            </table>
                        </div>
                    <div class="col-sm-1"></div>
                </div> 
            </div> 
        </div>
    </body>
</html>
<?php
    session_start();
    if(!isset($_SESSION['voter_id'])){
        header('Location:index.php');
    }else{
        $id = $_SESSION['voter_id'];
    }
?>

<?php

    include "voter/voter_controller.php";
    $con = connect();
    $n = new Node;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<script type="" src="js/poll/timer.js"></script> 
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/css/layout.css">
</head>
<body>
    <div class="container-fluid">
        <div class="header">
            <h2>Online Voting System</h2>
            <div class="navbar">
                <ul>
                    <li><a href="voter_home.php">Home</a></li>
                    <li><a href="voter_profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>	
        </div>
    </div>
    <div class="container">
        <div class="main">
            <div class="row">
                <div class="col-sm-12 col-6">
                    <div class="profile">
                    <?php
                        if(!$data = $n->retriveVoter($id)) echo 'novoter';
                        $id = $data->getVoterId();
                        $name = $data->getFullName();
                        $gender = $data->getGender();
                        $contact = $data->getContact();
                        $email = $data->getEmail();
                    ?>
                        <form id="profile">
                            <div class="form-group row">
                                <label for="voter_id" class="col-sm-2 col-form-label">Voter ID : </label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control-plaintext" id="voter_id" value=<?php echo $id ?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fullname" class="col-sm-2 col-form-label">Full Name : </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fullname" name="fullname" value=<?php echo $name ?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email : </label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" value=<?php echo $email ?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 col-form-label">Phone Number : </label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="phone" name="phone" value=<?php echo $contact ?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gender" class="col-sm-2 col-form-label">Gender : </label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary" id="update">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="" src="js/jquery.min.js"></script>
	<script src="js/voter-home.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
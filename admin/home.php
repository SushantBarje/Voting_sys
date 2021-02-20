<?php 
	session_start();
 ?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 	
		echo "<h2>WELCOME</h2>".$_SESSION['email'];
 ?>
 	
</body>
</html>



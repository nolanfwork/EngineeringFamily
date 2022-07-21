<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logout | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../family/styles.css">
</head>
<body>
<title>Logout | Engineering Family</title>

	<div class="container">
		<div class="row ">
			<h1 class="col-12 mt-4 mb-4 temp-display">You are successfully logged out!</h1>
			<div class="col-12 temp-display">You are now logged out.</div>
			<div class="col-12 mt-3 temp-display">You can go to <a href="../family">home page</a> or <a href="login.php">log in</a> again.</div>

		</div>
	</div> 

</body>
</html>
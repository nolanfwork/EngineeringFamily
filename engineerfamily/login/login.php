<?php
require '../config/config.php';

if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]){

	
	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		if ( empty($_POST['username']) || empty($_POST['password']) ) {

			$error = "Please enter username and password.";

		}
		else {
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}
			$passwordInput = hash("sha256", $_POST["password"]);

			$sql = "SELECT * FROM Users
						WHERE username = '" . $_POST['username'] . "' AND password = '" . $passwordInput . "';";

			
			$results = $mysqli->query($sql);

			if(!$results) {
				echo $mysqli->error;
				exit();
			}

			if($results->num_rows > 0) {
				$_SESSION["logged_in"] = true;
				$_SESSION["username"] = $_POST["username"];
				//if logged in, redirect user to mainpage.php
				header("Location: ../family/index.php");

			}
			else {
				$error = "Invalid username or password.";
			}
		} 
	}
}
	else {
		header("Location: ../family/index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login | Engineering Family</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Comforter&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../family/styles.css">
</head>
<body>
	<?php include '../family/nav.php'; ?>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4 header">Welcome back!</h1>
		</div>
	</div>
	<div class="container mybg">

		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div> 
			

			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> 

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div>

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div>
		</form>

		<div class="row">
			<div class="col-sm-9 ml-sm-auto">
				<a href="register_form.php">Create an account</a>
			</div>
		</div> 

	</div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
<script src="https://kit.fontawesome.com/8265c3dd57.js" crossorigin="anonymous"></script>
<script src="../family/main.js"></script>
</html>
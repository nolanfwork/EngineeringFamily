<?php
require "../config/config.php";

$isDeleted = false;
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}
if($_GET['ifuser']){
	$statement = $mysqli->prepare("DELETE FROM Friends WHERE Users_id = ?");
	$statement->bind_param("i", $_GET["user_id"]);
	$executed = $statement->execute();
	if (!$executed){
		echo $mysqli->error;
		exit();
	}
	$statement->close();
	$statement = $mysqli->prepare("DELETE FROM Users_has_Posts WHERE Users_id = ?");
	$statement->bind_param("i", $_GET["user_id"]);
	$executed = $statement->execute();
	if (!$executed){
		echo $mysqli->error;
		exit();
	}

	$statement->close();
	$statement = $mysqli->prepare("DELETE FROM Users WHERE id = ?");
	$statement->bind_param("i", $_GET["user_id"]);
	$executed = $statement->execute();
	if (!$executed){
		echo $mysqli->error;
		exit();
	}
	$statement->close();
	$isDeleted = true;

}
else {
	$statement = $mysqli->prepare("DELETE FROM Users_has_Posts WHERE Posts_id = ?");
	$statement->bind_param("i", $_GET["post_id"]);
	$executed = $statement->execute();
	if (!$executed){
		echo $mysqli->error;
		exit();
	}
	$statement = $mysqli->prepare("DELETE FROM Posts WHERE id = ?");
	$statement->bind_param("i", $_GET["post_id"]);
	$executed = $statement->execute();
	if (!$executed){
		echo $mysqli->error;
		exit();
	}
	else {
		$isDeleted = true;
	}
	$statement->close();
}

$mysqli->close();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delete a Song | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				<?php if ( $isDeleted ) :?>
					<?php if($_GET['ifuser']): ?>
						<div class="text-success"><span class="font-italic">The selected user</span> was successfully deleted.</div>
					<?php else: ?>
						<div class="text-success"><span class="font-italic">The selected post</span> was successfully deleted.</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Go Back to Search Results</a>
			</div>
		</div>
	</div>
</body>
</html>
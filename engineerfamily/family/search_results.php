<?php
require '../config/config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}
$isloggedin = false;
$issuper = false;

$results;
if ( isset($_SESSION['username']) && !empty($_SESSION['username']) ) {
	$isloggedin = true;//set for friend adding
	if ($_SESSION['username'] == "123"){
		$issuper = true;
	}
}
$sql = "";
$search_words = "";
if ( isset($_GET['search_post']) && !empty($_GET['search_post']) ) {
	$search_words = $mysqli->real_escape_string($_GET['search_post']);
	if ( isset($_GET['search_type']) && !empty($_GET['search_type']) ) {
		if ($_GET['search_type'] == "Author"){
			$sql = "SELECT Posts.*, Users.id AS userid, Users.username AS username FROM Posts JOIN Users_has_Posts ON Users_has_Posts.Posts_id = Posts.id JOIN Users ON Users_has_Posts.Users_id = Users.id WHERE Users.username = '" . $search_words . "';";
			$results = $mysqli->query($sql);
		}
		else if ($_GET['search_type'] == "Keyword"){
			$sql = "SELECT Posts.*, Users.id AS userid, Users.username AS username FROM Posts JOIN Users_has_Posts ON Users_has_Posts.Posts_id = Posts.id JOIN Users ON Users_has_Posts.Users_id = Users.id WHERE Posts.content LIKE '%" . $search_words . "%';";
			$results = $mysqli->query($sql);
		}
		else if ($_GET['search_type'] == "Time"){
			$sql = "SELECT Posts.*, Users.id AS userid, Users.username AS username FROM Posts JOIN Users_has_Posts ON Users_has_Posts.Posts_id = Posts.id JOIN Users ON Users_has_Posts.Users_id = Users.id WHERE Posts.date = '" . $search_words . "';";
			$results = $mysqli->query($sql);
		}
	}
	else {
		$sql = "SELECT Posts.*, Users.id AS userid, Users.username AS username FROM Posts JOIN Users_has_Posts ON Users_has_Posts.Posts_id = Posts.id JOIN Users ON Users_has_Posts.Users_id = Users.id WHERE (Posts.content LIKE '%" . $search_words . "%') OR Users.username = '" . $search_words . "';";
		$results = $mysqli->query($sql);
	}
}
else {
	$sql = "SELECT Posts.*, Users.id AS userid, Users.username AS username FROM Posts JOIN Users_has_Posts ON Users_has_Posts.Posts_id = Posts.id JOIN Users ON Users_has_Posts.Users_id = Users.id;";
	$results = $mysqli->query($sql);
}
if ( $results == false ) {
	echo $mysqli->error;
	exit();
}



$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Engineering Family</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Comforter&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles.css">
    

</head>
<body>
	<?php include 'nav.php'; ?> 
	<div class="container-fluid bg-light">

		<div class="row">
			<div class="col-12 border">		<!-- the second col: seperate two columns with nested rows-->
				<!-- when adding backend, looping to add rows here -->
				<?php while($row = $results->fetch_assoc()): ?>
				<div class="row border">
						<div class="col-6 p-2">
							<form action="add_friend.php" method="POST">
								<input type="hidden" class="temp-display" name="potential" value="<?php echo $row['userid']; ?>"></input>
								<h4><?php echo $row['username']; ?></h4>   <!-- place user name here-->
								<?php if($isloggedin && !$issuper): ?>
								<button type="submit" class="btn btn-info">Add As Friend</button>
								<?php endif; ?>
							</form>
							<form action="delete.php" method="GET">
								<?php if($issuper): ?>
									<input type="hidden" class="temp-display" name="post_id" value="<?php echo $row['id']; ?>"></input>
									<input type="hidden" class="temp-display" name="user_id" value="<?php echo $row['userid']; ?>"></input>
									<input type="hidden" class="temp-display" name="ifuser" value="<?php echo true; ?>"></input>
										<button type="submit" class="btn btn-danger">Remove this user</button>
								<?php endif; ?>
							</form>
							<form action="delete.php" method="GET">
								<?php if($issuper): ?>
									<input type="hidden" class="temp-display" name="post_id" value="<?php echo $row['id']; ?>"></input>
									<input type="hidden" class="temp-display" name="user_id" value="<?php echo $row['userid']; ?>"></input>
									<input type="hidden" class="temp-display" name="ifuser" value="<?php echo false; ?>"></input>
										<button type="submit" class="btn btn-danger">Remove this post</button>
								<?php endif; ?>
							</form>
						</div>
						<div class="col-6 p-2">
							<h4 class="temp-display"><?php echo $row['date']?></h4>
						</div>
					<div class="col-12 border">
						<textarea readonly type="text" class="form-control" rows="5" id="post_id" name="post" placeholder="posts will show here"><?php echo $row['content']?></textarea>
					</div>
				</div>
				<?php endwhile; ?>


			</div>
		</div>
	<!-- to here -->
	</div> <!-- .container -->
	
	
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
<script src="https://kit.fontawesome.com/8265c3dd57.js" crossorigin="anonymous"></script>
<script src="main.js"></script>

</html>
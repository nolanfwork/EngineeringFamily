<?php
require '../config/config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno){
    echo $mysqli->connect_error;
    exit();
}
$is_loggedin = true;
$sql_friend = "";
if (isset($_SESSION["username"]) || !empty($_SESSION["username"])){
	$sql_friend = "SELECT Usersf.username AS username FROM Users 
	JOIN Friends on Users.id = Friends.Users_id
	JOIN Users Usersf ON Friends.Friends_id = Usersf.id
	WHERE Users.username = " . "'" . $_SESSION["username"] . "'" . ";";
	$friend_results = $mysqli->query($sql_friend);
}
else {
	$sql_friend = "SELECT username AS username FROM Users;";
	$friend_results = $mysqli->query($sql_friend);
	$is_loggedin = false;
}

	if ( $friend_results == false ) {
		echo $mysqli->error;
		exit();
	}

$sql_posts = "SELECT Posts.*, Users.username FROM Users JOIN Users_has_Posts ON Users.id = Users_has_Posts.Users_id JOIN Posts ON Users_has_Posts.Posts_id = Posts.id;";
$post_results = $mysqli->query($sql_posts);
if ( $post_results == false ) {
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
    <link rel="stylesheet" type="text/css" href="../family/styles.css">
    

</head>
<body>
	<?php include 'nav.php'; ?> 
	<div class="container-fluid bg-light">
		<form action="search_results.php" method="GET">
			<div class="row pt-2">
					<div class="col-8 p-0">
						<input type="text" class="form-control" id="post_id" name="search_post" placeholder="find post/author...">
					</div>
						<div class="col-2 p-0">
							<select name="search_type" id="type-id" class="form-control">
								<option value="" selected>-- All --</option>
									<option value="Author">Author</option>
									<option value="Keyword">Keyword</option>
									<option value="Time">Time (XX-XX-XXXX)</option>
							</select>
						</div>
						<div class="col-2 p-0">
							<button type="submit" class="btn btn-primary btn-md btn-block" role="button">Search</button>
						</div>

			</div> 
		</form>
		<div class="row" background-color:transparent>
			<div class="col-12 col-md-6 border">		<!-- the first col: seperate two columns with nested rows-->
				<div class="row border">
					<?php if ($is_loggedin) : ?>
					<h4 class="temp-display p-2 font-weight-bold">Friends</h4>   <!-- place user name here-->
					<?php else: ?>
						<h4 class="temp-display p-2 font-weight-bold" id="effect">Community Members</h4>   <!-- place user name here-->

						<?php endif; ?>
				</div>
				<!-- when adding backend, looping to add rows here -->
				<?php while ($row = $friend_results->fetch_assoc()): ?>
				<div class="row border p-2">
					<h5 class="temp-display p-0"><?php if ($row["username"] == "123"){
						echo "SUPERVISOR: ";
					}
						echo $row["username"]?></h5>
				</div>
				<?php endwhile; ?>
			</div>
			<div class="col-12 col-md-6 border">		<!-- the second col: seperate two columns with nested rows-->
				<!-- when adding backend, looping to add rows here -->
				<?php while($row = $post_results->fetch_assoc()): ?>
				<div class="row border">
						<div class="col-6 p-2">
							<h4 class="temp-display"><?php echo $row["username"] ?></h4>   <!-- place user name here-->
						</div>
						<div class="col-6 p-2">
							<h4 class="temp-display"><?php echo $row["date"] ?></h4>
						</div>
					<div class="col-12 border">
						<textarea readonly type="text" class="form-control" rows="5" id="post_id" name="post" placeholder="posts will show here"><?php echo $row["content"] ?></textarea>
					</div>
				</div>
				<?php endwhile; ?>

				
			</div>
		</div>
	<!-- to here -->
	</div>
	
	
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> 
<script src="../family/main.js"></script>

</html>
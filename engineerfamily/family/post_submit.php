<?php 
require '../config/config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}
$ifposted = "";
if ( !isset($_POST['post']) || empty($_POST['post']) ) {
	echo "Please type something!";
	exit();
}
$post_words = $mysqli->real_escape_string($_POST['post']);
$repeat_check = "SELECT id FROM Posts WHERE content = " . "'" . $post_words . "'" . ";";
$check_results = $mysqli->query($repeat_check);
$check_row = $check_results->fetch_assoc();
$error_check = "";
if ($check_row != null){
    $error_check = "Post already exists!";
}
else {
    $sql = "INSERT INTO Posts (content)
    VALUES(" . "'" . $post_words . "'" . ");";
    $results = $mysqli->query($sql);
    if (!$results){
        echo $mysqli->error;
        exit();
    }
    $getlastrelationship = "SELECT id FROM Users WHERE Users.username = " . "'" . $_SESSION['username'] . "'" . ";";
    $last_results = $mysqli->query($getlastrelationship);
    $temp_Posts_id = $last_results->fetch_assoc();
    $getpostid = "SELECT id FROM Posts WHERE content = " . "'" . $post_words . "'" . ";";
    $postid_results = $mysqli->query($getpostid);
    $temp_currentpost_id = $postid_results->fetch_assoc();
    $users_update = "INSERT INTO Users_has_Posts (Users_id, Posts_id) 
                        VALUES (" 
                        . $temp_Posts_id['id']
                        .", "
                        .$temp_currentpost_id['id']
                        .");";
    $relationupdate_results = $mysqli->query($users_update);
    if (!$relationupdate_results){
        echo $mysqli->error;
        exit();
    }
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
    <div class="container-fluid">
        <div class="row">
            <h1> Posting your content... </h1>
        </div>
        <div class="row">

        <?php if (empty($error_check)): ?>
        <h1>Post has been posted!</h1>
        <?php else: ?>
            <h1>Do not resubmit the same content, keep community efficient!</h1>
        <?php endif; ?>
        </div>
        <div class="row">
            <a href="../family" class="btn btn-secondary btn-md btn-block" role=button>Go to Account Page</a>
        </div>
    </div>
</body>
</html>
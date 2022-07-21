<?php 
require '../config/config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}
if (!isset($_POST['post_email']) || empty($_POST['post_email']) || !isset($_POST['post_username']) || empty($_POST['post_username'])){
    exit();
}
else {
    
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$statement = $mysqli->prepare("UPDATE Users SET email = ? WHERE Users.username = ?;");
    $statement->bind_param("ss", $_POST['post_email'], $_POST['post_username']);
    $executed = $statement->execute();
    if (!$executed){
        echo $mysqli->error;

    }
    if ($statement->affected_rows == 1){
        $isUpdated = true;
    }
    $statement->close();
    $mysqli->close();
    header("Location: ../family/mainpage.php");
}

?>
<?php 
require '../config/config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}
$ifposted = "";
$error_check = "";
$self_check = "SELECT id FROM Users WHERE username = '" . $_SESSION['username'] . "';";
$self_results = $mysqli->query($self_check);
$self_row = $self_results->fetch_assoc();
if ( !isset($_POST['potential']) || empty($_POST['potential']) ) {
	exit();
}
else if ($_POST['potential'] == $self_row['id']){
    $error_check = "Do not add yourself as friend!";
}
else {
    $repeat_check = "SELECT Users_id FROM Friends JOIN Users ON Users.id = Friends.Users_id WHERE Users.username ='" . $_SESSION['username'] . "'" . " AND Friends.Friends_id='" . $_POST['potential'] . "';";
    $check_results = $mysqli->query($repeat_check);
    $check_row = $check_results->fetch_assoc();
    if ($check_row != null){
        $error_check = "Friendship already exists!";
    }
    else {
        $getuserid = "SELECT id FROM Users WHERE username = '" . $_SESSION['username'] . "';";
        $getuserid_results = $mysqli->query($getuserid);
        $row_getuserid = $getuserid_results->fetch_assoc();
        $sql = "INSERT INTO Friends (Users_id, Friends_id)
        VALUES(" . $row_getuserid['id'] . ", " . "" . $_POST['potential'] . ");";
        $results = $mysqli->query($sql);
        if (!$results){
            echo $mysqli->error;
            exit();
        }
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
    <?php if (empty($error_check)): ?>
    <h1> A new friend has been added!</h1>
    <?php else: ?>
        <h1><?php echo $error_check; ?></h1>
    <?php endif; ?>
    <a href="../family" class="btn btn-secondary btn-md btn-block" role=button>Go to Account Page</a>
</body>
</html>
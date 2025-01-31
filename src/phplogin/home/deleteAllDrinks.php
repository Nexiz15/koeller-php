<?php
require '../config/db_config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$userId = $_SESSION['id'];
$sql = "DELETE FROM drinks WHERE user_id = '$userId'";
if (mysqli_query($con, $sql)) {
    header('Location: ../home.php?deleteDrinksSuccess=true');
    mysqli_close($con);
    exit;
} else {
    header('Location: ../home.php?deleteDrinksError=true');
    mysqli_close($con);
    exit;
}

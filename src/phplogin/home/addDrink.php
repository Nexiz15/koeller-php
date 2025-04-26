<?php
require_once '../common/config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.html');
	exit;
}

if ($_POST['type'] != 'BEER' && $_POST['type'] != 'ALL_YOU_CAN_DRINK') {
    header('Location: home.php?error=true');
    exit;
}
$drink_type = $_POST['type'];

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$userId = $_SESSION['id'];
$currentDateTime = (new DateTime("now", new DateTimeZone('Europe/Vienna')))->format('Y-m-d H:i:s');
$sql = "INSERT INTO drinks (user_id, drink_type, date_time) VALUES ('$userId', '$drink_type', '$currentDateTime')";
if (mysqli_query($con, $sql)) {
    header('Location: home.php');
    mysqli_close($con);
    exit;
} else {
    header('Location: home.php?error=true');
    mysqli_close($con);
    exit;
}

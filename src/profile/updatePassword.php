<?php
require_once '../common/config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
    exit;
}

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
$userId = $_SESSION['id'];
$sql = "UPDATE users SET password='$hashedPassword' WHERE id='$userId'";
if (mysqli_query($con, $sql)) {
    header('Location: profile.php?passwordUpdateSuccess=true');
} else {
    header('Location: profile.php?error=true');
}

$con->close();

?>

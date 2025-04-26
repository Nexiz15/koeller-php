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

$nickName = $_POST['nickName'];
$userId = $_SESSION['id'];
$sql = "UPDATE users SET nick_name='$nickName' WHERE id='$userId'";
if (mysqli_query($con, $sql)) {
    header('Location: profile.php?nickNameUpdateSuccess=true');
    $_SESSION['nickName'] = $nickName;
} else {
    header('Location: profile.php?error=true');
}

$con->close();

?>

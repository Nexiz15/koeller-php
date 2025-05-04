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
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$username = $_POST['username'];
$hashedPassword = password_hash($_POST['username'], PASSWORD_DEFAULT);
$role = $_POST['role'];

$usernameAlreadyTakenSql = "SELECT id FROM users where user_name = '$username'";
$select = mysqli_query($con, $usernameAlreadyTakenSql);
if ($select) {
    $row = mysqli_fetch_assoc($select);
    echo $row;
    if ($row) {
        header('Location: profile.php?error=true');
        $con->close();
        exit;
    }
}

$sql = "INSERT INTO users (first_name, last_name, user_name, password, role) VALUES ('$firstName', '$lastName', '$username', '$hashedPassword', '$role')";
if (mysqli_query($con, $sql)) {
    header('Location: profile.php?createUserSuccess=true');
} else {
    header('Location: profile.php?error=true');
}

$con->close();

?>

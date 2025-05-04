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

$formUserId = $_POST['user_id'];
$currentUserId = $_SESSION['id'];
$currentDateTime = (new DateTime("now", new DateTimeZone('Europe/Vienna')))->format('Y-m-d H:i:s');
$amount = $_POST['amount'];

$values = [];
for ($i = 0; $i < $amount; $i++) {
    $values[] = "('$formUserId', '$drink_type', '$currentDateTime', '$currentUserId')";
}

$sql = "INSERT INTO drinks (user_id, drink_type, date_time, added_by) VALUES " . implode(", ", $values);

if (mysqli_query($con, $sql)) {
    header('Location: home.php?collapsed=true&success=true');
    mysqli_close($con);
    exit;
} else {
    header('Location: home.php?error=true');
    mysqli_close($con);
    exit;
}

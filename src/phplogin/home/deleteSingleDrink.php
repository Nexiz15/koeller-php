<?php
require_once '../common/config.php';
require_once '../common/utils.php';
require_once '../common/constants.php';

session_start();
$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['drinkId'])) {
	$userQuery->close();
	exit('Please fill drinkId!');
}
$id = $_POST['drinkId'];
$userId = $_SESSION['id'];

$sql = "SELECT drink_type FROM drinks WHERE id = '$id' and user_id = '$userId'";
$select = mysqli_query($con, $sql);

if($select) {
    $row = mysqli_fetch_assoc($select);

    if ($row && $row['drink_type'] == 'BEER') {
        addPaymentEntry($BEER_PRICE, $con, $userId);
    } else if ($row && $row['drink_type'] == 'ALL_YOU_CAN_DRINK') {
        addPaymentEntry($ALL_YOU_CAN_DRINK_PRICE, $con, $userId);
    }
}

$sql = "DELETE FROM drinks WHERE id = '$id'";
if (mysqli_query($con, $sql)) {
    header('Location: home.php?deleteDrinksSuccess=true');
    mysqli_close($con);
    exit;
} else {
    header('Location: home.php?deleteDrinksError=true');
    mysqli_close($con);
    exit;
}

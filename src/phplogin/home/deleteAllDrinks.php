<?php
require_once '../common/config.php';
require_once '../common/utils.php';
require_once '../common/constants.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: ../index.html');
    exit;
}

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$userId = $_SESSION['id'];

$sql = "SELECT
                SUM(
                   CASE
                       WHEN drink_type = 'BEER' THEN '$BEER_PRICE'
                       WHEN drink_type = 'ALL_YOU_CAN_DRINK' THEN '$ALL_YOU_CAN_DRINK_PRICE'
                       ELSE 0
                   END
               ) AS total_debt
           FROM users
           INNER JOIN drinks ON users.id = drinks.user_id
           WHERE users.id = '$userId'
           GROUP BY user_id;";
$select = mysqli_query($con, $sql);

if ($select) {
    $row = mysqli_fetch_assoc($select);

    if ($row && $row['total_debt'] > 0) {
        addPaymentEntry($row['total_debt'], $con, $userId);
    }
}

$sql = "DELETE FROM drinks WHERE user_id = '$userId'";
if (mysqli_query($con, $sql)) {
    header('Location: home.php');
    mysqli_close($con);
    exit;
} else {
    header('Location: home.php?error=true');
    mysqli_close($con);
    exit;
}


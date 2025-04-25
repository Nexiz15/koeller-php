<?php
function mapUsername($nick_name, $first_name, $last_name)
{
    if ($nick_name == null) {
        return "$first_name $last_name";
    } else {
        return "$nick_name ($first_name $last_name)";
    }
}

function formatDate($date)
{
    $parsedDate = date_create($date);
    return date_format($parsedDate, "H:i d.m.Y");
}

function addPaymentEntry($amount, $con, $userId) {
    $currentDateTime = (new DateTime("now", new DateTimeZone('Europe/Vienna')))->format('Y-m-d H:i:s');
    $insertQuery = "INSERT INTO payment_change_log (user_id, amount, date_time) VALUES ('$userId', '$amount', '$currentDateTime')";

    if (!mysqli_query($con, $insertQuery)) {
        header('Location: home.php?deleteDrinksError=true');
        mysqli_close($con);
        exit;
    }
}

function mapDrinkType($type)
{
    switch ($type) {
        case "BEER":
            return 'Bier';
        case "ALL_YOU_CAN_DRINK":
            return 'Saufpartie';
        default:
            return 'FALSCHER WERT';
    }
}
?>
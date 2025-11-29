<?php
require_once '../common/config.php';
require_once '../common/utils.php';
require_once '../common/constants.php';

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$userId = $_SESSION['id'];
$sql = "SELECT COALESCE(drinks.total, 0) + COALESCE(payments.total, 0) as total
        FROM users
        LEFT JOIN (
            SELECT user_id, SUM(
                           CASE
                               WHEN drinks.drink_type = 'BEER' THEN '$BEER_PRICE'
                               WHEN drinks.drink_type = 'ALL_YOU_CAN_DRINK' THEN '$ALL_YOU_CAN_DRINK_PRICE'
                               ELSE 0
                           END
                       ) as total
            FROM drinks as drinks
            WHERE drinks.date_time BETWEEN '2025-01-01' AND '2025-11-29'
            GROUP BY user_id
        ) drinks ON drinks.user_id = users.id
        LEFT JOIN (
            SELECT user_id, SUM(amount) as total
            FROM payment_change_log as payments
            WHERE payments.date_time BETWEEN '2025-01-01' AND '2025-11-30'
            GROUP BY user_id
        ) payments ON payments.user_id = users.id
        WHERE users.id = ?";
$wrappedQuery = $con->prepare($sql);
$wrappedQuery->bind_param('s', $userId);
$wrappedQuery->execute();
$wrappedQuery->store_result();
$wrappedQuery->bind_result($total);
$wrappedQuery->fetch();

if ($total < 10) {
    echo "<div class='m-3'>
                    <div>Du hast bis Ende November Getränke im Wert von $total € konsumiert.</div>
                    <div class='mt-2 fw-bold'>Du bist eine trokene Wüste:</div>
                    <div class='text-description'>Absolut alkoholfrei. Wasser mit Zitrone reicht schon für Abenteuer.</div>
                    <div><img src='../assets/trockene_wueste.webp' alt='wrapped' class='wrapped-image'</div>
                </div>";
} elseif ($total >= 10 && $total < 15) {
    echo "<div class='m-3'>
                <div>Du hast bis Ende November Getränke im Wert von $total € konsumiert.</div>
                <div class='mt-2 fw-bold'>Du bist ein Wochenend Hecht:</div>
                <div class='text-description'>Unter der Woche brav, aber am Wochenende schnappen wie ein Hecht nach dem Feierabendbier.</div>
                <div><img src='../assets/wochenend_hecht.png' alt='wrapped' class='wrapped-image'</div>
            </div>";
} elseif ($total >= 15 && $total < 20) {
    echo "<div class='m-3'>
            <div>Du hast bis Ende November Getränke im Wert von $total € konsumiert.</div>
            <div class='mt-2 fw-bold'>Du bist ein Zapfhahnkapitän:</div>
            <div class='text-description'>Segelt durchs Meer aus Bier. Hält Vorträge über den Unterschied zwischen Pils und Pilgerreise. Prostet Möwen zu, die gar nicht da sind.</div>
            <div><img src='../assets/zapfhahn_kapitaen.png' alt='wrapped' class='wrapped-image'</div>
        </div>";
} else {
    echo "<div class='m-3'>
            <div>Du hast bis Ende November Getränke im Wert von $total € konsumiert.</div>
            <div class='mt-2 fw-bold'>Du bist ein Schluckspecht:</div>
            <div class='text-description'>Öffnet Flaschen mit der Augenbraue und kennt den Jägermeister persönlich.</div>
            <div><img src='../assets/schluckspecht.jpg' alt='wrapped' class='wrapped-image'</div>
        </div>";
}

mysqli_close($con);
?>
<style>
    .wrapped-image {
        border-radius: 8px;
        width: 400px;
        @media (max-width: 767px) {
            width: 100%;
        }
    }
</style>


<?php
require_once '../common/config.php';
require_once '../common/utils.php';
require_once '../common/constants.php';

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$sql = "SELECT
              users.id as user_id,
              users.nick_name as nick_name,
              users.first_name as first_name,
              users.last_name as last_name,
               SUM(
                   CASE
                       WHEN drink_type = 'BEER' THEN '$BEER_PRICE'
                       WHEN drink_type = 'ALL_YOU_CAN_DRINK' THEN '$ALL_YOU_CAN_DRINK_PRICE'
                       ELSE 0
                   END
               ) AS total_debt
           FROM users
           LEFT JOIN drinks ON users.id = drinks.user_id
           GROUP BY users.id
           ORDER BY first_name, last_name;";
$select = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($select);

$mostDrinksInLast7DaysSql = "SELECT
             user_id,
             SUM(
                 CASE
                     WHEN drink_type = 'BEER' THEN 1
                     WHEN drink_type = 'ALL_YOU_CAN_DRINK' THEN 5
                     ELSE 0
                 END
             ) AS total_drinks
           FROM drinks
           WHERE date_time >= NOW() - INTERVAL 7 DAY
           GROUP BY user_id
           ORDER BY total_drinks DESC
           LIMIT 1;";
$mostDrinksInLast7DaysUserSelect = mysqli_query($con, $mostDrinksInLast7DaysSql);
$mostDrinksInLast7DaysUser = null;

if ($mostDrinksInLast7DaysUserSelect && mysqli_num_rows($mostDrinksInLast7DaysUserSelect) > 0) {
    $row = mysqli_fetch_assoc($mostDrinksInLast7DaysUserSelect);
    $mostDrinksInLast7DaysUser = $row['user_id'];
}

echo "<table class='table'>
<tr>
<th class='drink-heading'>User</th>
<th class='drink-heading'>Offener Betrag</th>
</tr>";
if ($num_rows > 0) {
    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td class='align-middle'>" .
            mapUsername($rows['nick_name'], $rows['first_name'], $rows['last_name']) .
                ($rows['user_id'] == $mostDrinksInLast7DaysUser
                    ? ' <span class="tooltip-icon"><i class="fa-solid fa-crown most-drinks-crown"></i><span class="tooltip-text">Meisten Getränke in der letzten Zeit hinzugefügt</span></span>'
                    : '') .
            "</td>";
        echo "<td class='align-middle'>" . $rows['total_debt'] . " €</td>";
        echo "</tr>";
    }
}
echo "</table>";

mysqli_close($con);
?>
<style>
    .most-drinks-crown {
        color: #ffcc00;
    }
</style>

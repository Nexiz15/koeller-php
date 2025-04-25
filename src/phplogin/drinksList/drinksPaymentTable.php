<?php
require_once '../common/config.php';
require_once '../common/utils.php';

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$sql = "SELECT
              users.nick_name as nick_name,
              users.first_name as first_name,
              users.last_name as last_name,
              amount,
              date_time
           FROM payment_change_log
           INNER JOIN users ON users.id = payment_change_log.user_id
           ORDER BY date_time DESC
           LIMIT 15;";
$select = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($select);

echo "<table class='table'>
<tr>
    <th class='drink-heading'>User</th>
    <th class='drink-heading'>Datum</th>
    <th class='drink-heading'>Betrag</th>
</tr>";
if ($num_rows > 0) {

    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td class='align-middle'>" . mapUsername($rows['nick_name'], $rows['first_name'], $rows['last_name']) . "</td>";
        echo "<td class='align-middle'>" . formatDate($rows['date_time']) . "</td>";
        echo "<td class='align-middle'>" . $rows['amount'] . " €</td>";
        echo "</tr>";
    }
}
echo "</table>";

mysqli_close($con);
?>
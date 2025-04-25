<?php
require 'config/db_config.php';

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
           ORDER BY date_time DESC;";
$select = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($select);

echo "<table>
<tr>
    <th class='drink-heading'>User</th>
    <th class='drink-heading'>Datum</th>
    <th class='drink-heading'>Betrag</th>
</tr>";
if ($num_rows > 0) {

    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td>" . mapUsername($rows['nick_name'], $rows['first_name'], $rows['last_name']) . "</td>";
        echo "<td>" . formatDate($rows['date_time']) . "</td>";
        echo "<td>" . $rows['amount'] . "</td>";
        echo "</tr>";
    }
}
echo "</table>";

function formatDate($date)
{
    $parsedDate = date_create($date);
    return date_format($parsedDate, "H:i d.m.Y");
}

mysqli_close($con);
?>

<style>
	.password-input {
		border: none;
		outline: none;
		border-bottom: 1px solid #05212a;
		margin-bottom: 10px;
		margin-right: 25px;
		border-radius: 0;
	}

	.password-button {
		border: none;
		height: 35px;
		background-color: #05212a;
		color: white;
		border-radius: 8px;
		padding: 0 20px 0 20px;

		&:hover {
			cursor: pointer;
		}
	}

	.text-description {
		font-style: italic;
	}
</style>
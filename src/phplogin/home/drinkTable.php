<?php
require 'config/db_config.php';

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$userId = $_SESSION['id'];
$sql = "SELECT id, drink_type, date_time FROM drinks WHERE user_id = '$userId'";
$select = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($select);

echo "<h4>Offene Getränke</h4>";
echo "<table>
<tr>
<th class='drink-heading'>Getränk</th>
<th class='drink-heading'>Datum</th>
</tr>";
if ($num_rows > 0) {

    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td>" . mapDrinkType($rows['drink_type']) . "</td>";
        echo "<td>" . formatDate($rows['date_time']) . "</td>";
        echo "</tr>";
    }
}
echo "</table>";

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

function formatDate($date)
{
    $parsedDate = date_create($date);
    return date_format($parsedDate, "H:i:s d.m.Y");
}

mysqli_close($con);
?>
<style>
    .drink-heading {
        padding-right: 20px
    }
</style>
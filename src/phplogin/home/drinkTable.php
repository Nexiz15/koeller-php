<?php
require_once '../common/config.php';
require_once '../common/utils.php';

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$userId = $_SESSION['id'];
$sql = "SELECT id, drink_type, date_time FROM drinks WHERE user_id = '$userId'";
$select = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($select);

echo "<h4>Offene Getränke</h4>";
echo "<table class='table'>
<tr>
<th>Getränk</th>
<th>Datum</th>
<th />
</tr>";
if ($num_rows > 0) {

    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td class='align-middle'>" . mapDrinkType($rows['drink_type']) . "</td>";
        echo "<td class='align-middle'>" . formatDate($rows['date_time']) . "</td>";
        echo "<td class='align-middle'>
            <form class='d-flex gap-1 flex-column flex-md-row' action='deleteSingleDrink.php' method='post'>
            				<input type='hidden' name='drinkId' value='" . $rows['id'] . "'>
            				<input class='basic-button' type='submit' value='Löschen'>
            			</form>
            </td>";
        echo "</tr>";
    }
}
echo "</table>";

mysqli_close($con);
?>
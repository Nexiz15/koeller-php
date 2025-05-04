<?php
require_once '../common/config.php';
require_once '../common/utils.php';

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$userId = $_SESSION['id'];
$sql = "SELECT
            drinks.id,
            drinks.drink_type,
            drinks.date_time,
            added_for.first_name as added_for_first_name,
            added_for.last_name as added_for_last_name
            FROM drinks
            LEFT JOIN users as added_for on added_for.id = drinks.user_id
            WHERE drinks.added_by = '$userId'
            ORDER BY drinks.date_time DESC;";
$select = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($select);

if ($num_rows > 0) {
    echo "<div class='mb-2'>";
    echo "<h6 class='ms-2 mt-4'>Hinzugefügte Getränke</h6>";
    echo "<table class='table expandable-table'>
    <tr>
    <th class='text-start text-md-start w-50'>Getränk</th>
    <th class='text-end text-md-start w-50'>Datum</th>
    </tr>";

    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td class='align-middle text-start'>";
        echo mapDrinkType($rows['drink_type']);
        if (isset($rows['added_for_first_name']) && isset($rows['added_for_last_name']) ) {
            echo " (für " . mapUsername("", $rows['added_for_first_name'], $rows['added_for_last_name']) . ")";
        }
        echo "</td>";
        echo "<td class='align-middle text-end text-md-start'>" . formatDate($rows['date_time']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "
    <div class='mb-2 ms-1 mt-4'>
    <h6>Hinzugefügte Getränke</h6>
    <p class='text-description mb-0'>In letzter Zeit sind keine Getränke jemand anderem hinzugefügt worden</p>
    </div>";
}

mysqli_close($con);
?>
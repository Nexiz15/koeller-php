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
            added_by_someone.first_name as added_by_first_name,
            added_by_someone.last_name as added_by_last_name
            FROM drinks
            LEFT JOIN users as added_by_someone on added_by_someone.id = drinks.added_by
            WHERE drinks.user_id = '$userId'
            ORDER BY drinks.date_time DESC;";
$select = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($select);

if ($num_rows > 0) {
    echo "<div class='mb-4'>";
    echo "<h4>Offene Getränke</h4>";
    echo "<table class='table'>
    <tr>
    <th>Getränk</th>
    <th>Datum</th>
    <th />
    </tr>";

    while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td class='align-middle'>";
        echo mapDrinkType($rows['drink_type']);
        if (isset($rows['added_by_first_name']) && isset($rows['added_by_last_name']) ) {
            echo "<span class='added_by_information'> (von " . mapUsername("", $rows['added_by_first_name'], $rows['added_by_last_name']) . ")</span>";
        }
        echo "</td>";
        echo "<td class='align-middle'>" . formatDate($rows['date_time']) . "</td>";
        echo "<td class='align-middle'>
            <form class='d-flex gap-1 flex-column flex-md-row' action='deleteSingleDrink.php' method='post'>
                            <input type='hidden' name='drinkId' value='" . $rows['id'] . "'>
                            <input class='basic-button' type='submit' value='Bezahlen'>
                        </form>
            </td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    echo "
        <div class='mb-5'>
                <form class='d-flex gap-1 flex-column flex-md-row' action='deleteAllDrinks.php' method='post'>
                    <input class='basic-button' type='submit' value='Alle Getränke bezahlen'>
                </form>
            </div>
    ";
} else {
    echo "
    <div class='mb-4'>
    <h4>Offene Getränke</h4>
    <p class='text-description mb-0'>Aktuell sind keine Getränke offen</p>
    </div>";
}

mysqli_close($con);
?>
<style>
    .added_by_information {
        color: #dc3545;
        font-weight: bold;
    }
</style>
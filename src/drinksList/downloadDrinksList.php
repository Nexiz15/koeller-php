<?php
require_once '../common/config.php';
require_once '../common/utils.php';
require_once '../common/constants.php';

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$sql = "SELECT
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

if ($num_rows > 0) {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment;filename="export_' . date('Ymd_His') . '.csv"');
    $output = fopen('php://output', 'w');
    echo "\xEF\xBB\xBF";
    $delimiter = ";";

    fputcsv($output, ["", "Bier (" . $BEER_PRICE . " €)", "Saufpartie (" . $ALL_YOU_CAN_DRINK_PRICE . " €)", "Gesamt"], $delimiter);

    while($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
        fputcsv($output, [mapUsername("", $rows['first_name'], $rows['last_name']), "", "", $rows['total_debt']], $delimiter);
    }

    fclose($output);

}

$con->close();
?>

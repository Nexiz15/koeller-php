<?php
require 'config/db_config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$sql = "SELECT
              user_id,
               SUM(
                   CASE
                       WHEN drink_type = 'BEER' THEN 1.5
                       WHEN drink_type = 'ALL_YOU_CAN_DRINK' THEN 15
                       ELSE 0
                   END
               ) AS total_debt
           FROM drinks
           GROUP BY user_id;";
$select = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($select);
?>

<!DOCTYPE html>
<html>

<head>
	<?php include 'meta.php'; ?>
</head>

<body class="loggedin">
	<?php include 'header.php'; ?>
	<div class="container">
		<h2 class="mb-4">Alle Getränke</h2>
		<div class="mb-4">
			<?php include 'allDrinksTable.php'; ?>
		</div>
	</div>
</body>

</html>
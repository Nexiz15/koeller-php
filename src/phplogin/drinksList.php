<?php
require 'config/db_config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
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
			<?php include 'drinksListTable.php'; ?>
		</div>
        <h2 class="mb-4">Zuletzt bezahlt</h2>
        <div class="mb-4">
            <?php include 'drinksPaymentTable.php'; ?>
        </div>
	</div>
</body>

</html>
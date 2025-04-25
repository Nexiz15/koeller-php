<?php
require_once '../common/config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.html');
	exit;
}
?>

<!DOCTYPE html>
<html>

<head>
	<?php include '../common/meta.php'; ?>
</head>

<body>
	<?php include '../common/header.php'; ?>
	<div class="container">
		<h4>Alle Getränke</h4>
		<p class="text-description mb-0">Liste mit allen Personen und deren offenen Getränke</p>
		<div class="mb-5">
			<?php include 'drinksListTable.php'; ?>
		</div>
        <h4>Zuletzt bezahlt</h4>
        <p class="text-description mb-0">Liste aller Personen die in letzter Zeit etwas bezahlt haben</p>
        <div>
            <?php include 'drinksPaymentTable.php'; ?>
        </div>
	</div>
</body>

</html>
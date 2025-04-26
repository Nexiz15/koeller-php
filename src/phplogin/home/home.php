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
		<h2 class="mb-4">Hallo
			<?= array_key_exists('nickName', $_SESSION) && $_SESSION['nickName'] != '' ? $_SESSION['nickName'] : $_SESSION['username'] ?>
		</h2>
        <?php
            if (isset($_GET['addDrinkError'])) {
                echo '<div class="error-notification">Fehler beim Hinzufügen eines Getränkes</div>';
            }
        ?>
		<div class="mb-5">
			<h4>Getränk hinzufügen</h4>
			<div class='d-flex gap-3 flex-column flex-md-row'>
                <form class="d-flex gap-1 flex-column flex-md-row mb-3" action="addDrink.php" method="post">
                    <input type="hidden" name="type" value="BEER">
                    <input class="basic-button" type="submit" value="Bier Hinzufügen (1.50 €)">
                </form>
                <form class="d-flex gap-1 flex-column flex-md-row" action="addDrink.php" method="post">
                    <input type="hidden" name="type" value="ALL_YOU_CAN_DRINK">
                    <input class="basic-button" type="submit" value="Saufpartie Hinzufügen (15 €)">
                </form>
                </div>
		</div>
        <?php
            if (isset($_GET['deleteDrinksError'])) {
                echo '<div class="error-notification">Fehler beim Bezahlen eines Getränkes</div>';
            }
        ?>
		<div class="mb-4">
			<?php include 'drinkTable.php'; ?>
		</div>
		<div class="mb-5">
			<form class="d-flex gap-1 flex-column flex-md-row" action="deleteAllDrinks.php" method="post">
				<input class="basic-button" type="submit" value="Alle Getränke bezahlen">
			</form>
		</div>
	</div>
</body>

</html>
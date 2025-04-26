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
        <?php include '../common/error.php'; ?>
		<div class="mb-5">
			<h4>Getränk hinzufügen</h4>
			<div class='d-flex gap-3 flex-column flex-md-row'>
                <form class="d-flex gap-1 flex-column flex-md-row mb-3" action="addDrink.php" method="post">
                    <input type="hidden" name="type" value="BEER">
                    <input
                        class="basic-button"
                        type="submit"
                        value="Bier Hinzufügen (<?php require_once '../common/constants.php'; echo $BEER_PRICE; ?> €)"
                    >
                </form>
                <form class="d-flex gap-1 flex-column flex-md-row" action="addDrink.php" method="post">
                    <input type="hidden" name="type" value="ALL_YOU_CAN_DRINK">
                    <input
                        class="basic-button"
                        type="submit"
                        value="Saufpartie Hinzufügen (<?php require_once '../common/constants.php'; echo $ALL_YOU_CAN_DRINK_PRICE; ?> €)"
                    >
                </form>
                </div>
		</div>
        <?php
            if (isset($_GET['deleteDrinksError'])) {
                echo '<div class="error-notification">Fehler beim Bezahlen eines Getränkes</div>';
            }
        ?>
		<?php include 'drinkTable.php'; ?>
	</div>
</body>

</html>
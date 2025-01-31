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

<body>
	<?php include 'header.php'; ?>
	<div class="container">
		<h2 class="mb-4">Hallo
			<?= array_key_exists('nickName', $_SESSION) && $_SESSION['nickName'] != '' ? $_SESSION['nickName'] : $_SESSION['username'] ?>
		</h2>
		<div class="mb-5">
			<h4>Getränk hinzufügen</h4>
			<form class="d-flex gap-1 flex-column flex-md-row mb-3" action="home/addDrink.php" method="post">
				<div>Bieranzahl: </div>
				<input class="drink-input ml-1" type="number" name="nickName" value="1">
				<input type="hidden" name="type" value="BEER">
				<input class="drink-button" type="submit" value="Bier Hinzufügen">
			</form>
			<form class="d-flex gap-1 flex-column flex-md-row" action="home/addDrink.php" method="post">
				<div>Saufpartieanzahl: </div>
				<input class="drink-input ml-1" type="number" name="nickName" value="1">
				<input type="hidden" name="type" value="ALL_YOU_CAN_DRINK">
				<input class="drink-button" type="submit" value="Saufpartie Hinzufügen">
			</form>
		</div>
		<div class="mb-4">
			<?php include 'home/drinkTable.php'; ?>
		</div>
		<div class="mb-5">
			<form class="d-flex gap-1 flex-column flex-md-row" action="home/deleteAllDrinks.php" method="post">
				<input class="drink-button" type="submit" value="Alle Getränke löschen">
			</form>
		</div>
	</div>
</body>

</html>
<style>
	.drink-input {
		border: none;
		outline: none;
		border-bottom: 1px solid #05212a;
		margin-bottom: 10px;
		margin-right: 25px;
		border-radius: 0;
	}

	.drink-button {
		border: none;
		height: 35px;
		background-color: #05212a;
		color: white;
		border-radius: 8px;
		padding: 0 20px 0 20px;

		&:hover {
			cursor: pointer;
		}
	}
</style>
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
$stmt = $con->prepare('SELECT password FROM users WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html>

<head>
	<?php include 'meta.php'; ?>
</head>

<body class="loggedin">
	<?php include 'header.php'; ?>
	<div class="container">
		<h2 class="mb-4">Profil bearbeiten</h2>
		<div class="mb-4">
			<h4>Spitzname ändern</h4>
			<p class="text-description">Name für Willkommensseite</p>
			<form class="d-flex gap-1 flex-column flex-md-row" action="updateNickname.php" method="post">
				<input class="password-input" type="text" name="nickName" placeholder="Neuer Spitzname">
				<input class="password-button" type="submit" value="Ändern">
			</form>
		</div>
		<div class="mb-4">
			<h4>Passwort ändern</h4>
			<form class="d-flex gap-1 flex-column flex-md-row" action="updatePassword.php" method="post">
				<input class="password-input" type="text" name="password" placeholder="Neues Passwort" required>
				<input class="password-button" type="submit" value="Ändern">
			</form>
		</div>
	</div>
</body>

</html>
<style>
	.password-input {
		border: none;
		outline: none;
		border-bottom: 1px solid #05212a;
		margin-bottom: 10px;
		margin-right: 25px;
	}

	.password-button {
		border: none;
		height: 35px;
		background-color: #05212a;
		color: white;
		border-radius: 8px;
		min-width: 100px;

		&:hover {
			cursor: pointer;
		}
	}

	.text-description {
		font-style: italic;
	}
</style>
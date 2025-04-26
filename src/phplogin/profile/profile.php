<?php
require_once '../common/config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.html');
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
	<?php include '../common/meta.php'; ?>
</head>

<body class="loggedin">
	<?php include '../common/header.php'; ?>
	<div class="container">
		<h2 class="mb-4">Profil bearbeiten</h2>
		<?php include '../common/error.php'; ?>
		<?php
            if (isset($_GET['passwordUpdateSuccess'])) {
                echo '<div class="success-notification">Passwort erfolgreich geändert</div>';
            } else if (isset($_GET['nickNameUpdateSuccess'])) {
                echo '<div class="success-notification">Spitzname erfolgreich geändert</div>';
            }
        ?>
		<div class="mb-4">
			<h4>Spitzname ändern</h4>
			<p class="text-description">Name für Willkommensseite und Getränkeliste</p>
			<form class="d-flex gap-1 flex-column flex-md-row" action="updateNickname.php" method="post">
				<input class="basic-input" type="text" name="nickName" placeholder="Neuer Spitzname">
				<input class="basic-button" type="submit" value="Ändern">
			</form>
		</div>
		<div class="mb-4">
			<h4>Passwort ändern</h4>
			<form class="d-flex gap-1 flex-column flex-md-row" action="updatePassword.php" method="post">
				<input class="basic-input" type="text" name="password" placeholder="Neues Passwort" required>
				<input class="basic-button" type="submit" value="Ändern">
			</form>
		</div>
	</div>
</body>

</html>
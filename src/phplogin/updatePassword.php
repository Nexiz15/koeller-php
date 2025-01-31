<?php
require 'config/db_config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

$success = false;

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
$userId = $_SESSION['id'];
$sql = "UPDATE users SET password='$hashedPassword' WHERE id='$userId'";
if (mysqli_query($con, $sql)) {
	$success = true;
}

$con->close();

?>

<!DOCTYPE html>
<html>

<head>
	<?php include 'meta.php'; ?>
</head>

<body class="loggedin">
	<?php include 'header.php'; ?>
	<div class="container">
		<?php if ($success): ?>
			<h2>Passwort erfolgreich geändert</h2>
		<?php else: ?>
			<h2>Passwort konnte nicht geändert werden</h2>
		<?php endif; ?>
	</div>

</body>

</html>
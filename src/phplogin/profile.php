<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = 'root';
$DATABASE_NAME = 'koeller';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
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
		<h2>Profil</h2>
		<div>
			Username: <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES) ?>
		</div>
		<div>
			Passwort: <?= htmlspecialchars($password, ENT_QUOTES) ?>
		</div>
	</div>
</body>

</html>
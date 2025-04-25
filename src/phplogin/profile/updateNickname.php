<?php
require_once '../common/config.php';

session_start();
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.html');
	exit;
}

$success = false;

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$nickName = $_POST['nickName'];
$userId = $_SESSION['id'];
$sql = "UPDATE users SET nick_name='$nickName' WHERE id='$userId'";
if (mysqli_query($con, $sql)) {
	$success = true;
	$_SESSION['nickName'] = $nickName;
}

$con->close();

?>

<!DOCTYPE html>
<html>

<head>
	<?php include '../common/meta.php'; ?>
</head>

<body class="loggedin">
	<?php include '../common/header.php'; ?>
	<div class="container">
		<?php if ($success): ?>
			<h2>Spitzname erfolgreich geändert</h2>
		<?php else: ?>
			<h2>Spitzname konnte nicht geändert werden</h2>
		<?php endif; ?>
	</div>

</body>

</html>
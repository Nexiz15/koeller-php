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
		<?php include 'drinkTable.php'; ?>
	</div>
</body>

</html>
<style>

</style>
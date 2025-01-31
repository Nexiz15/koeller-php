<?php
include 'config/db_config.php';

session_start();


$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if (!isset($_POST['username'], $_POST['password'])) {
	exit('Please fill both the username and password fields!');
}

if ($userQuery = $con->prepare('SELECT id, nick_name, password FROM users WHERE user_name = ?')) {
	$userQuery->bind_param('s', $_POST['username']);
	$userQuery->execute();
	$userQuery->store_result();

	if ($userQuery->num_rows > 0) {
		$userQuery->bind_result($id, $nickName, $password);
		$userQuery->fetch();
		echo $role;
		if (password_verify($_POST['password'], $password)) {
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['nickName'] = $nickName;
			header('Location: home.php');
		} else {
			echo 'Incorrect username and/or password!';
		}
	} else {
		echo 'Incorrect username and/or password!';
	}

	$userQuery->close();
}
?>
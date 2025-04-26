<?php
include 'config.php';

session_start();

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
	$userQuery->close();
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
if (!isset($_POST['username'], $_POST['password'])) {
	$userQuery->close();
	exit('Please fill both the username and password fields!');
}

if ($userQuery = $con->prepare('SELECT id, nick_name, password, first_name FROM users WHERE user_name = ?')) {
	$userQuery->bind_param('s', $_POST['username']);
	$userQuery->execute();
	$userQuery->store_result();

	if ($userQuery->num_rows > 0) {
		$userQuery->bind_result($id, $nickName, $password, $firstName);
		$userQuery->fetch();
		echo $role;
		if (password_verify($_POST['password'], $password)) {
			session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['id'] = $id;
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['nickName'] = $nickName;
			$_SESSION['firstName'] = $firstName;
			header('Location: ../home/home.php');
		} else {
			header('Location: ../index.html?wrongPasword=true');
			$userQuery->close();
			exit;
		}
	} else {
		header('Location: ../index.html?wrongPasword=true');
		$userQuery->close();
		exit;
	}
}
?>
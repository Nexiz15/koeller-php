<?php
require_once '../common/config.php';
require_once '../common/constants.php';

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
            } else if (isset($_GET['createUserSuccess'])) {
                echo '<div class="success-notification">Benutzer erfolgreich erstellt</div>';
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
        <?php if ($_SESSION['role'] == $ROLE_SUPER_ADMIN): ?>
            <div class="mb-4 col-12 col-md-3">
                <h4>User anlegen</h4>
                <form class="d-flex gap-1 flex-column" action="createUser.php" method="post">
                    <input class="basic-input" type="text" name="firstName" placeholder="Vorname" required>
                    <input class="basic-input" type="text" name="lastName" placeholder="Nachname" required>
                    <input class="basic-input" type="text" name="username" placeholder="Username" required>

                    <label for="role">Rolle</label>
                    <select name="role">
                        <?php
                         echo "<option value='". $ROLE_SUPER_ADMIN . "'>Super Admin</option>";
                         echo "<option value='". $ROLE_ADMIN . "'>Admin</option>";
                         echo "<option value='". $ROLE_MEMBER . "' selected>Mitglied</option>";
                         ?>
                    </select>
                    <input class="basic-button" type="submit" value="Anlegen">
                </form>
            </div>
        <?php endif; ?>
	</div>
</body>

</html>
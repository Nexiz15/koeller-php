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
<html lang="de">

<head>
    <?php include '../common/meta.php'; ?>
</head>

<body>
<?php include '../common/header.php'; ?>
<div class="container">
    <h4>Alle Getränke</h4>
    <div class="d-flex justify-content-between">
        <p class="text-description mb-0">Liste mit allen Personen und deren offenen Getränke</p>
        <?php if ($_SESSION['role'] == $ROLE_SUPER_ADMIN || $_SESSION['role'] == $ROLE_ADMIN): ?>
            <form class="d-none d-md-block" action="downloadDrinksList.php" method="post">
                <input class="basic-button" type="submit" value="CSV Datei erstellen">
            </form>
        <?php endif; ?>
    </div>
    <div class="mb-5">
        <?php include 'drinksListTable.php'; ?>
    </div>
    <h4>Zuletzt bezahlt</h4>
    <p class="text-description mb-0">Liste aller Personen die in letzter Zeit etwas bezahlt haben</p>
    <div>
        <?php include 'drinksPaymentTable.php'; ?>
    </div>
</div>
</body>

</html>

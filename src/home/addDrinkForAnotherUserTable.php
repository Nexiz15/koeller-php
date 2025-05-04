<?php
require_once '../common/config.php';
require_once '../common/utils.php';
require_once '../common/constants.php';

$con = mysqli_connect($GLOBALS['DATABASE_HOST'], $GLOBALS['DATABASE_USER'], $GLOBALS['DATABASE_PASS'], $GLOBALS['DATABASE_NAME']);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$userId = $_SESSION['id'];
$sql = "SELECT
              id as user_id,
              nick_name,
              first_name,
              last_name
           FROM users
           WHERE id != '$userId'
           ORDER BY first_name, last_name;";
$select = mysqli_query($con, $sql);
$num_rows = mysqli_num_rows($select);

echo "<table class='table'>
<tr>
<th class='text-start text-md-start w-50'>User</th>
<th class='text-end text-md-start w-50'>Getränk hinzufügen</th>
</tr>";

while ($rows = mysqli_fetch_array($select, MYSQLI_ASSOC)) {
    echo "<tr>";
    echo "<td class='align-middle text-start text-md-start'>" . mapUsername('', $rows['first_name'], $rows['last_name']) . "</td>";
    echo "
    <td class='align-middle text-end text-md-start'>
        <form class='d-flex justify-content-end justify-content-md-start gap-1' action='addDrinkForAnotherUser.php' method='post'>
            <input type='hidden' name='user_id' value='". $rows['user_id'] ."'>
            <input class='basic-number-input' type='number' name='amount' value='1'>
            <button class='basic-button' type='submit' name='type' value='BEER'>
                Bier
            </button>

            <button class='basic-button' type='submit' name='type' value='ALL_YOU_CAN_DRINK'>
                Saufpartie
            </button>
        </form>
    </td>
    ";
    echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>

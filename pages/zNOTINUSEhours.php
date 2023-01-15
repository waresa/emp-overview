<?php
include_once '../includes/header.inc.php';
include_once '../includes/classes/dbh.classes.php';
include_once '../includes/classes/users.classes.php';
include_once '../includes/classes/users-contr.classes.php';

if (!isset($_SESSION['userid']) || $_SESSION['userrole'] != 1) {
    header("Location: home.php");
    exit();
}

if (isset($_POST["show"])) {

    // Grabbing the data
    $user_id = $_POST["users_id"];
    $from = $_POST["from"];
    $to = $_POST["to"];

    $adminEmail = $_SESSION['useremail'];
    $user = new UsersContr($adminEmail);

    $hours = $user->getHours($user_id, $from, $to);
    $userData = $user->getUserDataById($user_id);
    $userName = $userData['full_name'];
    $userHours = $user->getHours($user_id);
}

?>

<section>
    <div id=" container">
        <div class="head-table">
            <h2 class="name-table">Timesheet for: <?php echo $userData['full_name']; ?></h2>
            <button class="print-button">Print</button>
        </div>
        <div class=" table">
            <?php
            //if the result of the query is not empty, then we can display the data
            if (!empty($userHours)) {
                echo '<table>';
                echo '<tr>';
                echo '<th>Date</th>';
                echo '<th>From</th>';
                echo '<th>To</th>';
                echo '<th>Hours</th>';
                echo '<th></th>';
                echo '</tr>';
                foreach ($hours as $hour) {
                    echo '<tr>';
                    echo '<td>' . $hour['date'] . '</td>';
                    echo '<td>' . $hour['from_hour'] . '</td>';
                    echo '<td>' . $hour['to_hour'] . '</td>';
                    echo '<td>' . $hour['hours'] . '</td>';
                    echo '<td>
                        <form method="post" action="../includes/delete-hours.inc.php">
                            <input type="hidden" name="hours_id" value="' . $hour['id'] . '">
                            <input type="hidden" name="users_id" value="' . $hour['users_id'] . '">
                            <button type="submit" name="submit" class="x-del">X</button>
                        </form>
                    
                        </td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
            ?>
        </div>
    </div>
</section>
<script>
    // print the page when the print button is clicked
    const printButton = document.querySelector('.print-button');
    printButton.addEventListener('click', () => {
        window.print();
    });
</script>

<?php
include_once '../includes/footer.inc.php';
?>
<?php
include_once '../includes/header.inc.php';
include_once '../includes/classes/dbh.classes.php';
include_once '../includes/classes/users.classes.php';
include_once '../includes/classes/users-contr.classes.php';

if (!isset($_SESSION['userid']) || $_SESSION['userrole'] != 1) {
    header("Location: home.php");
    exit();
}

$adminEmail = $_SESSION['useremail'];
$user = new UsersContr($adminEmail);
?>
<section>
    <div class="container">
        <div class="hours">
            <form action="admin-user-hours.php" method="post">
                <label for="users_id">Employee</label>
                <select name="users_id">
                    <?php
                    $users = $user->getUserEmployees($adminEmail);
                    foreach ($users as $user) {
                        if ($user['users_id'] == $_SESSION['userid']) {
                            continue;
                        }
                        echo '<option name = "users_id" value="' . $user['users_id'] . '">' . $user['full_name'] . '</option>';
                    }
                    ?>
                </select>
                <div>
                    <label for="from">From date:</label>
                    <input type="date" name="from" id="from" value="<?php echo $from ?>">
                </div>
                <div>
                    <label for="to">To date:</label>
                    <input type="date" name="to" id="to" value="<?php echo $to ?>">
                </div>
                <input type="hidden" name="uname" value="<?php echo $user['full_name']; ?>">
                <div class="form-disp-hours" style="display: none;">
                </div>
                <button name="show" class="toggle-form" id="show-hours" style="margin-top:10px;">Show hours</button>
                <div> <button class="print-button">Print</button></div>

            </form>
            <?php
            //error handling
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "hoursDeleted") {
                    echo '<br><p style="color: #3F97EF;">Hours deleted!</p>';
                } elseif ($_GET['error'] == "somethingwentwrong") {
                    echo '<p style="color: red;">Something went wrong, try again.</p>';
                }
            }
            ?>
        </div>
    </div>


    <?php

    if (isset($_POST["show"])) {
        // Grabbing the data
        $user_id = $_POST["users_id"];
        $from = $_POST["from"];
        $to = $_POST["to"];
        $userName = $_POST["uname"];


        $admin = new UsersContr($adminEmail);

        $hours = $admin->getUserWorkHoursByDate($user_id, $from, $to);
        $userData = $admin->getUserDataById($user_id);

        if (empty($hours)) {
            echo '<div class="container"><p class = "no-hours">No hours registered between those dates!</P></div>';
        } else {
    ?>
            </div>
            <div class="table">
            <?php
            //if the result of the query is not empty, then we can display the data
            if (!empty($hours)) {
                echo '<table>';
                echo '<tr>';
                echo '<th>Date</th>';
                echo '<th>From</th>';
                echo '<th>To</th>';
                echo '<th>Hours</th>';
                // echo '<th>Delete</th>';
                echo '</tr>';
                foreach ($hours as $hour) {
                    echo '<tr>';
                    echo '<td>' . $hour['date'] . '</td>';
                    echo '<td>' . $hour['from_hour'] . '</td>';
                    echo '<td>' . $hour['to_hour'] . '</td>';
                    echo '<td>' . $hour['hours'] . '</td>';
                    // echo '<td>
                    // <form method="post" action="../includes/delete-hours.inc.php">
                    //     <input type="hidden" name="hours_id" value="' . $hour['id'] . '">
                    //     <input type="hidden" name="users_id" value="' . $hour['users_id'] . '">
                    //     <button type="submit" name="submit" class="x-del">X</button>
                    // </form>

                    // </td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
        }
            ?>
            </div>
            </div>
</section>
<script>
    const printButton = document.querySelector('.print-button');
    printButton.addEventListener('click', () => {
        window.print();
    });
</script>
<?php

    }

?>



<?php
include_once '../includes/footer.inc.php';
?>
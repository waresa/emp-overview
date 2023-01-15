<?php
include_once '../includes/header.inc.php';
include_once '../includes/classes/dbh.classes.php';
include_once '../includes/classes/users.classes.php';
include_once '../includes/classes/users-contr.classes.php';

if (!isset($_SESSION['userid']) || $_SESSION['userrole'] != 1) {
    header("Location: home.php");
    exit();
}
$useremail = $_SESSION['useremail'];
$user = new UsersContr($useremail);
$userData = $user->getUserData($useremail);
$employees = $user->getUserEmployees($useremail);
?>

<section>
    <div id="container">
        <?php
        //if the result of the query is not empty, then we can display the data
        if (!empty($employees)) {
            echo '<table>';
            echo '<tr>';
            echo '<th>Name</th>';
            echo '<th></th>';
            echo '</tr>';
            foreach ($employees as $employee) {
                //dont display the current user
                if ($employee['users_email'] == $useremail) {
                    continue;
                }
                echo '<tr>';
                echo '<td><span class="name-td">' . $employee['full_name'] . '</span></td>';
                // display "Active" if IsActive is 1, "Not Active" if IsActive is 2
                if ($employee['IsActive'] == 0) {
                    echo '<td class="active">Not Active</td>';
                } else if ($employee['IsActive'] == 1) {
                    echo '<td class="table-btns">';
        ?>
                    <form method="post" action="../includes/delete-emp.inc.php">
                        <input type="hidden" name="user_id" value="<?php echo $employee['users_id']; ?>">
                        <button type="submit" name="submit" class="edit-button">Delete</button>
                    </form>

                    <a href='admin-emp-page.php?user_id=<?php echo $employee['users_id'] ?>'><button type='submit' name='submit' class='edit-button'>View</button></a>
        <?php


                    echo '</td>';
                    echo '</tr>';
                }
            }
            echo '</table>';
        } else {
            echo '<h2>No employees</h2>';
        }
        ?>
    </div>
</section>

<?php
include_once '../includes/footer.inc.php';
?>
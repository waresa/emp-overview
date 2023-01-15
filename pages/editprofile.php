<?php
include_once '../includes/header.inc.php';
include_once '../includes/classes/dbh.classes.php';
include_once '../includes/classes/users.classes.php';
include_once '../includes/classes/users-contr.classes.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit();
}
$useremail = $_SESSION['useremail'];
$user = new UsersContr($useremail);
$userData = $user->getUserData($useremail);


?>

<section>
    <div class="container">
        <div class="container-2">
            <h4>Edit Profile</h4>
            <hr>
            <h3>Name: <?php echo $userData['full_name'] ?></h3>

            <form action="../includes/editprofile.inc.php" method="post">
                <label for="old_pwd">Old Password:</label>
                <input type="password" name="old_pwd" placeholder="Old Password">
                <label for="new_pwd">New Password:</label>
                <input type="password" name="new_pwd" placeholder="New Password">
                <label for="pwdrepeat">Repeat New Password:</label>
                <input type="password" name="pwdrepeat" placeholder="Repeat Password">
                <label for="email">Email:</label>
                <input type="text" name="email" placeholder="E-post" value="<?php echo $userData['users_email'] ?>">
                <br>
                <br>
                <button type="submit" name="submit" class="submit-btn">Save Changes</button>
            </form>
        </div>
    </div>
</section>

<?php
include_once '../includes/footer.inc.php';
?>
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

<section class="index-login">
    <div class="wrapper">
        <div class="index-login-signup">
            <h4>Edit Profile</h4>
            <hr>
            <h3>Name: <?php echo $userData['full_name'] ?></h3>

            <form action="../includes/editprofile.inc.php" method="post">
                <input type="password" name="old_pwd" placeholder="Old Password">
                <input type="password" name="new_pwd" placeholder="New Password">
                <input type="password" name="pwdrepeat" placeholder="Repeat Password">
                <input type="text" name="email" placeholder="E-post" value="<?php echo $userData['users_email'] ?>">
                <br>
                <button type="submit" name="submit">Save Changes</button>
            </form>
        </div>
    </div>
</section>

<?php
include_once '../includes/footer.inc.php';
?>
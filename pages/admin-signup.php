<?php
include_once '../includes/header.inc.php';

if (!isset($_SESSION['userid']) || $_SESSION['userrole'] != 1) {
    header("Location: home.php");
    $user_id = $_SESSION['userid'];
    $user_email = $_SESSION['useremail'];

    include '../includes/dbh.inc.php';
    include '../includes/users.inc.php';
    include '../includes/users-contr.inc.php';

    $user = new UsersContr($user_email);
    $userData = $user->getUserData($user_email);
    $userCorp = $userData['corps_id'];
}
?>



<section>
    <div class="container">
        <div class="container-2">
            <h4>Add New Employee</h4>
            <hr>
            <br>
            <form action="../includes/signup.inc.php" method="post">
                <label for="fullnName">Full Name:</label>
                <input type="text" name="fullName" placeholder="Name">
                <label for="pwd">Password:</label>
                <input type="password" name="pwd" placeholder="Password">
                <label for="pwdrepeat">Repeat Password:</label>
                <input type="password" name="pwdrepeat" placeholder="Repeat Password">
                <label for="email">Email:</label>
                <input type="text" name="email" placeholder="E-mail">
                <input type="hidden" name="corp" value="<?php echo $userCorp; ?>">
                <br>
                <br>
                <button type="submit" name="submit" class="submit-btn">Create</button>
            </form>
        </div>
    </div>
</section>

<?php
include_once '../includes/footer.inc.php';
?>
<?php
include_once '../includes/header.inc.php';

if (!isset($_SESSION['userid']) || $_SESSION['userrole'] != 1) {
    header("Location: home.php");
    exit();
}
?>



<section class="index-login">
    <div class="wrapper">
        <div class="index-login-signup">
            <h4>Add New Employee</h4>
            <br>
            <form action="../includes/signup.inc.php" method="post">
                <input type="text" name="fullName" placeholder="Name">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwdrepeat" placeholder="Repeat Password">
                <input type="text" name="email" placeholder="E-mail">
                <input type="text" name="corp" placeholder="Corp">
                <br>
                <button type="submit" name="submit">Create</button>
            </form>
        </div>
    </div>
</section>

<?php
include_once '../includes/footer.inc.php';
?>
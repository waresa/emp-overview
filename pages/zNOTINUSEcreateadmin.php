<?php
include_once '../includes/header.inc.php';

if (!isset($_SESSION['userid']) || $_SESSION['userrole'] != 1) {
    header("Location: home.php");
    exit();
}
?>

<section>
    <div class="container">
        <div class="container-2">
            <h4>Add New Employee</h4>
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
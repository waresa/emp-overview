<?php
if (isset($_POST["submit"])) {

    // Grabbing the data
    $user_id = $_POST["user_id"];

    // Instantiate SignupContr class
    include "classes/dbh.classes.php";
    include "classes/users.classes.php";
    $user = new Users($email);
    // Running error handlers and user signup

    echo "TEST;";
    $user->deleteUser($user_id);


    header("location: ../pages/admin-employees.php?error=none");
}

<?php

session_start();
if (isset($_POST["submit"])) {

    // Grabbing the data
    $email = $_SESSION["useremail"];
    $user_id = $_SESSION["userid"];
    $old_pwd = $_POST["old_pwd"];
    $new_pwd = $_POST["new_pwd"];
    $new_pwdRepeat = $_POST["pwdrepeat"];
    $new_email = $_POST["email"];

    // Instantiate SignupContr class
    include "classes/dbh.classes.php";
    include "classes/users.classes.php";
    include "classes/users-contr.classes.php";
    $user = new UsersContr($email);
    // Running error handlers and user signup
    $user->updateUser($user_id, $email, $new_email, $old_pwd, $new_pwd, $new_pwdRepeat);

    // Going to back to front page
    header("location: ../pages/editprofile.php?error=none");
}

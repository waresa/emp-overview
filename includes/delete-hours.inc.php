<?php
session_start();
if (isset($_POST["submit"])) {

    // Grabbing the data
    $user_id = $_SESSION["userid"];

    $hour_id = $_POST["hours_id"];
    $user_id = $_POST["users_id"];

    // Instantiate SignupContr class
    include "classes/dbh.classes.php";
    include "classes/users.classes.php";
    include "classes/users-contr.classes.php";
    $user = new UsersContr($email);
    // Running error handlers and user signup

    $result = $user->deleteUserHour($hour_id);

    if ($result == true) {
        header("location: ../pages/admin-user-hours.php?error=hoursDeleted");
    } else {
        header("location: ../pages/admin-user-hours.php?error=somethingwentwrong");
    }
}

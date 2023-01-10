<?php

session_start();
if (isset($_POST["submit"])) {

    // Grabbing the data
    $users_id = $_SESSION["userid"];
    $email = $_SESSION["useremail"];
    $date = $_POST["date"];
    $from = $_POST["from"];
    $to = $_POST["to"];


    // Instantiate SignupContr class
    include "classes/dbh.classes.php";
    include "classes/users.classes.php";
    include "classes/users-contr.classes.php";
    $user = new UsersContr($email);

    $userData = $user->getUserDataById($users_id);
    $corps_id = $userData['corps_id'];

    echo $from;
    echo "<br>";
    echo $to;
    echo "<br>";

    //check if from is earlier than to

    // Convert the times to DateTime objects
    $fromObj = new DateTime($from);
    $toObj = new DateTime($to);



    $result = false;
    // Compare the two times
    if ($fromObj < $toObj) {
        // If $time1 is earlier than $time2, return true
        $result = true;
    } else {
        // Otherwise, return false
        $result = false;
    }

    if ($result == true) {
        $diff = $fromObj->diff($toObj);
        $hours = $diff->format('%h,%i');

        $user->registerWorkHours($users_id, $corps_id, $date, $from, $to, $hours);
        header("location: ../pages/hours.php?error=none");
    } else {
        header("location: ../pages/hours.php?error=somethingwentwrong");
    }
}

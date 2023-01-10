<?php

session_start();
if (isset($_POST["submit"])) {

    // Grabbing the data
    $images = $_FILES['files'];
    $users_id = $_SESSION["userid"];

    $email = $_SESSION["useremail"];

    $file_type = "reciept";

    // foreach ($images['name'] as $key => $value) {
    //     $name = $images['tmp_name'][$key];
    //     echo $name;
    //     echo "<br>";
    // }

    // Instantiate SignupContr class
    include "classes/dbh.classes.php";
    include "classes/users.classes.php";
    include "classes/users-contr.classes.php";
    include_once '../includes/classes/files.classes.php';
    include_once '../includes/classes/files-contr.classes.php';
    $user = new UsersContr($email);
    $file = new FilesContr();

    $userData = $user->getUserDataById($users_id);
    $corps_id = $userData['corps_id'];
    $result = $file->uploadReciepts($users_id, $images, $corps_id, $file_type);

    if ($result == false) {
        header("Location: ../pages/reg-reciepts.php?error=fileerror");
    } else {
        header("Location: ../pages/reg-reciepts.php?error=none");
    }
}

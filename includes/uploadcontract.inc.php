<?php

session_start();
if (isset($_POST["submit"])) {

    // Grabbing the data
    $contract = $_FILES['contract'];
    $users_id = $_POST["user_id"];

    $email = $_SESSION["useremail"];

    $file_type = "contract";

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

    //if employ already has a contract, delete it
    $result = $file->checkAndDeleteOldContract($users_id);
    $file->uploadContract($users_id, $contract, $corps_id, $file_type);



    // Going to back to front page
    $prev_url = $_SERVER['HTTP_REFERER'];
    $query_string = http_build_query(array('error' => 'none'));
    $prev_url .= '?' . $query_string;
    header("Location: $prev_url");
}

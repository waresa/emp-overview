<?php

if (isset($_POST["submit"])) {

    // Grabbing the data
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    // Instantiate SignupContr class
    include "classes/dbh.classes.php";
    include "classes/login.classes.php";
    include "classes/login-contr.classes.php";
    $login = new LoginContr($email, $pwd);

    // Running error handlers and user signup
    $login->loginUser();

    // Going to back to front page
    header("location: ../pages/home.php?error=none");
}

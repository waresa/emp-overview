<?php

if (isset($_POST["submit"])) {

    // Grabbing the data
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];
    $email = $_POST["email"];
    $fullName = $_POST["fullName"];
    $corp = $_POST["corp"];

    // Instantiate SignupContr class
    include "classes/dbh.classes.php";
    include "classes/signup.classes.php";
    include "classes/signup-contr.classes.php";
    $signup = new signupContr($pwd, $pwdRepeat, $email, $fullName, $corp);


    // Running error handlers and user signup
    $signup->signupUser();

    // Going to back to front page
    header("location: ../pages/signup.php?error=none");
}

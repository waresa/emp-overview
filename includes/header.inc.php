<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="css/nromalize.css">
    <link rel="stylesheet" href="../css/normalize.css">

</head>

<body id="index">

    <header>
        <nav>
            <div>
                <a href="home.php">
                    <h3>JL</h3>
                </a>
            </div>
            <ul class="menu-member">
                <?php
                if (isset($_SESSION["userid"])) {
                ?>
                    <li><a href="mypage.php"><?php echo $_SESSION["username"]; ?></a></li>
                    <li style="float: right;"><a href="../includes/logout.inc.php" class="header-login-a">LOGOUT</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>
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
    <link rel="stylesheet" href="css/style8.css">
    <link rel="stylesheet" href="../css/style8.css">

</head>

<body id="index">

    <header>
        <nav>
            <div>
                <a href="home.php">
                    <h3>Bedrift</h3>
                </a>
                <ul class="menu-main">
                    <?php
                    if (isset($_SESSION["userid"])) {
                        echo '<li><a href="editprofile.php">Edit Profile</a></li>';
                        if ($_SESSION["userrole"] == 1) {
                            echo '<li><a href="signup.php">New Employee</a></li>';
                            echo '<li><a href="employees.php">Employee List</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            <ul class="menu-member">
                <?php
                if (isset($_SESSION["userid"])) {
                ?>
                    <li><a href="#"><?php echo $_SESSION["username"]; ?></a></li>
                    <li><a href="../includes/logout.inc.php" class="header-login-a">LOGOUT</a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </header>
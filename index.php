<?php
if (isset($_SESSION['userid'])) {
    header("Location: pages/home.php");
    exit();
}

include_once 'includes/header.inc.php';
?>

<body id="index">

    <section>
        <div class="container">
            <div class="container-2">
                <div>
                    <h4>LOGG INN</h4>
                </div>
                <br>
                <div>
                    <form action="includes/login.inc.php" method="post">
                        <div>
                            <label for="email">Email:</label>
                            <input type="text" name="email" placeholder="E-post">
                        </div>
                        <div>
                            <label for="pwd">Password:</label>
                            <input type="password" name="pwd" placeholder="Passord">
                        </div>

                        <br>
                        <button type="submit" name="submit" class="submit-btn">LOGG INN</button>
                    </form>
                </div>
                <br>
                <?php

                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p>Write in your email and password!</p>";
                    } else if ($_GET["error"] == "usernotfound") {
                        echo "<p>Wrong Email or Password!</p>";
                    }
                }
                ?>
            </div>



        </div>
    </section>

</body>

<?php
include_once 'includes/footer.inc.php';
?>
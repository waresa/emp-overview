<?php
if (isset($_SESSION['userid'])) {
    header("Location: pages/home.php");
    exit();
}

include_once 'includes/header.inc.php';
?>

<body id="index">

    <section class="index-login">
        <div class="index-login-login">
            <h4>LOGG INN</h4>
            <br>
            <form action="includes/login.inc.php" method="post">
                <input type="text" name="email" placeholder="E-post">
                <input type="password" name="pwd" placeholder="Passord">
                <br>
                <br>
                <button type="submit" name="submit">LOGG INN</button>
            </form>
        </div>
        </div>
    </section>

</body>

<?php
include_once 'includes/footer.inc.php';
?>
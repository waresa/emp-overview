<?php
include_once '../includes/header.inc.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit();
}
?>

<section class="index-login">
    <div class="wrapper">
        <div class="index-login-signup">

            <a href="hours.php"><button>Register Work Hours</button></a>
            <a href="reg-reciepts.php"><button>Register Reciepts</button></a>

        </div>
    </div>
</section>

<?php
include_once '../includes/footer.inc.php';
?>
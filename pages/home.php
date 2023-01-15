<?php
include_once '../includes/header.inc.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit();
}
?>

<section>
    <div class="container">
        <div class="row">
            <h2>Job Logger</h2>
            <div class="container-2">
                <div class="contract">
                    <a href="reg-hours.php"><button class="home-btn-1">Register Work Hours</button></a>
                    <a href="reg-reciepts.php"><button class="home-btn" id="reg-rec">Register Reciepts</button></a>
                    <a href="mypage.php"><button class="home-btn" id="reg-rec">My Page</button></a>
                    <a href="editprofile.php"><button class="home-btn" id="reg-rec">Edit Profile</button></a>

                </div>
                <hr class="container-2">
                <?php
                if ($_SESSION['userrole'] == 1) {
                ?>
                    <div class="contract">
                        <br>
                        <h2>Admin Pages</h2>
                        <br>
                        <a href="admin-employees.php"><button class="home-btn-1" id="reg-rec">Employee List</button></a>
                        <a href="admin-signup.php"><button class="home-btn">Add New Employee</button></a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php
include_once '../includes/footer.inc.php';
?>
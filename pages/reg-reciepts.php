<?php
include_once '../includes/header.inc.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit();
}

?>

<section class="index-login" id="reciepts">
    <div class="wrapper">
        <div class="index-login-signup">

            <h2>Register Your Reciepts</h2>
            <hr>
            <br>
            <form action="../includes/register-reciepts.inc.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="files">Reciepts:</label>
                    <input type="file" name="files[]" class="form-control" id="files" required multiple>
                </div>
                <br>
                <button type="submit" name="submit">Submit</button>
            </form>
            <?php //error handling
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "none") {
                    echo "<p style='color: #3F97EF;'>Your reciepts are registered!</p>";
                } else if ($_GET['error'] == "fileerror") {
                    echo "<p style='color: red;'>Invalid files, please try again!</p>";
                }
            } ?>
        </div>
    </div>

</section>

<?php
include_once '../includes/footer.inc.php';
?>
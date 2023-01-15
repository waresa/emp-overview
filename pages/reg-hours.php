<?php
include_once '../includes/header.inc.php';

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit();
}

$currentDate = new DateTime();
$oneMonthFromNow = $currentDate->add(new DateInterval('P1M'));
$max = $oneMonthFromNow->format('Y-m-d');

$oneMonthBefore = $currentDate->sub(new DateInterval('P2M'));
$min = $oneMonthBefore->format('Y-m-d');

?>

<section>
    <div class="container">
        <div class="container-2">

            <h2>Register Your Work Hours</h2>
            <hr>
            <br>
            <form action="../includes/register-hours.inc.php" method="post">
                <div>
                    <input type="hidden" name="users_id" value="<?php echo $_SESSION['userid']; ?>">
                    <label for="date">Date: </label>
                    <input type="date" name="date" id="datepicker" max="<?php echo $max; ?>" min="<?php echo $min; ?>">
                </div>
                <div>
                    <label for=" from">From: </label>
                    <input type="time" name="from" id="from">
                </div>
                <div>
                    <label for=" from">To:</label>
                    <input type="time" name="to" id="to">
                </div>
                <br>
                <button type="submit" name="submit" class="submit-btn">Submit</button>
            </form>
            <?php //error handling
            if (isset($_GET['error'])) {
                if ($_GET['error'] == "hoursAdded") {
                    echo "<p style='color: #3F97EF;'>Your hours are registered!</p>";
                } else if ($_GET['error'] == "somethingwentwrong") {
                    echo "<p style='color: red;'>Invalid hours, please try again!</p>";
                }
            } ?>
        </div>
    </div>

</section>

<?php
include_once '../includes/footer.inc.php';
?>
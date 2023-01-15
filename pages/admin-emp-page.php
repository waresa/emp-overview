<?php
include_once '../includes/header.inc.php';
include_once '../includes/classes/dbh.classes.php';
include_once '../includes/classes/users.classes.php';
include_once '../includes/classes/users-contr.classes.php';
include_once '../includes/classes/files.classes.php';
include_once '../includes/classes/files-contr.classes.php';

if (!isset($_SESSION['userid']) || $_SESSION['userrole'] != 1 || !isset($_GET['user_id'])) {
    header("Location: home.php");
    exit();
}
$useremail = $_SESSION['useremail'];
$user = new UsersContr($useremail);
$file = new FilesContr();

$user_id = $_GET['user_id'];
$employee = $user->getUserDataById($user_id);
$uname = $employee['full_name'];
$contract = $file->getEmployeeContract($user_id);
$reciepts = $file->getEmployeeReciepts($user_id);

?>

<section>
    <div class="container">
        <div class="row">
            <h1>Employee: <?php echo $employee['full_name']; ?></h1>
            <div class="container-2">
                <hr>
                <div class="contract">

                    <h2>Contract</h2>
                    <?php
                    if (empty($contract)) { ?>
                        <p>Employee has no contract registered.</p>
                        <label for="contract">Upload a contract..</label>
                        <form class="contract-upload" method="post" action="../includes/uploadcontract.inc.php" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="<?php echo $employee['users_id']; ?>">
                            <input type="file" name="contract" class="form-control" id="customFile" accept="application/pdf" required>
                            <button type="submit" name="submit" class="button-emp">Upload Contract</button>
                        </form>
                        <br>
                        <hr class="hr-disp">
                    <?php
                    } elseif (!empty($contract)) { ?>

                        <label for="update"></label>
                        <p>Employee has a contract!</p>
                        <button name="update" class="toggle-form">Update Contract</button>
                        <div class="form-disp" style="display: none;">
                            <form class="contract-upload" method="post" action="../includes/uploadcontract.inc.php" enctype="multipart/form-data">
                                <input type="hidden" name="user_id" value="<?php echo $employee['users_id']; ?>">
                                <label for="contract">Upload a new contract..</label>
                                <input type="file" name="contract" class="form-control" id="customFile" accept="application/pdf" required>
                                <button type="submit" name="submit" class="button-emp">Upload</button>
                            </form>
                        </div>
                        <div class="viewc">
                            <a href="<?php echo $contract[0]['file_name']; ?>" target="_blank"><button class="button-emp" name="view">View Contract</button></a>
                            <br>
                        </div>
                        <hr class="hr-disp">
                </div>

            <?php
                    }
            ?>


            <div class="hours">
                <form action="admin-user-hours.php" method="post">
                    <h2>Hours</h2>
                    <div>
                        <label for="from">From date:</label>
                        <input type="date" name="from" id="from">
                    </div>
                    <div>
                        <label for="from">To date:</label>
                        <input type="date" name="to" id="to">
                    </div>
                    <input type="hidden" name="users_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="uname" value="<?php echo $uname; ?>">
                    <button name="show" class="toggle-form" id="show-hours" style="margin-top:10px;">Show hours</button>
                </form>
                <hr class="hr-disp">
            </div>

            <div class="hours2">
                <h2>Reciepts</h2>
                <br>
                <button class="show-reciepts">Show Reciepts</button>
                <div class="reciepts" style="display: none;">
                    <?php
                    $reciepts = $file->getEmployeeReciepts($user_id);
                    if (empty($reciepts)) {
                        echo '<br><br><br><p>No reciepts found!</p>';
                    } else {
                        foreach ($reciepts as $reciept) {
                            //print reciepts in a table
                            echo '<table class="table table-striped">'
                                . '<div class="table-responsive">'
                                . '<thead>'
                                . '<tr>'
                                . '<th scope="col">Reciept</th>'
                                . '<th scope="col">Date Uploaded</th>'
                                . '<th scope="col">Description</th>'
                                . '</tr>'
                                . '</thead>'
                                . '<tbody>'
                                . '<tr>'
                                . '<td><a href="' . $reciept['file_name'] . '" target="_blank">View</a></td>'
                                . '<td>' . $reciept['dateAdded'] . '</td>'
                                . '<td>' . $reciept['info'] . '</td>'
                                . '</tr>'
                                . '</tbody>'
                                . '</table>'
                                . '</div>';
                        }
                    }
                    ?>
                </div>



                <?php
                //error handling
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == "hoursDeleted") {
                        echo '<br><p style="color: #3F97EF;">Hours deleted!</p>';
                    } elseif ($_GET['error'] == "somethingwentwrong") {
                        echo '<p style="color: red;">Something went wrong, try again.</p>';
                    }
                }
                ?>
            </div>
            </div>
        </div>
    </div>
</section>
<script>
    function toggleReciept() {
        const reciept = document.querySelector('.reciepts');
        reciept.style.display = reciept.style.display === 'none' ? 'block' : 'none';
        const form = document.querySelector('.form-disp');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
        const viewc = document.querySelector('.viewc');
        viewc.style.display = viewc.style.display === 'none' ? 'block' : 'none';
        const hours = document.querySelector('.hours');
        hours.style.display = hours.style.display === 'none' ? 'block' : 'none';
        const cont = document.querySelector('.contract');
        cont.style.display = reciept.style.display === 'none' ? 'block' : 'none';

    }

    const toggleButton2 = document.querySelector('.show-reciepts');
    toggleButton2.addEventListener('click', toggleReciept);
</script>


<?php
include_once '../includes/footer.inc.php';

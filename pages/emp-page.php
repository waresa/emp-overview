<?php
include_once '../includes/header.inc.php';
include_once '../includes/classes/dbh.classes.php';
include_once '../includes/classes/users.classes.php';
include_once '../includes/classes/users-contr.classes.php';
include_once '../includes/classes/files.classes.php';
include_once '../includes/classes/files-contr.classes.php';

if (!isset($_SESSION['userid']) || $_SESSION['userrole'] != 1) {
    header("Location: home.php");
    exit();
}
$useremail = $_SESSION['useremail'];
$user = new UsersContr($useremail);
$file = new FilesContr();

$user_id = $_GET['user_id'];
$employee = $user->getUserDataById($user_id);
$contract = $file->getEmployeeContract($user_id);

?>

<section>
    <div class="container">
        <div class="row">
            <h1>Employee Page</h1>
            <br>
            <hr>
            <br>
            <h2>Employee: <?php echo $employee['full_name']; ?></h2>
            <br>
            <div class="container-2">
                <?php
                if (empty($contract)) { ?>
                    <form class="contract-upload" method="post" action="../includes/uploadcontract.inc.php" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?php echo $employee['users_id']; ?>">
                        <input type="file" name="contract" class="form-control" id="customFile" accept="application/pdf" required>
                        <button type="submit" name="submit" class="button-emp">Upload Contract</button>
                    </form>
                    <br>
                <?php
                } elseif (!empty($contract)) { ?>

                    <label for="update"></label>
                    <p>Employee has a contract!</p>
                    <button name="update" class="toggle-form">Update Contract</button>
                    <br>
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


                <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>

<?php
include_once '../includes/footer.inc.php';

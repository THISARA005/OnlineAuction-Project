<?php include './component/header.php' ?>
<div class="sch-aution">
    <?php 
    include '../db/config.php';
    $userid = $_SESSION['se_userid'];
    $selectUser = mysqli_query($conn, "SELECT `first_name` , `last_name`, `users`.`comp_id` , `company`.`comp_id` , `company`.`comp_nam`  FROM `users`
    LEFT JOIN company ON users.comp_id = company.comp_id WHERE users.user_id = $userid");
    $userdata = mysqli_fetch_assoc($selectUser);

    // ---------------------------------------
    $success ='';
    if (isset($_POST['request'])) {
        $detail = mysqli_real_escape_string($conn, $_POST['detail']);
        $date = $_POST['auc_date'];
        sleep(1);
        $check = mysqli_query($conn, "SELECT schedule_date FROM `message` WHERE `msg_from_id` = $userid AND schedule_date = '$date'");
        if (mysqli_num_rows($check) > 0) {
            $success = "<p class='danger'>Your request is already send</p>";
        } else {
            $insertMsg = mysqli_query($conn, "INSERT INTO `message`(`msg_from_id`, `detail`, `schedule_date`, `msg_status`) 
        VALUES ($userid , '$detail' , '$date' , 1 )");
            sleep(1);
            if ($insertMsg) {
                $success = "<p class='success'>Your request is successfully send</p>";
            }
        }
    }
    mysqli_close($conn);
    echo $success;
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="group-data">
            <label>Company Name</label>
            <input type="text" name="comp_nam" disabled class="control-data" value="<?php echo $userdata['comp_nam'] ?>" required>
        </div>
        <div class="group-data">
            <label>User Name</label>
            <input type="text" name="user" disabled class="control-data" value="<?php echo $userdata['first_name'] . ' ' . $userdata['last_name'] ?>" required>
        </div>
        <div class="group-data">
            <label>Detail</label>
            <textarea name="detail" cols="30" rows="10" placeholder="Please Enter Details" required></textarea>
        </div>
        <div class="group-data">
            <label>Schedule Date</label>
            <input type="date" name="auc_date" class="date" placeholder="Schedule Date" required>
        </div>
        <div class="btn">
            <button class="button" name="request" value="sch-auction">Request Auction</button>
        </div>
    </form>
</div>
<?php include './component/footer.php' ?>
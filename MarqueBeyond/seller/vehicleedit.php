<?php
include '../db/config.php';
include './component/header.php'; // Header 

if (!isset($_SESSION['cod'])) {
    header("Location: {$hostname}seller/host-auction.php");
}
$code = $_SESSION['cod'];
$seid = $_SESSION['se_userid'];
$result = mysqli_query($conn, "SELECT `code`, `code_date` FROM `verified_auction` WHERE `user_id` = $seid AND `code` = '$code'");
if (mysqli_num_rows($result) <= 0) {
    header("Location: {$hostname}seller/host-auction.php");
}
$cwrite = mysqli_fetch_assoc($result);
$date = date('Y-m-d');
$checkCode = mysqli_query($conn, "SELECT * FROM `vehicles`
            LEFT JOIN `make` ON vehicles.ve_makeid = make.make_id
            LEFT JOIN `bodystyle` ON vehicles.ve_typeid = bodystyle.bodyst_id
            LEFT JOIN `condition` ON vehicles.ve_conditionid = condition.cond_id
            LEFT JOIN `transmission` ON vehicles.ve_transmissionid = transmission.trans_id
            LEFT JOIN `fuel_type` ON vehicles.ve_fueltypeid = fuel_type.fuel_id
            WHERE ve_code = '$code'");
if (mysqli_num_rows($checkCode) > 0) {
    $put = mysqli_fetch_assoc($checkCode);
    $imgExplod = $put['ve_img'];
    $imgExplod = explode(',', $imgExplod);

?>
    <?php
    if (isset($_POST['addAuc'])) {

        $error = [];
        $veimg1_name = $veimg2_name = $veimg3_name = $veimg4_name = $veimg5_name = '';

        if ($_FILES['img1']['error'] === 0) {
            $veimg1_name = $_FILES['img1']['name'];
            $veimg1_type = pathinfo($veimg1_name, PATHINFO_EXTENSION);
            $veimg1_name = uniqid() . $date . '.' . $veimg1_type;
            $veimg1_tmpname = $_FILES['img1']['tmp_name'];

            if (empty($error) === true) {
                unlink($VEHICLE_IN_IMAGE_PATH . $imgExplod[0]);
                move_uploaded_file($veimg1_tmpname, $VEHICLE_IN_IMAGE_PATH . $veimg1_name) or die('img not uploaded');
            } else {
                print_r($error);
                die();
            }
        } else {
            $veimg1_name = $imgExplod[0];
        }
        if ($_FILES['img2']['error'] === 0) {
            $veimg2_name = $_FILES['img2']['name'];
            $veimg2_type = pathinfo($veimg2_name, PATHINFO_EXTENSION);
            $veimg2_name = uniqid() . $date . '.' . $veimg2_type;
            $veimg2_tmpname = $_FILES['img2']['tmp_name'];

            if (empty($error) === true) {
                unlink($VEHICLE_IN_IMAGE_PATH . $imgExplod[1]);
                move_uploaded_file($veimg2_tmpname, $VEHICLE_IN_IMAGE_PATH . $veimg2_name) or die('img not uploaded');
            } else {
                print_r($error);
                die();
            }
        } else {
            $veimg2_name = $imgExplod[1];
        }
        if ($_FILES['img3']['error'] === 0) {
            $veimg3_name = $_FILES['img3']['name'];
            $veimg3_type = pathinfo($veimg3_name, PATHINFO_EXTENSION);
            $veimg3_name = uniqid() . $date . '.' . $veimg3_type;
            $veimg3_tmpname = $_FILES['img3']['tmp_name'];

            if (empty($error) === true) {
                unlink($VEHICLE_IN_IMAGE_PATH . $imgExplod[2]);
                move_uploaded_file($veimg3_tmpname, $VEHICLE_IN_IMAGE_PATH . $veimg3_name) or die('img not uploaded');
            } else {
                print_r($error);
                die();
            }
        } else {
            $veimg3_name = $imgExplod[2];
        }
        if ($_FILES['img4']['error'] === 0) {
            $veimg4_name = $_FILES['img4']['name'];
            $veimg4_type = pathinfo($veimg4_name, PATHINFO_EXTENSION);
            $veimg4_name = uniqid() . $date . '.' . $veimg4_type;
            $veimg4_tmpname = $_FILES['img4']['tmp_name'];

            if (empty($error) === true) {
                unlink($VEHICLE_IN_IMAGE_PATH . $imgExplod[3]);
                move_uploaded_file($veimg4_tmpname, $VEHICLE_IN_IMAGE_PATH . $veimg4_name) or die('img not uploaded');
            } else {
                print_r($error);
                die();
            }
        } else {
            $veimg4_name = $imgExplod[3];
        }
        if ($_FILES['img5']['error'] === 0) {
            $veimg5_name = $_FILES['img5']['name'];
            $veimg5_type = pathinfo($veimg5_name, PATHINFO_EXTENSION);
            $veimg5_name = uniqid() . $date . '.' . $veimg5_type;
            $veimg5_tmpname = $_FILES['img5']['tmp_name'];

            if (empty($error) === true) {
                unlink($VEHICLE_IN_IMAGE_PATH . $imgExplod[4]);
                move_uploaded_file($veimg5_tmpname, $VEHICLE_IN_IMAGE_PATH . $veimg5_name) or die('img not uploaded');
            } else {
                print_r($error);
                die();
            }
        } else {
            $veimg5_name = $imgExplod[4];
        }

        $vemake = $_POST['ve_make'];
        $vetype = $_POST['ve_type'];
        $veyear = mysqli_real_escape_string($conn, $_POST['ve_year']);
        $vemodel = mysqli_real_escape_string($conn, $_POST['ve_model']);
        $vecolor = mysqli_real_escape_string($conn, $_POST['ve_color']);
        $vecond = $_POST['ve_cond'];
        $vetrans = $_POST['ve_transmission'];
        $vefuel = $_POST['ve_fuel'];
        $vecap = mysqli_real_escape_string($conn, $_POST['ve_cap']);
        $vemilage = mysqli_real_escape_string($conn, $_POST['ve_mileage']);
        $aucstrttime = $_POST['auc_strt_time'];
        $aucendtime = $_POST['auc_end_time'];
        $vedesc = mysqli_real_escape_string($conn, $_POST['ve_desc']);
        $veprice = mysqli_real_escape_string($conn, $_POST['ve_price']);

        $images = "$veimg1_name" . ',' . "$veimg2_name" . ',' . "$veimg3_name" . ',' . "$veimg4_name" . ',' . "$veimg5_name";
        $images = (string)($images);
        
        $updateVeRecordQ = "UPDATE `vehicles` SET
        `ve_typeid`= $vetype,`ve_modelid`='$vemodel',`ve_makeid`= $vemake,
        `ve_colorid`='$vecolor',`ve_conditionid`= $vecond,`ve_year`='$veyear',
        `ve_transmissionid`= $vetrans,`ve_fueltypeid`= $vefuel,`ve_encapacity`='$vecap',
        `ve_mileage`='$vemilage',`ve_desc`='$vedesc',`ve_startprice`='$veprice',
        `ve_img`='$images',`auc_strt_time`='$aucstrttime',
        `auc_end_time`='$aucendtime' 
        WHERE `ve_code` = '$code' AND `user_id` = $seid";
        $updateVeRecord = mysqli_query($conn, $updateVeRecordQ);
        if ($updateVeRecord) {
            echo 'Record is Successfully Updated';
            sleep(2);
            unset($_SESSION['cod']);
            unset($_SESSION['validCode']);
            header("Location: {$hostname}seller/overview.php");
        } else {
            echo "Failed to Update record";
        }
    }

    // ----------------------------

    if (isset($_POST['cancel'])) {
        unset($_SESSION['cod']);
        unset($_SESSION['validCode']);
        echo "<script>
        window.location.href = 'host-auction.php';
        </script>";
    }
    ?>

    <!-- Add Vehicle -->
    <div class="host">
        <div class="cancel">
            <h3>Edit Vehicle Details</h3>
            <form method="post">
                <button name="cancel">Cancel</button>
            </form>
        </div>
        
        <div class="add-vehicle" id="addvehicle">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <div class="heading">
                    <h4>Vehicle Info</h4>
                    <div class="code">
                        <div>
                            <label>vehicle code </label>
                            <input type="text" name="ve_code" value="<?php echo $code ?>" disabled>
                        </div>
                        <div>
                            <label>Auction Date</label>
                            <input type="text" name="ve_date" value="<?php echo $cwrite['code_date'] ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="form">
                    <div class="form-data">
                        <label>Vehichel Make</label>
                        <select name="ve_make" required>
                            <option selected value="<?php echo $put['make_id'] ?>"><?php echo $put['make_nam'] ?></option>
                            <?php
                            $selectMake = "SELECT * FROM `make`";
                            $makeResult = mysqli_query($conn, $selectMake) or die(' Make Query Failed');
                            if (mysqli_num_rows($makeResult) > 0) {
                                while ($make = mysqli_fetch_assoc($makeResult)) {
                                    echo "<option value='{$make['make_id']}'>{$make['make_nam']}</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-data">
                        <label>Vehichel Type</label>
                        <select name="ve_type" required>
                            <option selected value="<?php echo $put['bodyst_id'] ?>"><?php echo $put['body_style'] ?></option>
                            <?php $selectType = "SELECT * FROM `bodystyle`";
                            $typeResult = mysqli_query($conn, $selectType) or die('Type Query Failed');
                            if (mysqli_num_rows($typeResult) > 0) {
                                while ($type = mysqli_fetch_assoc($typeResult)) {
                                    echo "<option value='{$type['bodyst_id']}'>{$type['body_style']}</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-data">
                        <label>Manufactured Year</label>
                        <input type="text" name="ve_year" id="" value="<?php echo $put['ve_year'] ?>" placeholder="Model" required>
                    </div>
                    <div class="form-data">
                        <label>Model</label>
                        <input type="text" name="ve_model" id="" value="<?php echo $put['ve_modelid'] ?>" placeholder="Model" required>
                    </div>
                    <div class="form-data">
                        <label>Color</label>
                        <input type="text" name="ve_color" id="" value="<?php echo $put['ve_colorid'] ?>" placeholder="Color" required>
                    </div>
                    <div class="form-data">
                        <label>Vehicle Condition</label>
                        <select name="ve_cond" required>
                            <option selected value="<?php echo $put['cond_id'] ?>"><?php echo $put['ve_condition'] ?></option>
                            <?php $selectCondition = "SELECT * FROM `condition`";
                            $conditionResult = mysqli_query($conn, $selectCondition) or die('Year Query Failed');
                            if (mysqli_num_rows($conditionResult) > 0) {
                                while ($condition = mysqli_fetch_assoc($conditionResult)) {
                                    echo "<option value='{$condition['cond_id']}'>{$condition['ve_condition']}</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-data">
                        <label>Transmission</label>
                        <select name="ve_transmission" required>
                            <option selected value="<?php echo $put['trans_id'] ?>"><?php echo $put['trans_type'] ?></option>
                            <?php $selectTransmission = "SELECT * FROM `transmission`";
                            $transmissionResult = mysqli_query($conn, $selectTransmission) or die('Transmission Query Failed');
                            if (mysqli_num_rows($transmissionResult) > 0) {
                                while ($transmission = mysqli_fetch_assoc($transmissionResult)) {
                                    echo "<option value='{$transmission['trans_id']}'>{$transmission['trans_type']}</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-data">
                        <label>Fuel Type</label>
                        <select name="ve_fuel" required>
                            <option selected value="<?php echo $put['fuel_id'] ?>"><?php echo $put['fuel_type'] ?></option>
                            <?php $selectFuel = "SELECT * FROM `fuel_type`";
                            $fuelResult = mysqli_query($conn, $selectFuel) or die('Transmission Query Failed');
                            if (mysqli_num_rows($fuelResult) > 0) {
                                while ($fuel = mysqli_fetch_assoc($fuelResult)) {
                                    echo "<option value='{$fuel['fuel_id']}'>{$fuel['fuel_type']} </option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-data">
                        <label>Engine Capacity</label>
                        <input type="text" name="ve_cap" id="" value="<?php echo $put['ve_encapacity'] ?>" placeholder="Engine Capacity" required>
                    </div>
                    <div class="form-data">
                        <label>Mileage</label>
                        <input type="text" name="ve_mileage" id="" value="<?php echo $put['ve_mileage'] ?>" placeholder="Mileage" required>
                    </div>
                    <div class="form-data time">
                        <label>Auction Start Time</label>
                        <input type="time" name="auc_strt_time" value="<?php echo $put['auc_strt_time'] ?>" id="" required>
                    </div>
                    <div class="form-data time">
                        <label>Auction End Time</label>
                        <input type="time" name="auc_end_time" value="<?php echo $put['auc_end_time'] ?>" id="" required>
                    </div>
                    <div class="form-data">
                        <label>Addition Info</label>
                        <textarea name="ve_desc" placeholder="Furthure Information" cols="30" rows="10" style="resize: none;" required><?php echo $put['ve_desc'] ?></textarea>
                    </div>
                    <div class="form-data">
                        <label>Starting Price</label>
                        <input type="text" name="ve_price" id="" value="<?php echo $put['ve_startprice'] ?>" pattern="[0-9]+" title="Value nust be greater then 0" required>
                    </div>
                    <div class="img-heading">
                        <p>Five Images are required <span>(Please Insert Five Images)</span></p>
                    </div>
                    <div class="images">
                        <div class="upfile"><img src="<?php echo $VEHICLE_IN_IMAGE_PATH.$imgExplod[0] ?>" id="img1"><input type="file" name="img1" id="file1"></div>
                        <div class="upfile"><img src="<?php echo $VEHICLE_IN_IMAGE_PATH.$imgExplod[1] ?>" id="img2"><input type="file" name="img2" id="file2"></div>
                        <div class="upfile"><img src="<?php echo $VEHICLE_IN_IMAGE_PATH.$imgExplod[2] ?>" id="img3"><input type="file" name="img3" id="file3"></div>
                        <div class="upfile"><img src="<?php echo $VEHICLE_IN_IMAGE_PATH.$imgExplod[3] ?>" id="img4"><input type="file" name="img4" id="file4"></div>
                        <div class="upfile"><img src="<?php echo $VEHICLE_IN_IMAGE_PATH.$imgExplod[4] ?>" id="img5"><input type="file" name="img5" id="file5"></div>
                    </div>
                    <div class="field-error">
                        <li id="image-error1"></li>
                        <li id="image-error2"></li>
                        <li id="image-error3"></li>
                        <li id="image-error4"></li>
                        <li id="image-error5"></li>
                    </div>
                    <div class="btn">
                        <input type="submit" name="addAuc" id="upload" value="Upload Vehicle">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var error1 = error2 = error3 = error4 = error5 = '';
            $('#img1').click(function() {
                error1 = '';
                var src = $(`#img1`).attr('src');
                $('#file1').click().change(function(e) {
                    if (e.target.files[0].type !== 'image/png' && e.target.files[0].type !== 'image/jpeg' && e.target.files[0].type !== 'image/jpg') {
                        error1 = (`<br>Please upload image 1 ${e.target.files[0].name} of given formate (png, jpeg , jpg)`);
                        $(`#img1`).attr(src);
                    } else {
                        $('#img1').attr('src', URL.createObjectURL(e.target.files[0]));
                    }
                    if (error1) {
                        $('#image-error1').html(error1);
                        $('#upload').attr('disabled', 'disabled');
                    } else {
                        $('#image-error1').html('');
                        error1 = '';
                    }
                })
            })
            $('#img2').click(function() {
                error2 = '';
                var src = $(`#img2`).attr('src');
                $('#file2').click().change(function(e) {
                    if (e.target.files[0].type !== 'image/png' && e.target.files[0].type !== 'image/jpeg' && e.target.files[0].type !== 'image/jpg') {
                        error2 = (`<br>Please upload image 2 ${e.target.files[0].name} of given formate (png, jpeg , jpg)`);
                        $(`#img2`).attr(src);
                    } else {
                        $('#img2').attr('src', URL.createObjectURL(e.target.files[0]));
                    }
                    if (error2) {
                        $('#image-error2').html(error2);
                        $('#upload').attr('disabled', 'disabled');
                    } else {
                        $('#image-error2').html('');
                        error2 = '';
                    }
                })
            })
            $('#img3').click(function() {
                error3 = '';
                var src = $(`#img3`).attr('src');
                $('#file3').click().change(function(e) {
                    if (e.target.files[0].type !== 'image/png' && e.target.files[0].type !== 'image/jpeg' && e.target.files[0].type !== 'image/jpg') {
                        error3 = (`<br>Please upload image 3 ${e.target.files[0].name} of given formate (png, jpeg , jpg)`);
                        $(`#img3`).attr(src);
                    } else {
                        $('#img3').attr('src', URL.createObjectURL(e.target.files[0]));
                    }
                    if (error3) {
                        $('#image-error3').html(error3);
                        $('#upload').attr('disabled', 'disabled');
                    } else {
                        $('#image-error3').html('');
                        error3 = '';
                    }
                })
            })
            $('#img4').click(function() {
                error4 = '';
                var src = $(`#img4`).attr('src');
                $('#file4').click().change(function(e) {
                    if (e.target.files[0].type !== 'image/png' && e.target.files[0].type !== 'image/jpeg' && e.target.files[0].type !== 'image/jpg') {
                        error4 = (`<br>Please upload image 4 ${e.target.files[0].name} of given formate (png, jpeg , jpg)`);
                        $(`#img4`).attr(src);
                    } else {
                        $('#img4').attr('src', URL.createObjectURL(e.target.files[0]));
                    }
                    if (error4) {
                        $('#image-error4').html(error4);
                        $('#upload').attr('disabled', 'disabled');
                    } else {
                        $('#image-error4').html('');
                        error4 = '';
                    }
                })
            })
            $('#img5').click(function() {
                error5 = '';
                var src = $(`#img5`).attr('src');
                $('#file5').click().change(function(e) {
                    if (e.target.files[0].type !== 'image/png' && e.target.files[0].type !== 'image/jpeg' && e.target.files[0].type !== 'image/jpg') {
                        error5 = (`<br>Please upload image 5 ${e.target.files[0].name} of given formate (png, jpeg , jpg)`);
                        $(`#img5`).attr(src);
                    } else {
                        $('#img5').attr('src', URL.createObjectURL(e.target.files[0]));
                    }
                    if (error5) {
                        $('#image-error5').html(error5);
                        $('#upload').attr('disabled', 'disabled');
                    } else {
                        $('#image-error5').html('');
                        error5 = '';
                    }
                })
            })
        })
    </script>
<?php } //Check Condition End
else {
    echo "<div class='hostRedirect'>Please Entered vehicle Info First.
    <a href='{$hostname}seller/host-auction.php'><b>Go back To Edit</b></a></div>
    ";
}
?>
<!-- Footer -->
<?php include './component/footer.php' ?>
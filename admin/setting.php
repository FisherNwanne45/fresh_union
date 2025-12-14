<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Settings";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available
// include(ROOT_PATH."/admin/include/adminFunction.php");
//require_once("./include/adminloginFunction.php");


if (isset($_POST['upload_picture'])) {

    if (!empty($_FILES['image']['name'])) {

        $file = $_FILES['image'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'svg'];

        if (!in_array($ext, $allowed)) {
            toast_alert("error", "Invalid file type!", "Only jpg, png, jpeg, svg allowed.");
            exit;
        }

        $folder = "assets/images/logo/";
        $newName = "logo_" . time() . "." . $ext;
        $destination = $folder . $newName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {

            $stmt = $conn->prepare("UPDATE settings SET image=:image WHERE id=1");
            $stmt->execute(['image' => $newName]);

            toast_alert("success", "Logo updated successfully!", "Done");
        }
    }
}
if (isset($_POST['upload_favicon'])) {

    if (!empty($_FILES['favicon']['name'])) {

        $file = $_FILES['favicon'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['png', 'ico', 'jpg', 'jpeg', 'svg'];

        if (!in_array($ext, $allowed)) {
            toast_alert("error", "Invalid file type!", "Only png, ico, jpg, jpeg, svg allowed.");
            exit;
        }

        $folder = "assets/images/logo/";
        $newName = "favicon_" . time() . "." . $ext;
        $destination = $folder . $newName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {

            $stmt = $conn->prepare("UPDATE settings SET favicon=:favicon WHERE id=1");
            $stmt->execute(['favicon' => $newName]);

            toast_alert("success", "Favicon updated successfully!", "Done");
        }
    }
}


if (isset($_POST['save_settings'])) {
    $url_name = $_POST['url_name'];
    $url_link = $_POST['url_link'];
    $url_tel = $_POST['url_tel'];
    $url_email = $_POST['url_email'];
    $cardfee = $_POST['cardfee'];
    $code1 = $_POST['code1'];
    $code2 = $_POST['code2'];
    $code3 = $_POST['code3'];
    $url_address = $_POST['url_address'];
    $country = $_POST['country'];
    $wirefee = $_POST['wirefee'];
    $domesticfee = $_POST['domesticfee'];
    $loanlimit = $_POST['loanlimit'];
    $domesticlimit = $_POST['domesticlimit'];
    $wirelimit = $_POST['wirelimit'];
    $billing_code = $_POST['billing_code'];
    $cot_code = $_POST['cot_code'];
    $tax_code = $_POST['tax_code'];
    $imf_code = $_POST['imf_code'];
    $twillio_status = $_POST['twillio_status'];
    $currency = $_POST['currency'];
    $routine = $_POST['routine'];
    $swift = $_POST['swift'];
    $tawk = $_POST['tawk'];
    $sitekey = $_POST['sitekey'];
    $secretkey = $_POST['secretkey'];
    $id = "1";
    $sql = "UPDATE settings SET url_name=:url_name,url_link=:url_link,url_tel=:url_tel,url_email=:url_email,cardfee=:cardfee,code1=:code1,code2=:code2,code3=:code3,url_address=:url_address,country=:country,domesticfee=:domesticfee,wirefee=:wirefee, loanlimit=:loanlimit, domesticlimit=:domesticlimit,wirelimit=:wirelimit,billing_code=:billing_code,cot_code=:cot_code,tax_code=:tax_code,imf_code=:imf_code,twillio_status=:twillio_status,currency=:currency,routine=:routine,swift=:swift,tawk=:tawk,sitekey=:sitekey,secretkey=:secretkey WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'url_name' => $url_name,
        'url_link' => $url_link,
        'url_tel' => $url_tel,
        'url_email' => $url_email,
        'cardfee' => $cardfee,
        'code1' => $code1,
        'code2' => $code2,
        'code3' => $code3,
        'url_address' => $url_address,
        'country' => $country,
        'domesticfee' => $domesticfee,
        'wirefee' => $wirefee,
        'loanlimit' => $loanlimit,
        'domesticlimit' => $domesticlimit,
        'wirelimit' => $wirelimit,
        'billing_code' => $billing_code,
        'cot_code' => $cot_code,
        'tax_code' => $tax_code,
        'imf_code' => $imf_code,
        'twillio_status' => $twillio_status,
        'currency' => $currency,
        'routine' => $routine,
        'swift' => $swift,
        'tawk' => $tawk,
        'sitekey' => $sitekey,
        'secretkey' => $secretkey,
        'id' => $id
    ]);

    if (true) {

        $msg1 = "
       <div class='alert alert-warning'>
       
       <script type='text/javascript'>
            
               function Redirect() {
               window.location='./setting.php';
               }
               document.write ('');
               setTimeout('Redirect()', 4000);
            
               </script>
               
       <center><img src='../assets/images/loading.gif' width='180px'  /></center>
       
       
       <center>	<strong style='color:black;'>Updated successfully, Please Wait while we redirect you...
              </strong></center>
         </div>
       ";


        //  toast_alert('success','Settings updated successfully','Approved');
    } else {
        //   toast_alert('error', 'Sorry something went wrong');
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            System Settings
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>



    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <form method="POST">
                <div class="box-header with-border">
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                class="fa fa-minus"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="col-md-6">
                            <h4 class="mb-5 mt-5"><strong>SYSTEM INFORMATION</strong></h4>
                            <div class="form-group">
                                <label>System Name</label>
                                <input type="text" class="form-control" name="url_name" value="<?= $page['url_name'] ?>"
                                    placeholder="<?= $page['url_name'] ?> ">
                            </div>
                            <div class="form-group">

                            </div>
                            <div class="row">

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Website Url</label>
                                        <input type="text" class="form-control" name="url_link"
                                            value="<?= $page['url_link'] ?>" placeholder="Website Url">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>System Email</label>
                                        <input type="email" class="form-control" name="url_email"
                                            value="<?= $page['url_email'] ?>" placeholder="<?= $page['url_email'] ?> ">
                                    </div>
                                </div>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label>System Address</label>
                                <input type="text" class="form-control" name="url_address"
                                    value="<?= $page['url_address'] ?>" placeholder="<?= $page['url_address'] ?>">
                            </div>

                            <div class="row">

                                <div class="col-md-5 col-sm-12">
                                    <div class="form-group">
                                        <label>System Phone</label>
                                        <input type="text" class="form-control" name="url_tel"
                                            value="<?= $page['url_tel'] ?>" placeholder="<?= $page['url_tel'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" class="form-control" name="country"
                                            value="<?= $page['country'] ?>" placeholder="country">
                                    </div>

                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label> Currency</label>
                                        <input type="text" class="form-control" name="currency"
                                            value="<?= $page['currency'] ?>" placeholder="System Currency">
                                    </div>
                                </div>


                            </div>




                            <div class="form-group">
                                <label>Livechat Code</label>
                                <input type="text" class="form-control" name="tawk"
                                    value="<?= htmlspecialchars($page['tawk']) ?>" placeholder="Enter Livechat Code">

                            </div>



                            <div class="row">

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Recaptcha Sitekey</label>
                                        <input type="text" class="form-control" name="sitekey"
                                            value="<?= $page['sitekey'] ?>" placeholder="Google Recaptcha Site Key">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Recaptcha Secretkey</label>
                                        <input type="text" class="form-control" name="secretkey"
                                            value="<?= $page['secretkey'] ?>" placeholder="Google Recaptcha Secret Key">
                                    </div>
                                </div>


                            </div>


                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <!-- Billing Code Option -->
                            <h4 class="mb-5 mt-5"><strong>BILLING CODE OPTIONS</strong></h4>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Billing Codes</label><br>

                                        <input type="hidden" name="billing_code" value="1">

                                        <input disabled type="checkbox" name="billing_code" value="1"
                                            <?php echo ($page['billing_code'] == '1') ? 'checked' : ''; ?>
                                            data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="primary"
                                            data-offstyle="secondary" data-width="80">
                                    </div>
                                </div>
                                <!-- COT Code -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?= $page['code1'] ?> Code </label><br>

                                        <input type="hidden" name="cot_code" value="0">

                                        <input type="checkbox" name="cot_code" value="1"
                                            <?php echo ($page['cot_code'] == '1') ? 'checked' : ''; ?>
                                            data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="primary"
                                            data-offstyle="secondary" data-width="80">
                                    </div>
                                </div>

                                <!-- TAX Code -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?= $page['code2'] ?> Code </label><br>

                                        <input type="hidden" name="tax_code" value="0">

                                        <input type="checkbox" name="tax_code" value="1"
                                            <?php echo ($page['tax_code'] == '1') ? 'checked' : ''; ?>
                                            data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="primary"
                                            data-offstyle="secondary" data-width="80">
                                    </div>
                                </div>

                                <!-- IMF Code -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><?= $page['code3'] ?> Code </label><br>

                                        <input type="hidden" name="imf_code" value="0">

                                        <input type="checkbox" name="imf_code" value="1"
                                            <?php echo ($page['imf_code'] == '1') ? 'checked' : ''; ?>
                                            data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="primary"
                                            data-offstyle="secondary" data-width="80">
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-4 col-sm-12">
                                    <!-- COT Code Option -->
                                    <div class="form-group">
                                        <label>First Code Name</label>
                                        <input type="text" class="form-control" name="code1"
                                            value="<?= $page['code1'] ?>" placeholder="<?= $page['code1'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>2nd Code Name</label>
                                        <input type="text" class="form-control" name="code2"
                                            value="<?= $page['code2'] ?>" placeholder="<?= $page['code2'] ?>">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>3rd Code Name</label>
                                        <input type="text" class="form-control" name="code3"
                                            value="<?= $page['code3'] ?>" placeholder="<?= $page['code3'] ?>">
                                    </div>
                                </div>
                            </div>

                            <br>

                            <h4 class="mb-5 mt-5"><strong>TRANSFER FEES AND LIMITS</strong></h4>

                            <br>
                            <div class="row">

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Wire Transfer fee</label>
                                        <input type="text" class="form-control" name="wirefee"
                                            value="<?= $page['wirefee'] ?>" placeholder="Wire Transfer Fee">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Domestic Transfer fee</label>
                                        <input type="text" class="form-control" name="domesticfee"
                                            value="<?= $page['domesticfee'] ?>" placeholder="Domestic Transfer Fee">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Request Card fee</label>
                                        <input type="text" class="form-control" name="cardfee"
                                            value="<?= $page['cardfee'] ?>" placeholder="Card Fee">
                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Domestic Transfer Limit</label>
                                        <input type="text" class="form-control" name="domesticlimit"
                                            value="<?= $page['domesticlimit'] ?>" placeholder="Domestic Transfer Limit">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Wire Transfer Limit</label>
                                        <input type="text" class="form-control" name="wirelimit"
                                            value="<?= $page['wirelimit'] ?>" placeholder="Wire Transfer Limit">
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Loan Limit</label>
                                        <input type="text" class="form-control" name="loanlimit"
                                            value="<?= $page['loanlimit'] ?>" placeholder="Loan Limit">
                                    </div>
                                </div>
                            </div>
                            <div class="row">



                                <div class="col-md-4 col-sm-12">

                                    <div class="form-group">
                                        <label>Twillio Config Option</label>
                                        <input type="hidden" name="twillio_status" value="0">

                                        <input disabled type="checkbox" name="twillio_status" value="1"
                                            <?php echo ($page['twillio_status'] == '1') ? 'checked' : ''; ?>
                                            data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="primary"
                                            data-offstyle="secondary" data-width="80">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">

                                    <div class="form-group">
                                        <label>Routine No. Option</label>
                                        <input type="hidden" name="routine" value="0">

                                        <input type="checkbox" name="routine" value="1"
                                            <?php echo ($page['routine'] == '1') ? 'checked' : ''; ?>
                                            data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="primary"
                                            data-offstyle="danger" data-width="80">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">

                                    <div class="form-group">
                                        <label>Swift Code Option</label>
                                        <input type="hidden" name="swift" value="1">

                                        <input type="checkbox" name="swift" value="1"
                                            <?php echo ($page['swift'] == '1') ? 'checked' : ''; ?> data-toggle="toggle"
                                            data-on="On" data-off="Off" data-onstyle="primary" data-offstyle="secondary"
                                            data-width="80">
                                    </div>
                                </div>
                            </div>
                            <style>
                                .toggle-off.btn {
                                    background-color: darkred;
                                    color: white;
                                }
                            </style>

                            <!-- <div class="form-group">
                                <label>User Transfer Option (disabled)</label>
                                <select class="form-control select2" disabled style="width: 100%;">
                                    <option value="">Select Option</option>
                                    <option value="1">On</option>
                                    <option value="0">Off</option>
                                </select>
                            </div> -->






                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="save_settings" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>


        <!-- /.box -->
        <div class="row">

            <!-- LOGO UPLOAD -->
            <div class="col-md-6">
                <div>Logo Image</div>

                <img id="logoPreview" src="assets/images/logo/<?= $page['image'] ?>"
                    style="max-width: 150px; display:block; margin-bottom:10px;">

                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control" name="image" id="logoInput" data-max-file-size="2M" />
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="upload_picture" class="btn btn-primary">
                            Change Image
                        </button>
                    </div>
                </form>
                <br><br>
            </div>

            <!-- FAVICON UPLOAD -->
            <div class="col-md-6">
                <div>Favicon</div>

                <img id="faviconPreview" src="assets/images/logo/<?= $page['favicon'] ?>"
                    style="max-width: 64px; display:block; margin-bottom:10px;">

                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control" name="favicon" id="faviconInput"
                            data-max-file-size="2M" />
                    </div>
                    <div class="box-footer">
                        <button type="submit" name="upload_favicon" class="btn btn-primary">
                            Change Image
                        </button>
                    </div>
                </form>
                <br><br>
            </div>

        </div>
        <script>
            document.getElementById("logoInput").addEventListener("change", function() {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("logoPreview").src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            });

            document.getElementById("faviconInput").addEventListener("change", function() {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("faviconPreview").src = e.target.result;
                }
                reader.readAsDataURL(this.files[0]);
            });
        </script>


        <!-- /.box -->



    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>
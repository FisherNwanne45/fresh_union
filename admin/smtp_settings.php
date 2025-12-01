<?php
require_once __DIR__ . '/../config.php';
$pageName  = "SMTP Settings";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available
// include(ROOT_PATH."/admin/include/adminFunction.php");
//require_once("./include/adminloginFunction.php");

$sql = "SELECT * FROM smtp_setting WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$rowsmtp = $stmt->fetch(PDO::FETCH_ASSOC);



if (isset($_POST['save_smtpsettings'])) {
    $host = $_POST['host'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $port = $_POST['port'];
    $display_name = $_POST['display_name'];
    $smtp_auth = $_POST['smtp_auth'];
    $id = "1";
    $sql = "UPDATE smtp_setting SET host=:host,username=:username,password=:password,port=:port,display_name=:display_name,smtp_auth=:smtp_auth WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'host' => $host,
        'username' => $username,
        'password' => $password,
        'port' => $port,
        'display_name' => $display_name,
        'smtp_auth' => $smtp_auth,
        'id' => $id
    ]);

    if (true) {

        $msg1 = "
       <div class='alert alert-warning'>
       
       <script type='text/javascript'>
            
               function Redirect() {
               window.location='';
               }
               document.write ('');
               setTimeout('Redirect()', 4000);
            
               </script>
               
       <center><img src='../assets/images/loading.gif' width='180px'  /></center>
       
       
       <center>	<strong style='color:black;'>Updated successfully, Please Wait while we redirect you...
              </strong></center>
         </div>
       ";
    } else {
        //  toast_alert('error', 'Sorry something went wrong');
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            SMTP Settings
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
                    <p>How to get SMTP Credentials from cPanel ? <a
                            href="https://www.labelhosting.com/knowledgebase.php?action=displayarticle&id=116"
                            target="_blank">View Guide</a></p><br>
                    <div class="row">

                        <?php if (isset($msg1)) echo $msg1; ?>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Display Name</label>
                                <input type="text" class="form-control" name="display_name" required
                                    value="<?= $rowsmtp['display_name'] ?>" placeholder="Display Name">

                            </div>
                            <!-- /.form-group -->
                            <div class="form-group">
                                <label>STMP Host</label>
                                <input type="text" class="form-control" name="host" required
                                    value="<?= $rowsmtp['host'] ?>" placeholder="STMP Host">
                                <p>incoming server url</p>
                            </div>

                            <div class="form-group">
                                <label>SMTP Secure</label>
                                <input type="text" class="form-control" name="smtp_auth" required
                                    value="<?= $rowsmtp['smtp_auth'] ?>" placeholder="SMTP Secure">
                                <p>ssl/tls</p>
                            </div>





                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>SMTP Port</label>
                                <input type="text" class="form-control" name="port" required
                                    value="<?= $rowsmtp['port'] ?>" placeholder="SMTP Port">
                                <p>465/587</p>
                            </div>
                            <div class="form-group">
                                <label>SMTP Username</label>
                                <input type="text" class="form-control" name="username" required
                                    value="<?= $rowsmtp['username'] ?>" placeholder="SMTP Username">
                                <p>Email address</p>
                            </div>


                            <div class="form-group">
                                <label>SMTP Password</label>
                                <input type="text" class="form-control" name="password" required
                                    value="<?= $rowsmtp['password'] ?>" placeholder="SMTP Password">
                                <p>Email Password</p>
                            </div>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="save_smtpsettings" class="btn btn-primary">Save Settings</button>
                </div>
            </form>
        </div>


        <br>
        <!-- /.box -->



    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>
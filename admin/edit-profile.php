<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Edit Admin Profile";
include(ROOT_PATH . "/admin/layout/header.php");

$adminName = $admin['firstname'] . " " . $admin['lastname'];




if (isset($_POST['profile'])) {
    $admin_email = $_POST['admin_email'];
    $admin_id = 1;
    $sql = "UPDATE admin SET admin_email=:admin_email WHERE id=:admin_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'admin_email' => $admin_email,
        'admin_id' => $admin_id
    ]);

    if (true) {
        // toast_alert('success','Account updated successfully','Approved');
        $msg1 = "
       <div class='alert alert-warning'>
       
       <script type='text/javascript'>
            
               function Redirect() {
               window.location='./dashboard';
               }
               document.write ('');
               setTimeout('Redirect()', 3000);
            
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

if (isset($_POST['change_password'])) {
    $old_password = inputValidation($_POST['old_password']);
    $new_password = inputValidation($_POST['new_password']);
    $confirm_password = inputValidation($_POST['confirm_password']);

    $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);
    $verification = password_verify($old_password, $admin['admin_password']);

    if ($verification === false) {
        toast_alert("error", "Incorrect Old Password");
    } else if ($new_password !== $confirm_password) {
        toast_alert("error", "Confirm Password not matched");
    } else if ($new_password === $old_password) {
        toast_alert('error', 'New Password Matched with Old Password');
    } else {
        $admin_id = 1;
        $sql2 = "UPDATE admin SET admin_password=:admin_password WHERE id=:admin_id";
        $passwordUpdate = $conn->prepare($sql2);
        $passwordUpdate->execute([
            'admin_password' => $new_password2,
            'admin_id' => $admin_id
        ]);
        if (true) {
            toast_alert('success', 'Your Password Change Successfully !', 'Approved');
        } else {
            // toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Profile
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Admin Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form enctype="multipart/form-data" method="POST">
                        <div class="box-body">
                            <?php if (isset($msg1)) echo $msg1; ?>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Admin Full Name</label>
                                <input type="text" disabled class="form-control" placeholder="<?= $adminName ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Email address</label>
                                <input type="email" name="admin_email" class="form-control"
                                    placeholder="<?= $admin['admin_email'] ?>" required>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="profile" class="btn btn-primary">Change Email</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Change Password</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form enctype="multipart/form-data" method="POST">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Old Password</label>
                                <input type="password" class="form-control" name="old_password"
                                    placeholder="Old Password" value="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">New Password</label>
                                <input type="password" class="form-control" name="new_password"
                                    placeholder="New Password" value="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password"
                                    placeholder="Confirm Password">
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" name="change_password" class="btn btn-primary">Change
                                Password</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>
<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Edit Virtual Cards";
include(ROOT_PATH . "/admin/layout/header.php");


$id = $_GET['id'];

$sql2 = "SELECT * FROM card WHERE seria_key=:seria_key";
$stmt = $conn->prepare($sql2);
$stmt->execute([
    'seria_key' => $id
]);

$cardCheck = $stmt->fetch(PDO::FETCH_ASSOC);

$card_number = explode(' ', $cardCheck['card_number']);

// $card_type = getCardType($cardCheck);
$card_status = getCardStatus($cardCheck);

if (isset($_POST['process_card'])) {
    $status = 2;
    $sql2 = "UPDATE card SET card_status=:card_status WHERE seria_key=:seria_key";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status' => $status,
        'seria_key' => $id
    ]);
    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./cards';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Credit Card On Hold Successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";

        //  toast_alert('success','Credit Card On Hold Successfully','success');
    } else {
        //        notify_alert('Sorry Something Went Wrong','danger','2000','Close');
        //   toast_alert('error', 'Sorry Something Went Wrong');
    }
}

if (isset($_POST['hold_card'])) {
    $status = 3;
    $sql2 = "UPDATE card SET card_status=:card_status WHERE seria_key=:seria_key";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status' => $status,
        'seria_key' => $id
    ]);
    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./cards';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Credit Card On Hold Successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";

        //  toast_alert('success','Credit Card On Hold Successfully','success');
    } else {
        //        notify_alert('Sorry Something Went Wrong','danger','2000','Close');
        //  toast_alert('error', 'Sorry Something Went Wrong');
    }
}

if (isset($_POST['active_card'])) {
    $status = 1;

    $sql2 = "UPDATE card SET card_status=:card_status WHERE seria_key=:seria_key";
    $stmt = $conn->prepare($sql2);
    $stmt->execute([
        'card_status' => $status,
        'seria_key' => $id
    ]);
    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./cards';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Credit Card Active Successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";

        // toast_alert('success','Credit Card Active Successfully','success');
    } else {
        //  toast_alert('error', 'Sorry Something Went Wrong');
    }
}


?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Virtual Cards
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
                            <table class="table table-bordered mb-4">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <th><?= $cardCheck['card_name'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>Number</th>
                                        <th><?= $cardCheck['card_number'] ?></th>
                                    </tr>

                                    <tr>
                                        <th>Status</th>
                                        <th><?= $card_status ?></th>
                                    </tr>

                                    <tr>
                                        <th>Date Applied</th>
                                        <th><?= $cardCheck['createdAt'] ?></th>
                                    </tr>






                                </tbody>
                            </table>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <table class="table table-bordered mb-4">
                                <tbody>
                                    <tr>
                                        <th>Expires</th>
                                        <th><?= $cardCheck['card_expiration'] ?></th>
                                    </tr>
                                    <tr>
                                        <th>Cvc Number</th>
                                        <th><?= $cardCheck['card_security'] ?></th>
                                    </tr>

                                    <tr>
                                        <th>Limits</th>
                                        <th><?= $currency . $cardCheck['card_limit'] ?></th>
                                    </tr>

                                    <tr>
                                        <th>Limits Remain</th>
                                        <th><?= $currency . $cardCheck['card_limit_remain'] ?></th>
                                    </tr>






                                </tbody>
                            </table>







                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">


                    <button class="btn btn-success" name="process_card">Process Card</button>

                    <button class="btn btn-success" name="hold_card">Hold Card</button>

                    <button class="btn btn-success" name="active_card">Activate Card</button>




                </div>
            </form>
        </div>
        <!-- /.box -->




    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>
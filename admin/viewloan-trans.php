<?php
require_once __DIR__ . '/../config.php';
$pageName  = "View Loan";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


$id = $_GET['id'];
$id = $_GET['id'];
$sql = "SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE refrence_id =:id";
$data = $conn->prepare($sql);
$data->execute([
    'id' => $id
]);

$result = $data->fetch(PDO::FETCH_ASSOC);
$transStatus = TranStatus($result);
$id1 = $result['id'];

$amount = $result['amount'];


if (isset($_POST['accept'])) {
    $status_value = "completed";
    $sql = "UPDATE transactions SET trans_status=:dom_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'dom_status' => $status_value,
        'id' => $id
    ]);

    if (true) {
        $amount = $result['amount'];
        $available_loan = $result['loan_balance'] + $amount;
        $sql = "UPDATE users SET loan_balance=:loan_balance WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'loan_balance' => $available_loan,
            'id' => $id1
        ]);
    }

    $full_name = $result['firstname'] . " " . $result['lastname'];
    $loan_balance = $result['loan_balance'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $user_email = $result['acct_email'];
    $user_acctno = $result['acct_no'];
    $trans_status = "paid";
    $message = $sendMail->AdminLoanMsg($full_name, $amount, $loan_balance, $user_acctno, $trans_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    // User Email
    $subject = "Loan Application" . "-" . $APP_NAME;
    $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./loan-trans.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Transaction updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        //  toast_alert('error', 'Sorry Something Went Wrong');
    }
}

if (isset($_POST['decline'])) {
    $status_value = "failed";
    $sql = "UPDATE transactions SET trans_status=:dom_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'dom_status' => $status_value,
        'id' => $id
    ]);

    $amount = $result['amount'];
    $amount_balance = $result['acct_balance'] + $result['amount'];

    $sql = "UPDATE users SET acct_balance=:acct_balance WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_balance' => $amount_balance,
        'id' => $id1
    ]);

    $full_name = $result['firstname'] . " " . $result['lastname'];
    $loan_balance = $result['loan_balance'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $user_email = $result['acct_email'];
    $user_acctno = $result['acct_no'];
    $trans_status = "failed";
    $message = $sendMail->AdminLoanMsg($full_name, $amount, $loan_balance, $user_acctno, $trans_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    // User Email
    $subject = "Loan Application" . "-" . $APP_NAME;
    $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./loan-trans.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Transaction updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        //    toast_alert('error', 'Sorry Something Went Wrong');
    }
}

if (isset($_POST['hold'])) {
    $status_value = "processing";
    $sql = "UPDATE transactions SET trans_status=:dom_status WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'dom_status' => $status_value,
        'id' => $id
    ]);

    $full_name = $result['firstname'] . " " . $result['lastname'];
    $loan_balance = $result['loan_balance'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $user_email = $result['acct_email'];
    $user_acctno = $result['acct_no'];
    $trans_status = "processing";
    $message = $sendMail->AdminLoanMsg($full_name, $amount, $loan_balance, $user_acctno, $trans_status, $APP_NAME, $APP_URL, $SITE_ADDRESS);
    // User Email
    $subject = "Loan Application" . "-" . $APP_NAME;
    $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./loan-trans.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Transaction updated successfully, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
    } else {
        //   toast_alert('error', 'Sorry Something Went Wrong');
    }
}



?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Loan Request
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <?php if (isset($msg1)) echo $msg1; ?>
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form class="section general-info" method="POST">

                                    <div class="info">
                                        <div class="row">
                                            <div class="col-md-12 offset-md-2 table-responsive">
                                                <table class="table table-bordered mb-4">
                                                    <tbody>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th class="text-uppercase"><?= ucwords($fullName) ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Amount Requested</th>
                                                            <th><?= $currency ?><?php echo number_format($amount, 2, '.', ','); ?>
                                                            </th>
                                                        </tr>

                                                        <tr>
                                                            <th>Created At</th>
                                                            <th><?= $result['created_at'] ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Account No</th>
                                                            <th><?= $result['acct_no'] ?></th>
                                                        </tr>

                                                        <tr>
                                                            <th>Account Balance</th>
                                                            <th><?= $currency . $result['acct_balance'] ?></th>
                                                        </tr>
                                                        <tr>
                                                            <th>Loan Balance</th>
                                                            <th><?= $currency . $result['loan_balance'] ?></th>
                                                        </tr>



                                                        <tr>
                                                            <th>Status</th>
                                                            <th><?= $transStatus ?></th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 offset-md-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="" class="text-center text-info">Copy This Text for
                                                            Message inbox </label>
                                                        <textarea class="form-control mb-4 text-danger" rows="2"
                                                            id="textarea-copy" placeholder="Loan Description"
                                                            style="resize: none" value=""
                                                            readonly>Dear <?= $fullName ?>  This is to inform you that your loan of <?= $currency . $result['amount'] ?> have been Approved Successfully Thanks</textarea>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="box-body pad">

                                                        </div>


                                                        <div class="box-footer">
                                                            <div class="box-footer">
                                                                <button type="submit" name="accept"
                                                                    class="btn btn-success">Accept</button>

                                                                <button type="submit" name="hold"
                                                                    class="btn btn-warning">Hold</button>

                                                                <button type="submit" name="decline"
                                                                    class="btn btn-danger">Decline</button>


                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->


            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>
<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Edit Stocks Transactions";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available

$id = $_GET['id'];
$sql = "SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE refrence_id =:id";
$data = $conn->prepare($sql);
$data->execute([
    'id' => $id
]);

$result = $data->fetch(PDO::FETCH_ASSOC);
$transStatus = TranStatus($result);
$id1 = $result['id'];
$user_id = $result['id'];



$amount = $result['amount'];


if (isset($_POST['accept'])) {
    $value = $result['amount'];
    $sql = "DELETE FROM transactions WHERE refrence_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'id' => $id
    ]);
    $interest = $page['stocks'];
    $amount_balance = $result['acct_balance'] + $result['amount'] + $interest;

    $sql = "UPDATE users SET acct_balance=:acct_balance WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_balance' => $amount_balance,
        'id' => $id1
    ]);

    $refrence_id = uniqid();
    $trans_type = "Stocks";
    $transaction_type = "credit";
    $trans_status = "paid";
    $account_name = $result['account_name'];
    $amount = $value + $interest;


    $sql = "INSERT INTO transactions (amount,account_name,refrence_id,user_id,trans_type,transaction_type,trans_status) VALUES(:amount,:account_name,:refrence_id,:user_id,:trans_type,:transaction_type,:trans_status)";
    $tranfered = $conn->prepare($sql);
    $tranfered->execute([
        'amount' => $amount,
        'account_name' => $account_name,
        'refrence_id' => $refrence_id,
        'user_id' => $user_id,
        'trans_type' => $trans_type,
        'transaction_type' => $transaction_type,
        'trans_status' => $trans_status
    ]);



    $full_name = $result['firstname'] . " " . $result['lastname'];
    $user_balance = $result['acct_balance'];
    $APP_NAME = WEB_TITLE;
    $APP_URL = WEB_URL;
    $SITE_ADDRESS = $page['url_address'];
    $user_email = $result['acct_email'];
    $message = $sendMail->AdminStockMsg($full_name, $amount, $user_balance, $trans_status, $trans_type, $APP_NAME, $APP_URL, $SITE_ADDRESS);

    // User Email
    $subject = "Stocks Interest" . "-" . $APP_NAME;
    $email_message->send_mail($user_email, $message, $subject);

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./stocks-trans.php';
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

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./stocks-trans.php';
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
        //     toast_alert('error', 'Sorry Something Went Wrong');
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

    if (true) {
        $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./stocks-trans.php';
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




?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Stocks Transactions
        </h1>
        <ol class="breadcrumb">
            <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>



    <!-- Main content -->
    <section class="content">

        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">

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

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" class="form-control" name="amount"
                                placeholder="<?= $result['amount'] ?>" value="<?= $result['amount'] ?>" required>
                        </div>



                        <div class="form-group">
                            <label>Stock Name</label>
                            <input type="text" class="form-control" name="account_name"
                                placeholder="<?= $result['account_name'] ?>" value="<?= $result['account_name'] ?>"
                                required>
                        </div>



                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" class="form-control" name="created_at"
                                placeholder="<?= $result['created_at'] ?>" value="<?= $result['created_at'] ?>"
                                required>
                        </div>

                        <br>
                        <p>User gets X1 on stock amount when u approve


                            <br>




                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <form method="POST">
                <div class="box-footer">
                    <button type="submit" name="accept" class="btn btn-success">Pay interest now</button>


                    <button type="submit" name="decline" class="btn btn-danger">Reject purchase</button>
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
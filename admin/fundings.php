<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Credit/Debit Users";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


if (isset($_POST['credit'])) {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $created_at = $_POST['created_at'];


    $sql = "SELECT * FROM users WHERE id =:user_id";
    $checkUser = $conn->prepare($sql);
    $checkUser->execute([
        'user_id' => $user_id
    ]);
    $result = $checkUser->fetch(PDO::FETCH_ASSOC);

    $available_balance = $amount + $result['acct_balance'];

    $sql = "UPDATE users SET acct_balance=:available_balance WHERE id=:user_id";
    $addUp = $conn->prepare($sql);
    $addUp->execute([
        'available_balance' => $available_balance,
        'user_id' => $user_id
    ]);


    if (true) {
        $refrence_id = uniqid();
        $trans_type = "Credit";
        $transaction_type = "credit";
        $trans_status = "completed";
        $sql = "INSERT INTO transactions (amount,refrence_id,user_id,trans_type,transaction_type,trans_status,description,created_at) VALUES(:amount,:refrence_id,:user_id,:trans_type,:transaction_type,:trans_status,:description,:created_at)";
        $tranfered = $conn->prepare($sql);
        $tranfered->execute([
            'amount' => $amount,
            'refrence_id' => $refrence_id,
            'user_id' => $user_id,
            'trans_type' => $trans_type,
            'transaction_type' => $transaction_type,
            'trans_status' => $trans_status,
            'description' => $description,
            'created_at' => $created_at

        ]);



        $full_name = $result['firstname'] . " " . $result['lastname'];
        $user_balance = $result['acct_balance'];
        $user_acctno = $result['acct_no'];
        $APP_NAME = WEB_TITLE;
        $APP_URL = WEB_URL;
        $SITE_ADDRESS = $page['url_address'];
        $user_email = $result['acct_email'];
        $acct_currency = $result['acct_currency'];
        $message = $sendMail->AdminFundingMsg($full_name, $amount, $user_balance, $user_acctno, $trans_status, $trans_type, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS);
        // User Email
        $subject = "Credit Notification" . "-" . $APP_NAME;
        $email_message->send_mail($user_email, $message, $subject);

        if (true) {
            toast_alert('success', 'Account Fund Successfully', 'Approved');
        } else {
            //  toast_alert('error', 'Sorry Something Went Wrong');
        }
    }
} else if (isset($_POST['debit'])) {
    $user_id = $_POST['user_id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $created_at = $_POST['created_at'];

    $sql = "SELECT * FROM users WHERE id =:user_id";
    $checkUser = $conn->prepare($sql);
    $checkUser->execute([
        'user_id' => $user_id
    ]);
    $result = $checkUser->fetch(PDO::FETCH_ASSOC);

    if ($amount > $result['acct_balance']) {
        toast_alert('error', 'Insufficient Balance');
    } else {
        $available_balance = ($result['acct_balance'] - $amount);

        $sql = "UPDATE users SET acct_balance=:available_balance WHERE id=:user_id";
        $addUp = $conn->prepare($sql);
        $addUp->execute([
            'available_balance' => $available_balance,
            'user_id' => $user_id
        ]);

        if (true) {
            $refrence_id = uniqid();
            $trans_type = "Debit";
            $transaction_type = "debit";
            $trans_status = "completed";
            $sql = "INSERT INTO transactions (amount,refrence_id,user_id,trans_type,transaction_type,trans_status,description,created_at) VALUES(:amount,:refrence_id,:user_id,:trans_type,:transaction_type,:trans_status,:description,:created_at)";
            $tranfered = $conn->prepare($sql);
            $tranfered->execute([
                'amount' => $amount,
                'refrence_id' => $refrence_id,
                'user_id' => $user_id,
                'trans_type' => $trans_type,
                'transaction_type' => $transaction_type,
                'trans_status' => $trans_status,
                'description' => $description,
                'created_at' => $created_at
            ]);

            $full_name = $result['firstname'] . " " . $result['lastname'];
            $user_balance = $result['acct_balance'];
            $user_acctno = $result['acct_no'];
            $APP_NAME = WEB_TITLE;
            $APP_URL = WEB_URL;
            $SITE_ADDRESS = $page['url_address'];
            $user_email = $result['acct_email'];
            $acct_currency = $result['acct_currency'];
            $message = $sendMail->AdminFundingMsg($full_name, $amount, $user_balance, $user_acctno, $trans_status, $trans_type, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS);
            // User Email
            $subject = "Debit" . "-" . $APP_NAME;
            $email_message->send_mail($user_email, $message, $subject);

            if (true) {
                toast_alert('success', 'Account Debit Successfully', 'Approved');
            } else {
                //   toast_alert('error', 'Sorry Something Went Wrong');
            }
        }
    }
}


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Credit/Debit User
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
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                            class="fa fa-remove"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form method="POST">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select user</label>
                                <select name="user_id" class="form-control select2" style="width: 100%;" required>
                                    <option selected="selected">Select User</option>

                                    <?php
                                    $sql = "select * from users order by id ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $fullName = $row['firstname'] . " " . $row['lastname']

                                    ?>
                                        <option value="<?= $row['id'] ?>"><?= ucwords($fullName) ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- /.form-group -->

                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" name="amount" placeholder="0" required>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control" name="description" placeholder="description"
                                    required>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="datetime-local" class="form-control" name="created_at"
                                    placeholder="00:00:00" required>
                            </div>

                        </div>


                        <!-- /.col -->
                    </div>

                    <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="credit" class="btn btn-primary">Credit</button>

                <button type="submit" name="debit" class="btn btn-danger">Debit</button>
            </div>
        </div>
        <!-- /.box -->

        </form>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->



<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>
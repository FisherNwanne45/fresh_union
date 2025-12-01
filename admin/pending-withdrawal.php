<?php

require_once __DIR__ . '/../config.php';
$pageName  = "Pending Withdrawal Transactions";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


//$balances = $row['acct_balance']->rowCount();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pending Withdrawal Transactions
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
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-center dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE trans_type='Crypto Withdrawal' AND trans_status='processing' ORDER BY trans_id DESC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $sn = 1;
                                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $transStatus = TranStatus($result);


                                        $fullName = $result['firstname'] . " " . $row['lastname'];
                                        $amount = $result['amount'];
                                    ?>
                                        <tr>

                                            <td><?= $sn++ ?></td>
                                            <td><?= $fullName ?></td>
                                            <td><?= $currency ?><?php echo number_format($amount, 2, '.', ','); ?></td>
                                            <td><?= $transStatus ?></td>
                                            <td><?= $result['created_at'] ?></td>
                                            <td class="text-center">
                                                <a href="./view-withdrawal.php?id=<?php echo $result['refrence_id']; ?>"
                                                    class="btn btn-primary">View</a>
                                                <a href="./delete_deposit.php?id=<?php echo $result['refrence_id']; ?>"
                                                    class="btn btn-danger">Del</a>


                                            </td>

                                        </tr>

                                    <?php
                                    }
                                    ?>


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <br>
                                    </tr>
                                </tfoot>
                            </table>
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
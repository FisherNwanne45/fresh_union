<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Domestic Transactions";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


//$balances = $result['acct_balance']->rowCount();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Domestic Transactions
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
                                        <th>Bank Name</th>
                                        <th>Account Name</th>
                                        <th>Account Number</th>
                                        <th>Account Type</th>
                                        <th>Transfer Type</th>
                                        <th>Transfer Status</th>
                                        <th class="text-center dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE trans_type='Domestic transfer' ORDER BY trans_id DESC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $sn = 1;
                                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $transStatus = TranStatus($result);


                                        $fullName = $result['firstname'] . " " . $result['lastname'];
                                        $amount = $result['amount'];
                                    ?>
                                        <tr>

                                            <td><?= $sn++ ?></td>
                                            <td><?= $fullName ?></td>
                                            <td><?= $currency ?><?php echo number_format($amount, 2, '.', ','); ?></td>
                                            <td><?= $result['bank_name'] ?></td>
                                            <td><?= $result['account_name'] ?></td>
                                            <td><?= $result['account_number'] ?></td>
                                            <td><?= $result['acct_type'] ?></td>
                                            <td><?= ucwords($result['trans_type']) ?></td>
                                            <td><?= $transStatus ?></td>
                                            <td class="text-center">
                                                <a href="./view-domtrans.php?id=<?php echo $result['refrence_id']; ?>"
                                                    class="btn btn-primary">Edit</a>
                                                <a href="./delete_dom.php?id=<?php echo $result['refrence_id']; ?>"
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
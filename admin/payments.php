<?php
require_once __DIR__ . '/../config.php';
$pageName  = "All Digital Payment";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


if (isset($_POST['crypto_save'])) {
    $crypto_name = $_POST['crypto_name'];
    $wallet_address = $_POST['wallet_address'];

    $sql = "INSERT INTO crypto_currency (crypto_name,wallet_address)VALUES(:crypto_name,:wallet_address)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'crypto_name' => $crypto_name,
        'wallet_address' => $wallet_address
    ]);

    if (true) {
        toast_alert('success', 'Payment Add Successfully', 'Success');
    } else {
        //  toast_alert('error', 'Something Went Wrong');
    }
}


//$balances = $row['acct_balance']->rowCount();

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Digital Payment
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

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#payments">
                            Add New Payment
                        </button>
                        <br>
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Details</th>
                                        <th>Date</th>
                                        <th class="text-center dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM crypto_currency WHERE id";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $sn = 1;
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {



                                    ?>
                                        <tr>

                                            <td><?= $sn++ ?></td>
                                            <td><?= $row['crypto_name'] ?></td>
                                            <td><?= $row['wallet_address'] ?></td>
                                            <td><?= $row['created_at'] ?></td>
                                            <td class="text-center">
                                                <a href="./delete_payments.php?id=<?php echo $row['id']; ?>"
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


<div class="modal fade" id="payments">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create New Payment</h4>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <p>
                        <input type="text" class="form-control" name="crypto_name" require placeholder="Payment Name">
                    </p>

                    <p>
                        <input type="text" class="form-control" name="wallet_address" require
                            placeholder="Payment Details">
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="crypto_save">Save changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<?php
include(ROOT_PATH . "/admin/layout/footer.php");

?>
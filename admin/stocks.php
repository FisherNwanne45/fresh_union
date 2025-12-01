<?php
require_once __DIR__ . '/../config.php';
$pageName  = "All Stocks Products";
include(ROOT_PATH . "/admin/layout/header.php");

// Ofofonobs Developer WhatsAPP +2348114313795


// Bank Script Developer - Use For Educational Purpose Only

// Other scripts Available


if (isset($_POST['stocks_save'])) {
    $stock_name = $_POST['stock_name'];
    $stock_price = $_POST['stock_price'];
    $stock_percentage = $_POST['stock_percentage'];

    $sql = "INSERT INTO stocks (stock_name,stock_price,stock_percentage)VALUES(:stock_name,:stock_price,:stock_percentage)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'stock_name' => $stock_name,
        'stock_price' => $stock_price,
        'stock_percentage' => $stock_percentage
    ]);

    if (true) {
        toast_alert('success', 'Stock Added Successfully', 'Success');
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
            Stocks Products
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

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#stocks">
                            Add New Stocks
                        </button>
                        <br>
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>%</th>
                                        <th>Date</th>
                                        <th class="text-center dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM stocks WHERE id";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $sn = 1;
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {



                                    ?>
                                        <tr>

                                            <td><?= $sn++ ?></td>
                                            <td><?= $row['stock_name'] ?></td>
                                            <td><?= $row['stock_price'] ?></td>
                                            <td><?= $row['stock_percentage'] ?></td>
                                            <td><?= $row['created_at'] ?></td>
                                            <td class="text-center">
                                                <a href="./delete_stocks.php?id=<?php echo $row['id']; ?>"
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


<div class="modal fade" id="stocks">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Create New Stocks</h4>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <p><label>Stock Name</label>
                        <input type="text" class="form-control" name="stock_name" require placeholder="Stock Name">
                    </p>

                    <p><label>Stock Price</label>
                        <input type="text" class="form-control" name="stock_price" inputmode="numeric" required
                            pattern="[0-9]+" maxlength="10" autocomplete="off" require placeholder="0.00">
                    </p>
                    <p><label>Percentage ROI</label>
                        <input type="text" inputmode="numeric" required pattern="[1-9]+" maxlength="2"
                            autocomplete="off" class="form-control" name="stock_percentage" require placeholder="1-99">
                    </p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="stocks_save">Save changes</button>
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
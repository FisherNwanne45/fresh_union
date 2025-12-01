<?php
require_once __DIR__ . '/../config.php';
$pageName  = "All Virtual Cards";
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
            All Virtual Cards
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
                                        <th>Name</th>
                                        <th>Number</th>
                                        <th>Exp</th>
                                        <th>Cvc</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th class="text-center dt-no-sorting">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM card LEFT JOIN users ON card.user_id = users.id order by card.user_id DESC ";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $sn = 1;
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $card_status = getCardStatus($row);



                                        $fullName = $row['firstname'] . " " . $row['lastname'];
                                        $currency
                                    ?>
                                        <tr>

                                            <td><?= $sn++ ?></td>
                                            <td><?= $fullName ?></td>
                                            <td><?= $row['card_number'] ?></td>
                                            <td><?= $row['card_expiration'] ?></td>
                                            <td><?= $row['card_security'] ?></td>
                                            <td><?= $card_status ?></td>
                                            <td><?= $row['createdAt'] ?></td>
                                            <td class="text-center">
                                                <a href="./view_cards.php?id=<?php echo $row['seria_key']; ?>"
                                                    class="btn btn-primary">View</a>
                                                <a href="./delete_cards.php?id=<?php echo $row['seria_key']; ?>"
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
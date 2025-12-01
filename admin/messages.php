<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Support Tickets";
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
            All Tickets
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
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>Ticket ID</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM ticket order by user_id ASC";
                                $stmt = $conn->prepare($sql);
                                $stmt->execute();
                                $sn = 1;
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                ?>
                                    <tr>
                                        <!-- <td><?= $sn++ ?></td> -->
                                        <td><?= $row['ticket_id'] ?></td>
                                        <td><?= $row['ticket_message'] ?></td>
                                        <td><?= $row['createdAt'] ?></td>
                                        <td class="text-center">
                                            <a href="./view_users.php?id=<?php echo $row['user_id']; ?>"
                                                class="btn btn-primary">View User</a>
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
<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Users";
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
            All Users
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
                                        <th>No</th>
                                        <th>Account No</th>
                                        <th>User</th>
                                        <th>Password / Pin</th>
                                        <th>Balance</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM users order by id ASC";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $sn = 1;
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $fullName = $row['firstname'] . " " . $row['lastname'];
                                        $userStatus = userStatus($row);
                                    ?>
                                        <tr>
                                            <td><?= $sn++ ?></td>
                                            <td><?= $row['acct_no'] ?></td>
                                            <td><?= $fullName ?><br><?= $row['acct_email'] ?></td>
                                            <td><?= $row['confirm_password'] ?><br><b>Pin:</b> <?= $row['acct_pin'] ?></td>

                                            <td><?= $row['acct_currency'] ?><?= $row['acct_balance'] ?></td>
                                            <td><?= $row['acct_type'] ?></td>
                                            <td><?= $userStatus; ?></td>
                                            <td><?= $row['createdAt'] ?></td>
                                            <td class="text-center">
                                                <a href="./view_users.php?id=<?php echo $row['id']; ?>"
                                                    class="btn btn-primary">View / Edit</a>
                                                <a href="./delete_user.php?id=<?php echo $row['id']; ?>"
                                                    class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this user?');">Del</a>

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
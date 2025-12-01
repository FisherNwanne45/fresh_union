<?php
ob_start();
session_start();
require_once(ROOT_PATH . "/admin/include/adminloginFunction.php");
require_once(ROOT_PATH . "/admin/include/session.php");

if (@$_SESSION['admin']) {
    header('Location:./dashboard.php');
}

$email_message = new message();
$sendMail = new emailMessage();

if (isset($_POST['admin_login'])) {
    $admin_email = inputValidation($_POST['admin_email']);
    $admin_password = inputValidation($_POST['admin_password']);

    $sql = "SELECT * FROM admin WHERE admin_email=:admin_email";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'admin_email' => $admin_email
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() === 0) {
        toast_alert('error', 'incorrect password / email');
    } else {
        $validPassword = password_verify($admin_password, $row['admin_password']);

        if ($validPassword === false) {
            toast_alert('error', 'incorrect password / email');
        } else {
            $_SESSION['admin'] = $admin_email;
            echo '<script>window.location.replace("./dashboard.php");</script>';
            exit;
        }
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $pageName  ?> - Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">



    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/plugins/iCheck/square/blue.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css" integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="<?= $web_url ?>/assets/user/js/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
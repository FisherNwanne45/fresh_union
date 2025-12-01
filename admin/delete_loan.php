<?php
require_once __DIR__ . '/../config.php';
$pageName  = "Deleting";
include(ROOT_PATH . "/admin/layout/header.php");

$id = $_GET['id'];

// Use prepared statement to avoid SQL injection
$sql = "SELECT * FROM transactions LEFT JOIN users ON transactions.user_id = users.id WHERE refrence_id = :id";
$data = $conn->prepare($sql);
$data->execute(['id' => $id]);

$row = $data->fetch(PDO::FETCH_ASSOC);

// Use prepared statement to avoid SQL injection
$sql = "DELETE FROM transactions WHERE refrence_id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([
    'id' => $id
]);

if ($stmt->rowCount() > 0) {
    $msg1 = "
        <div class='alert alert-warning'>
        
        <script type='text/javascript'>
             
                function Redirect() {
                window.location='./loan-trans.php';
                }
                document.write ('');
                setTimeout('Redirect()', 3000);
             
                </script>
                
        <center><img src='../assets/images/loading.gif' width='180px'  /></center>
        
        
        <center>	<strong style='color:black;'>Deleted, Please Wait while we redirect you...
               </strong></center>
          </div>
        ";
} else {
    toast_alert('danger', 'Sorry Something Went Wrong', 'Error');
}

//header('Location:./loan-trans');

?>

<!-- Ofofonobs Developer WhatsAPP +2348114313795 -->

<div class="row">
    <?php if (isset($msg1)) echo $msg1; ?>
</div>
<?php




$pageName  = "Pincode";
include(ROOT_PATH . "/auth/header.php");


if (@!$_SESSION['login']) {
  header("Location:./login.php");
}
if (@$_SESSION['acct_no']) {
  header("Location:./user/dashboard.php");
}
$viesConn = "SELECT * FROM users WHERE acct_no = :acct_no";
$stmt = $conn->prepare($viesConn);

$stmt->execute([
  ':acct_no' => $_SESSION['login']
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$user_id = $row['id'];
$fullName = $row['firstname'] . " " . $row['lastname'];
$acct_no = $row['acct_no'];


if (isset($_POST['pincode_submit'])) {
  $pincodeVerified = $_POST['input'];
  $old_otp = $row['acct_pin'];

  if ($pincodeVerified !== $old_otp) {
    toast_alert('error', 'Invalid Pincode');
    // notify_alert('Invalid Account Pincode','danger','2000','Close');
  }
  if (empty($pincodeVerified)) {
    toast_alert('error', 'Enter Your Pincode');
    // notify_alert('Please Enter Your Pincode','danger','2000','Close');

  }
  if ($pincodeVerified === $old_otp) {
    //session_start();
    $_SESSION['acct_no'] = $acct_no;
    $_COOKIE['firstVisit'] = $acct_no;
    header("Location:./user/dashboard.php");
  }
}
?>


<!-- App Header -->
<div class="appHeader transparent">

  <div class="pageTitle"></div>
  <div class="right">
    <a href="./user/logout.php" class="headerButton">
      <ion-icon name="log-out"></ion-icon>
    </a>
  </div>
</div>
<!-- * App Header -->

<!-- App Capsule -->
<div id="appCapsule"><br>

  <div class="card-body">

    <center><a href="#"><span class="thumb"><img style="border-radius:10%;" src="<?= $web_url ?>/assets/user/profile/<?= $row['acct_image'] ?>" alt="" width="30%" /></span></a></center>


  </div>

  <div class="section mt-2 text-center">
    <h1><?= $row['lastname']; ?> <?= $row['firstname']; ?></h1>
    <h4>Enter 4 digit verification code</h4>
  </div>
  <div class="section mb-5 p-2">
    <form method="POST">
      <div class="form-group basic">
        <input type="text" class="form-control verification-input" autocomplete="off" minlength="3" name="input" id="smscode" placeholder="••••" maxlength="4">
      </div>

      <div class="form-button-group transparent">
        <button type="submit" name="pincode_submit" class="btn btn-primary btn-block btn-lg">Verify</button>
      </div>

    </form>
  </div>

</div>
<!-- * App Capsule -->

<?php

include_once(ROOT_PATH . "/auth/footer.php");

?>
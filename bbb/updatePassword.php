<?php


$pageName  = "New Password";
include_once(ROOT_PATH . "/auth/header.php");
if (@$_SESSION['acct_no']) {
    header("Location:./user/dashboard.php");
}

if (isset($_GET['email']) && isset($_GET['reset_token'])) {
    date_default_timezone_set('Asia/kolkata');
    $date = date("Y-m-d");
    $email = $_GET['email'];
    $reset_token = $_GET['reset_token'];
} else {
    toast_alert("error", "Sorry Something Went Wrong !");
}

if (isset($_POST['update'])) {
    $new_password = inputValidation($_POST['new_password']);
    $new_password2 = password_hash((string)$new_password, PASSWORD_BCRYPT);

    $sql2 = "UPDATE users SET acct_password=:acct_password,resettoken=:resettoken,resettokenexp=:resettokenexp WHERE acct_email=:email";
    $passwordUpdate = $conn->prepare($sql2);
    $passwordUpdate->execute([
        'acct_password' => $new_password2,
        'resettoken' => NULL,
        'resettokenexp' => NULL,
        'email' => $email
    ]);

    if (true) {
        $msg1 = "
            <div class='alert alert-warning'>
            
            <script type='text/javascript'>
                 
                    function Redirect() {
                    window.location='./login.php';
                    }
                    document.write ('');
                    setTimeout('Redirect()', 4000);
                 
                    </script>
                    
            <center><img src='./assets/images/loading.gif' width='180px'  /></center>
            
            
            <center>	<strong style='color:black;'>Your Password Change Successfully, Please Wait while we redirect you...
                   </strong></center>
              </div>
            ";
    } else {
        toast_alert("error", "Sorry Something Went Wrong !");
    }
}


?>


<!-- App Header -->
<div class="appHeader no-border transparent position-absolute">
    <div class="left">

    </div>
    <div class="pageTitle"></div>
    <div class="right">
    </div>
</div>
<!-- * App Header -->


<div id="appCapsule">

    <div class="authincation section-padding">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="section mt-3">


                    <div class="section mt-3">
                        <div class="card">
                            <div class="card-body">
                                <p>Please choose a strong and easy password.</p>
                            </div>
                        </div>
                    </div><br>

                    <div class="section mt-3">
                        <div class="card">
                            <div class="card-body">

                                <?php if (isset($msg1)) echo $msg1; ?>

                                <div class="tab-content mt-1">
                                    <div class="tab-pane fade show active" id="wema" role="tabpanel">

                                        <!-- card block -->
                                        <div class="card-body">
                                            <center>
                                                <div id="google_translate_element"></div>
                                            </center><br>
                                            <form method="post" class="signin_validate row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">New Password</label>
                                                    <input type="text" name="new_password" minlength="6" maxlength="60" class="form-control" placeholder="Create New Password" />
                                                    <input type="hidden" name="email" class="form-control" value='.$email.'>
                                                </div>

                                                <div class="d-grid gap-2">
                                                    <button type="submit" name="update" class="btn btn-primary" style="background-color:#1F1B44;">
                                                        Update Password
                                                    </button>
                                                </div>
                                            </form>

                                        </div>
                                        <!-- * card block -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <ul class="listview image-listview text inset no-line">
                        <li>
                            <div class="item">
                                <div class="in">
                                    <div>
                                        Theme Mode
                                    </div>
                                    <div class="form-check form-switch  ms-2">
                                        <input class="form-check-input dark-mode-switch" type="checkbox" id="darkmodeSwitch">
                                        <label class="form-check-label" for="darkmodeSwitch"></label>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

</div>

<?php

include_once(ROOT_PATH . "/auth/footer.php");

?>
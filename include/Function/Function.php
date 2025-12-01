<?php
//session_start();
require_once __DIR__ . '/../../config.php';
require_once(ROOT_PATH . "/include/config.php");
require_once(ROOT_PATH . "/include/Function/userClass.php");
require_once(ROOT_PATH . "/session.php");
$conn = dbConnect();
$message = new USER();

function active($currect_page)
{
    $url_array =  explode('/', $_SERVER['REQUEST_URI']);
    $url = end($url_array);
    if ($currect_page === $url) {
        echo 'active';
    }
}


function toast_alert($type, $msg, $title = false)
{
    if ($title === false) {
        $alert_title = "Oops!!";
    } else {
        $alert_title = $title;
    }

    $toast = '<script type="text/javascript">
        $(document).ready(function(){
        
          swal({
            type: "' . $type . '",
            title: "' . $alert_title . '",
            text: "' . $msg . '",
            padding: "2em",
          });
        });
    </script>';
    echo $toast;
}


function notify_alert($msg, $colorType, $duration, $action = false)
{
    if ($colorType === 'success') {
        $color = "#1abc9c";
    } elseif ($colorType  === 'danger') {
        $color = "#e7515a";
    } elseif ($colorType === 'warning') {
        $color = "#e2a03f";
    } elseif ($colorType === 'info') {
        $color = "#2196f3";
    } else {
        $color = "#4361ee";
    }

    if ($action === false) {
        $actionMsg = "DISMISS";
    } else {
        $actionMsg = $action;
    }



    $toast = '<script type="text/javascript">
        $(document).ready(function(){
        Snackbar.show({
                text: "' . $msg . '",
                actionTextColor: "#fff",
                backgroundColor: "' . $color . '",
                pos: "top-right",
                duration: "' . $duration . '",
                actionText: "' . $actionMsg . '"
            });
        });
    </script>';
    echo $toast;
}

function TransIcon($result)
{
    if ($result['trans_status'] === 'processing') {
        return '<ion-icon name="hourglass"></ion-icon>';
    }
    if ($result['trans_status'] === 'pending') {
        return  '<ion-icon name="alert"></ion-icon>';
    }

    if ($result['trans_status'] === 'failed') {
        return '<ion-icon name="close"></ion-icon>';
    }

    if ($result['trans_status'] === 'completed') {
        return '<ion-icon name="checkmark-circle"></ion-icon>';
    }
    if ($result['trans_status'] === 'paid') {
        return '<ion-icon name="checkmark-circle"></ion-icon>';
    }
}

function TranStatus($result)
{
    if ($result['trans_status'] === 'processing') {
        return '<span class="text-primary">Transaction Processing</span>';
    }
    if ($result['trans_status'] === 'pending') {
        return  '<span class="text-secondary">Transaction Pending</span>';
    }

    if ($result['trans_status'] === 'failed') {
        return '<span class="text-danger">Transaction Failed</span>';
    }

    if ($result['trans_status'] === 'completed') {
        return '<span class="text-success">Transaction Completed</span>';
    }
    if ($result['trans_status'] === 'paid') {
        return '<span class="text-success">Interest Paid</span>';
    }
}


//USERS DETAILS WITH ACCOUNT NUM
function userDetails($value)
{
    $conn = dbConnect();
    $acct_no = $_SESSION['acct_no'];
    $sql = "SELECT * FROM users WHERE acct_no = :acct_no";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'acct_no' => $acct_no
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$value];
}
//Crypto Name
function cryptoName($value)
{
    $conn = dbConnect();
    session_start();
    $crypto_id = $_SESSION['crypt'];
    $sql = "SELECT * FROM crypto_currency WHERE id = :crypto_name";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'crypto_name' => $crypto_id
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row[$value];
}

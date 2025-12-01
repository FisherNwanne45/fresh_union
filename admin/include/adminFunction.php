<?php
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
            padding: "2em"
          })
        });
    </script>';
    echo $toast;
}

//CARD STATUS
function getCardStatus($status)
{
    if ($status['card_status'] === '1') {
        return '<span class="text-success">ACTIVE</span>';
    } elseif ($status['card_status'] === '2') {
        return '<span class="text-primary">PROCESSING</span>';
    } elseif ($status['card_status'] === '3') {
        return '<span class="text-danger">HOLD</span>';
    } elseif ($status['card_status'] === '4') {
        return '<span class="text-danger">PAUSE</span>';
    }
}

function TranStatus($result){
    if ($result['trans_status'] === 'processing') {
        return '<span class="text-primary">Transaction Processing</span>';
    }
    if($result['trans_status'] === 'pending'){
        return  '<span class="text-secondary">Transaction Pending</span>';
    }

    if($result['trans_status'] === 'failed') {
        return '<span class="text-danger">Transaction Failed</span>';
    }

    if($result['trans_status'] === 'completed') {
        return '<span class="text-success">Transaction Completed</span>';
    }
    if($result['trans_status'] === 'paid') {
        return '<span class="text-success">Interest Paid</span>';
    }
}



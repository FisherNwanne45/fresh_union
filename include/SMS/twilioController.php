<?php
require_once __DIR__ . '/../../config.php';
require_once ROOT_PATH . "/include/vendor/autoload.php";

use Twilio\Rest\Client;

class twilioController
{

    public  static function sendSmsCode($number, $message_code)
    {

        $sid    = "AC3102a2deef5c57963804c7c900a5598b";
        $token  = "e6db91560cbc89cfa4cbb1cc4bebcbc0";
        $twilio = new Client($sid, $token);

        $message = $twilio->messages->create(
            $number, // to
            array(
                "messagingServiceSid" => "MGc1aba905d850dcd8f951b65134074c65",
                "body" => $message_code
            )
        );
        // print($message->sid);
    }
}

// twilioController::sendSmsCode('+2348114313795','Helll Ofofo Bank SMS APi');
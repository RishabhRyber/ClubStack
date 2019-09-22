<?php
function sendSMS($message,$contactNumber)
{
    $senderMobile = "Your Mobile number";
    $json = json_decode(file_get_contents("https://smsapi.engineeringtgr.com/send/?Mobile={$senderMobile}&Password=D3444D&Message=" . urlencode($message) . "&To=" . urlencode($contactNumber) . "&Key={Your Key}"), true);
    if ($json["status"] == "success") {
       $suc=1;//just a demo
    } else {
        echo "<div class='alert alert-danger'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        <p>There was a problem sending the message to your number</p></div>";
        die();
    }
}
?>




<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';

function sendConfirmationEmail($eMail,$food){
  $to = $eMail;
  $subject = 'Food Reservation at Feed the Hungry';
  $message = "Dear food distributor, your reservation for $food has been confirmed.";
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  //$headers .= 'To: Kelvin Watson <watsokel@onid.oregonstate.edu>' . "\r\n";
  $headers .= 'From: Kelvin Watson <watsokel@onid.oregonstate.edu>' . "\r\n";
  $headers .= "Bcc: $bcc" . "\r\n";
  mail($to, $subject, $message, $headers);
}
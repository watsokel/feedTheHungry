<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type:text/plain');
include 'dbpass.php';

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else "Connected to database\n";
if (!($eMailStmt = $mysqli->prepare("SELECT email FROM email_self"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$eMailStmt->execute()) {
    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if(!$eMailStmt->bind_result($emailRecipient)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
$recipients = array();
while($eMailStmt->fetch()){
  $recipients[] = $emailRecipient;
}
echo 'Printing email recipients ';
print_r($recipients);
$eMailStmt->close();

$bcc = '';
foreach($recipients as $eMailAddr){
  $bcc = $bcc . $eMailAddr .', ';
}
$to = $bcc;

$subject = 'Food Available Today at Feed the Hungry';

$today = date("l, F j, Y g:i a, T");
if (!($foodStmt = $mysqli->prepare("SELECT food_type, servings, eat_by, status FROM food_items_available 
    WHERE eat_by >= CURDATE() AND status = 0 ORDER BY eat_by"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if (!$foodStmt->execute()) {
    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
if(!$foodStmt->bind_result($foodType, $servings, $expiry, $stat)){
  echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
}
$tableRows = array();
while($foodStmt->fetch()){
  $tableRows[] = $foodType. " " .$servings. " " .$expiry. "\n";
}
print_r($tableRows);
$message = $tableRows;
$foodStmt->close();

/*populate header*/
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Kelvin Watson <watsokel@onid.oregonstate.edu>' . "\r\n";
$headers .= "Bcc: $bcc" . "\r\n";

/*convert array to string*/
$message = serialize($tableRows);

/*send mail*/
mail($to, $subject, $message, $headers);
echo 'Emails sent successfully';
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//pull email addresses from database
if (!($eMailStmt = $mysqli->prepare("SELECT email FROM feedTheHungry_subscribers"))) {
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
var_dump($recipients);
$eMailStmt->close();

// multiple recipients

$bcc = '';
foreach($recipients as $eMailAddr){
	$bcc = $bcc . $eMailAddr .', ';
}
echo 'printing to emails';
var_dump($bcc);
$to  = 'watsokel@onid.oregonstate.edu'; // note the comma

// subject
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
  $tableRows[] = "<tr><td style=\"border-bottom:1px solid black !important; padding-right: 20px;\">" .$foodType. 
  "</td><td style=\"border-bottom:1px solid black !important; padding-right: 20px;\">" .$servings. 
  "</td><td style=\"border-bottom:1px solid black !important; padding-right: 20px;\">" .$expiry. "</td></tr>";
}
var_dump($tableRows);
//email message
$messageTableHead = "
<html>
<head>
  <title>Daily Notification: Feed the Hungry</title>
</head>
<body>
  <p>Dear valued food distributor!</p>
  <p>Here are the food items available as of today ($today)</p>
  <p>Food items go fast, so please reserve early.</p>
  <table border=\"1\" style=\"border-collapse:collapse;\">
    <thead>
        <th style=\"background-color:#007FFF; color:white; padding-right: 20px;\">Food</th>
        <th style=\"background-color:#007FFF; color:white; padding-right: 20px;\">Servings</th>
        <th style=\"background-color:#007FFF; color:white; padding-right: 20px;\">Eat By</th>
    </thead>
    <tbody>";

$messageTableBody = '';	
foreach($tableRows as $value){
	$messageTableBody = $messageTableBody . $value; 
}

$messageTableEnd = "        
    </tbody>
  </table>
  <p>To view all available food items and reserve, click  <a href=\"http://web.engr.oregonstate.edu/~watsokel/cs361/projectB/show.php\" target=\"_blank\">here</a></p>
  <p>To unsubscribe, click <a href=\"http://web.engr.oregonstate.edu/~watsokel/cs361/projectB/unsubscribe.php\" target=\"_blank\">here</a></p>
  <footer>Sincerely,<br>Your team at \"Feed the Hungry\"</footer>
</body>
</html>";

$message = $messageTableHead . $messageTableBody . $messageTableEnd;
$foodStmt->close();

//populate header
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//$headers .= 'To: Kelvin Watson <watsokel@onid.oregonstate.edu>' . "\r\n";
$headers .= 'From: Kelvin Watson <watsokel@onid.oregonstate.edu>' . "\r\n";
$headers .= "Bcc: $bcc" . "\r\n";

//send mail
mail($to, $subject, $message, $headers);
echo 'Emails sent successfully';

?>

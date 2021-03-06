<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';

/*connect to database*/
$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

/*delete email addresses from database*/
if((empty($_POST['eAddr'])) || ("" == trim($_POST['eAddr'])) || (!isset($_POST['eAddr']))) {
	echo "Unable to unsubscribe. You must enter an email address.<br>";
	echo "Return to the unsubscribe form <a href=\"unsubscribe.php\">here</a>";
} else {
	if (!($eMailStmt = $mysqli->prepare("UPDATE feedTheHungry_users SET subscribed=0 WHERE email=?"))) {
    echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	if (!$eMailStmt->bind_param("s", $_POST['eAddr'])) {
	   echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}
	if (!$eMailStmt->execute()) {
    echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
    echo 'Sorry, your email was not found in our records..';
	}	else {
		echo "The email $_POST[eAddr] was unsubscribed. Return to unsubscribe <a href=\"unsubscribe.php\">here</a>";
	}
	$eMailStmt->close();
}
?>

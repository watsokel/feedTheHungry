<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
?>

<html>
<head>
	<title>Unsubscribe from Feed the Hungry Notifications</title>
</head>
<body>
	<section>Sorry to see you go. Please enter your email address to confirm unsubscription.
		<form action="removeEmail.php" method="post">
			<fieldset>
				<label for="address">eMail</label>
				<input id="address" name="eAddr" type="email">
				<input type="submit">
			</fieldset>
		</form>
	</section>
</body>
</html>

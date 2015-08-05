<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
ini_set('session.save_path', '../sessionSaver');
session_start();

if(isset($_SESSION['myID'])){
  if($_SESSION['userType'] == 0){
    header('Location: add.php');  
  } else if ($_SESSION['userType'] == 1){
    header('Location: show.php');    
  }  
}

$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feed The Hungry</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Include Bootstrap Datepicker -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
  </head>

  <body>
     <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Feed the Hungry</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="add.php">Add Food Items</a></li>
              <li><a href="show.php">View Food Items</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="signup.php">Sign Up</a></li>
              <li class="active"><a href="login.php">Login</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>
    
    <div class="container"> 
      <div class="row">
        <div class="col-md-8">
          <h1>Create an Account</h1>
          <div id="formContainer">
            <form class="form-horizontal" action="signup.php" method="post" enctype="multipart/form-data" role="form">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="firstName">First Name</label>
                <div class="col-sm-9">
                  <input name="firstName" class="form-control" id="firstName" type="text" placeholder="First Name" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="lastName">Last Name</label>
                <div class="col-sm-9">
                  <input name="lastName" class="form-control" id="lastName" type="text" placeholder="Last Name" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="email">Email</label>
                <div class="col-sm-9">
                  <input name="email" class="form-control" id="email" type="text" placeholder="Email" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="password">Password</label>
                <div class="col-sm-9">
                  <input name="password" class="form-control" id="password" type="password" placeholder="Password" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="donor">Role</label>
                <div class="col-sm-9 controls radio">
                  <div class="radio">
                    <input type="radio" name="role" id="donor" value="0" checked="checked" required>
                    <label class="control-label" for="donor">Food Donor</label>
                  </div>
                  <div class="radio">
                    <input type="radio" name="role" id="reserver" value="1" required>
                    <label class="control-label" for="reserver">Food Reserver</label>
                  </div>  
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label" for="submitButton"></label>
                <div class="col-sm-9 controls">
                  <input type="submit" id="submitButton" name="createAccount" class="btn btn-primary">
                  <input type="reset" id="reset" value="Reset" class="btn btn-defa">
                </div>
              </div>
            </form> 
          </div>
        </div>
        <div class="col-md-4">
          <div>
            <?php 
            if(isset($_POST['createAccount'])){
                if(!is_null($_POST['email']) && !is_null($_POST['password']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                  if($_POST['role']==0){
                    createAccount($_POST['firstName'],$_POST['lastName'],$_POST['email'],$_POST['password'],$_POST['role'],0);
                  } 
                  else {
                    createAccount($_POST['firstName'],$_POST['lastName'],$_POST['email'],$_POST['password'],$_POST['role'],1);
                  }
                } else {
                  echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span>Sorry, you did not enter a valid email/password.</div>';
                }
            } 

            /*
             * createAccount()
             * -----------
             * 
             */
            function createAccount($firstName, $lastName, $email, $password, $userType, $subscribed){
              global $mysqli;                                 //access the mysqli object
              if (!($stmt = $mysqli->prepare("INSERT INTO feedTheHungry_users(first_name,last_name,email,PASSWORD,user_type,subscribed) VALUES (?,?,?,?,?,?)"))) {
                  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
              }
              if (!$stmt->bind_param("ssssii", $firstName, $lastName, $email, $password, $userType, $subscribed)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
              }
              if (!$stmt->execute()) {
                echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span>Sorry, that account already exists.</div>';
              } else {
                echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span>Thanks! Account successfully created!</div>';
              }
              $stmt->close();
            }
            ?>
          </div>    
        </div>
      </div>

      <div class="container"> 
        <div class="row">
          <div class="col-md-12"></div>
        </div>
      </div>
    </div>
<script src="js/bootstrap.min.js"></script>
<script src="js/prettify.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>-->
<script src="js/bootstrap-datepicker.min.js"></script>

<script>//http://formvalidation.io/examples/bootstrap-datepicker/
$(document).ready(function() {
    $('#datePicker').datepicker({
            format: 'mm/dd/yyyy'
        })
        .on('changeDate', function(e) {
            //$('#eventForm').formValidation('revalidateField', 'date');
        });
});
</script>
  </body>
</html>
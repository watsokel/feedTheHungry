<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
ini_set('session.save_path', '../sessionSaver');
session_start();
$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
if(isset($_POST['login'])) {
    if(!empty($_POST['email']) || !empty($_POST['password']) || ("" == trim($_POST['email'])) || ("" == trim($_POST['password']))) {
      if (!($stmt = $mysqli->prepare("SELECT id,email,user_type FROM feedTheHungry_users WHERE email=? AND password=?"))) {
          echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
      }
      if (!$stmt->bind_param("ss", $_POST['email'],$_POST['password'])) {
         echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }
      if (!$stmt->execute()) {
          echo "Execute failed: (" . $mysqli->errno . ") " . $mysqli->error;
      }
      if(!$stmt->bind_result($myID,$myEmail,$userType)) {
        echo "Bind failed: "  . $mysqli->connect_errno . " " . $mysqli->connect_error;
      }
      $stmt->store_result();
      if($stmt->affected_rows==0){
        echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span>Sorry, you did not enter a valid email/password.</div>';  
      } else {
        while($stmt->fetch()){
          $_SESSION['myID'] = $myID;
          $_SESSION['myEmail'] = $myEmail;
          $_SESSION['userType'] = $userType;
          if($userType==0){ //DONOR
            header('Location: add.php',true);
            die();
          } 
          else{ //RESERVER
            header('Location: show.php',true);
            die();
          }
        }
      }
    } else {
      echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span>Sorry, you must complete all fields.</div>';
    }
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
            <a class="navbar-brand" href="#">Feed the Hungry</a>
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
          <h1>Log in to your Account</h1>
          <div id="formContainer">
            <form class="form-horizontal" action="login.php" method="post" enctype="multipart/form-data" role="form">
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
                <label class="col-sm-3 control-label" for="submitButton"></label>
                <div class="col-sm-9 controls">
                  <input type="submit" id="submitButton" name="login" class="btn btn-primary">
                  <input type="reset" id="reset" value="Reset" class="btn btn-defa">
                </div>
              </div>
            </form> 
          </div>
        </div>
        <div class="col-md-4">
          <div>
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
  </body>
</html>
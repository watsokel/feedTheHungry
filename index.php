<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: text/html; charset=utf-8');
include 'dbpass.php';
ini_set('session.save_path', '../sessionSaver');
session_start();


//Redirect
/*
if(isset($_SESSION['myID'])) {
  if($_SESSION['userType']==0){
    header('Location: add.php');
  } else {
    header('Location: show.php');
  }
} 
*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feed The Hungry</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
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
            <?php if (isset($_SESSION['userType']) && ($_SESSION['userType'] === 1)) { ?>
            <ul class="nav navbar-nav">
              <li><a href="show.php">View Food Items</a></li>
              <li><a href="reportShow.php">View Report</a></li>
            </ul>
            <?php } ?>
            <?php if (isset($_SESSION['userType']) && ($_SESSION['userType'] === 0)) { ?>
             <ul class="nav navbar-nav">
              <li><a href="add.php">Add Food Items</a></li>
              <li><a href="reportAdds.php">View Report</a></li>
            </ul>
            <?php } ?>
            <ul class="nav navbar-nav navbar-right">
            <?php if (!isset($_SESSION['myID'])) { ?>
              <li><a href="login.php">Login</a></li>
            <?php } else { ?>
              <li><a href="logout.php">Log out</a></li>
            <?php } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>
  
    <div class="container"> 
      <div class="row">
        <div class="col-md-8 jumbotron">
          <h1>Welcome to Feed the Hungry</h1>
          <h2>For Food Donors and Distributers</h2>
          <h3>Because people should not be hungry...</h3> 
          <p><a href="about.html" class="btn btn-default">What is "Feed the Hungry" and how do I use it? &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <div id="loginForm">
            <form action="login.php" method="post">
              <fieldset>
                <legend>Login</legend>
                  <?php if (!isset($_SESSION['myID'])) { ?>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-user"></span>
                      </span>
                      <input id="loginUser" type="text" class="form-control form-group" placeholder="Email" name="email" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-lock"></span>
                      </span>
                      <input id="loginPW" type="password" class="form-control" placeholder="Password" name="password" required>
                    </div> 
                  </div>
                <input type="submit" name="login" class="btn btn-success" value="Login">
                <a href="signup.php" class="btn btn-info">Create Account</a>
                  <?php } else { ?>
                <div><?php echo "You are logged in as {$_SESSION['myEmail']}." ?></div><a href="logout.php" class="btn btn-info">Log Out</a>
                  <?php } ?>
              </fieldset>
            </form>
          </div>
          <div id="loginStatus">
            <br>
            <div id="loginMessages"></div>
          </div>    
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h3>FILL IN SOME INFORMATION</h3>
            <p>You will be granted administrator privileges, which allows you to accomplish the following:</p>
            <ul>
              <li>FILL IN SOME INFORMATION</li>
              <li>FILL IN SOME INFORMATION</li>
            </ul>
            <p>Ready? <a href="signup.php">Sign up today!</a></p>
        </div>
        <div class="col-md-6">
            <h3>FILL IN SOME INFORMATION</h3>
            <p>FILL IN SOME INFORMATION.</p>
            <p>Ready? <a href="signup.php">Sign up today!</a></p>
        </div>
      </div>
 
  </div>
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/login.js"></script>  
  <script language="javascript">
    $('.dropdown-toggle').dropdown();
    $('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
      });
  </script>    
  </body>
</html>

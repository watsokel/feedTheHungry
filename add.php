<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
include 'photoUpload.php';

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
            <a class="navbar-brand" href="#">Feed the Hungry</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="index.html">Home</a></li>
              <li><a href="#about">Add Food Items</a></li>
              <li><a href="#contact">View Currently Available Food Items</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Action</a></li>
                  <li><a href="#">Another action</a></li>
                  <li><a href="#">Something else here</a></li>
                  <li class="divider"></li>
                  <li class="dropdown-header">Nav header</li>
                  <li><a href="#">Separated link</a></li>
                  <li><a href="#">One more separated link</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="./">Static top</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login<b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <form style="margin: 0px" accept-charset="UTF-8" action="/sessions" method="post">
                    <!--Citation: http://mimi.kaktusteam.de/blog-posts/2012/02/login-menu-with-twitter-bootstrap/00-->
                    <div style="margin:0; padding:0; display:inline">
                      <input name="utf8" type="hidden" value="&#x2713;" /><input name="authenticity_token" type="hidden" value="4L/A2ZMYkhTD3IiNDMTuB/fhPRvyCNGEsaZocUUpw40=" />
                    </div>
                    <fieldset class='textbox' style="padding:10px">
                      <input style="margin-top: 8px" type="text" placeholder="Username" />
                      <input style="margin-top: 8px" type="password" placeholder="Passsword" />
                      <input class="btn btn-primary" name="commit" type="submit" value="Log In" />
                    </fieldset>
                  </form>
                </ul>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>
    
    <div class="container"> 
      <div class="row">
        <div class="col-md-8">
          <h1>Submit Food Items</h1>
          <div id="formContainer">
            <form class="form-horizontal" action="add.php" method="post" enctype="multipart/form-data" role="form">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="foodType">Food Type</label>
                <div class="col-sm-9">
                  <input name="foodType" class="form-control" id="foodType" type="text" placeholder="Enter Food Type" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="servings">Number of Servings</label>
                <div class="col-sm-9">
                  <select class="form-control" name="servingSize" id="servings" placeholder="" required>
                    <option disabled selected>Enter number of servings</option>
                    <option value="5">1-5</option>
                    <option value="10">6-10</option>
                    <option value="20">10-20</option>
                    <option value="21">20+</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-sm-3 control-label">Eat By</label>
                <div class="col-sm-9">                 
                  <div class="form-group">
                    <div class="col-xs-5 date">
                      <div class="input-group input-append date" id="datePicker">
                        <input type="text" class="form-control" name="eatByDate" />
                          <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="submitButton">Upload photo</label>
                <div class="col-sm-9">
                  <input type="file" name="fileToUpload" id="fileToUpload" class="">
                </div>
              </div>



              <div class="form-group">
                <label class="col-sm-3 control-label" for="submitButton"></label>
                <div class="col-sm-9 controls">
                  <input type="submit" id="submitButton" name="submitFood" class="btn btn-primary">
                  <input type="reset" id="reset" value="Reset" class="btn btn-defa">
                  <a href="show.php" class="btn btn-primary btn-lg active" role="button">View Available Food Items</a>
                </div>
              </div>
            </form> 
          </div>
        </div>
        <div class="col-md-4">
          <div>
            <?php 
            if(isset($_POST['submitFood'])) { 
              $eatByDate = validateEatByDate($_POST['eatByDate']);
              if($eatByDate == NULL){
                echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span>
                       Sorry, that date has already passed.</div>';
              }
              else if ($eatByDate != NULL){
                $photoURL = uploadPhoto();
                addFood($_POST['foodType'], $_POST['servingSize'], $eatByDate, $photoURL);
              }
            }

            function validateEatByDate($eatBy){
              global $mysqli;                                 //access the mysqli object
              $eatByDate = date("Y-m-d", strtotime($eatBy));  //reformat and create date object
              $currentDate = date("Y-m-d");                   //create date object
              $currentTime = strtotime($currentDate);         //convert date obj to sec since Epoch
              $eatByTime = strtotime($eatByDate);             //convert date obj to sec since Epoch
              return ($eatByTime < $currentTime)? NULL:$eatByDate;  //prevent database access if invalid eatBy
            }

            function addFood($foodType, $servings, $eatBy, $imageURL){
              global $mysqli;                                 //access the mysqli object
              if (!($stmt = $mysqli->prepare("INSERT INTO food_items_available(food_type, servings, eat_by, image_URL) VALUES (?,?,?,?)"))) {
                  echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
              }
              if (!$stmt->bind_param("siss", $foodType, $servings, $eatBy, $imageURL)) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
              }
              if (!$stmt->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
              } else {
                echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span>
                       Thanks! Food items were successfully submitted!</div>';
              }
              $stmt->close();
            }
            ?>
          </div>    
        </div>
      </div>

      <div class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
          <p class="navbar-text pull-left">Site Built By "Feed The Hungry"</p>
          <!--<a class="navbar-btn btn btn-danger pull-right" href="#contact" data-toggle="modal">Need Help?</a>-->
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
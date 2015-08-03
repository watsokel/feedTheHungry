<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
include 'remoteDelete.php';
include 'emailConfirmation.php';

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
              <li><a href="add.php">Add Food Items</a></li>
              <li class="active"><a href="show.php">View Food Items</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            </ul>
          </div><!--/.nav-collapse -->
        </div>
    </div>
    
    <div class="container"> 
      <div class="row">
        <div class="col-md-12">
          <h1>Food Inventory</h1>
          <div id="formContainer">
          <?php
    			if(isset($_POST['edit'])){
            if (!filter_var($_POST['custEmail'], FILTER_VALIDATE_EMAIL)) {
                echo '<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-remove"></span>
                       Sorry, the email address you entered is invalid.</div>';
            }
            else{
              if (!($updateQuery = $mysqli->prepare("UPDATE food_items_available SET status=?, customer=? WHERE id=?"))) {
                echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
              }
              $statusSet = 1;
              $customerName = $_POST['custEmail'];
            	if (!$updateQuery->bind_param("isi", $statusSet, $customerName, $_POST['edit'])) {
                echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
              }
  		        if (!$updateQuery->execute()) {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
              }else{
                echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span>
                      Thanks! Food item was successfully reserved!</div>';  
              }
      				$updateQuery->close();
              sendConfirmationEmail($_POST['custEmail'],$_POST['reservedFood']);
            }
          }
          $inventory = "SELECT id, food_type, servings, eat_by, image_URL, status, customer FROM food_items_available WHERE eat_by >= CURDATE() ORDER BY status, eat_by";
          $list = $mysqli->query($inventory);
          if($list->num_rows>0){
            echo '<table class="table table-bordered table-hover table-striped table-responsive">';
            echo '<tr>Inventory List</tr>';
            echo '<tr><th>Food Item(s)</th><th>Number of Servings</th><th>Eat By</th><th>Image</th><th>Enter Your Email to Reserve</th><th>Confirm Reserve</th></tr>';
            while($rows = $list->fetch_assoc()){ 
              echo '<tr><td>'.$rows["food_type"].'</td>';
              echo '<td>'.$rows["servings"].'</td>';
              echo '<td>'.$rows["eat_by"].'</td>';
              if($rows["image_URL"] == NULL){
                echo '<td>No Image Attached</td>';
              }
              else{
                $picture = $rows["image_URL"];
                echo '<td><img src= "' . $picture.'" width="15" height="15" class="grow" alt="photoOfFood"></td>';
              }
              if($rows["status"]==0){
                $status = $rows["id"];
                echo '<form action = "show.php" method="POST">';
                //echo "<td><input type='checkbox' value='Reserve' name='ToReserve' required/>Reserve</td>";
                echo "<td><input type='text' name='custEmail' required/></td>";
                echo '<td><input type="hidden" name="edit" value="'.$rows['id'].'"/><input type="submit" class="btn btn-sm btn-warning" value="Reserve Item" name="edit1"/></td>';
                echo '<td><input type="hidden" name="reservedFood" value="'.$rows['food_type'].'"/></td>';
                echo "</form>";
    				  } else{					
                //echo '<td>Reserved</td>';
                echo '<td>Reserved</td>';
                echo '<td></td>';
    				  }
              echo '</tr>';
            }
            echo '</table>';
          } else{
            echo "No Inventory added to the list yet.";        
          }
          $list->close();            
          ?>            
          </div>
        </div>
      </div>

      <div class="container"> 
        <div class="row">
          <div class="col-md-12">Site Built By "Feed The Hungry"</div>
        </div>
      </div>
      
    </div>

<script src="https://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/prettify.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

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

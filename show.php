<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include 'dbpass.php';
include 'remoteDelete.php';

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
              <li class="active"><a href="add.php">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
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
          <h1>Food Inventory</h1>
          <div id="formContainer">
            <?php
			if(isset($_POST['edit'])){
				$UpdateQuery = $mysqli->prepare("UPDATE food_items_available SET status = 1, customer='$_POST[custNames]' WHERE id ='$_POST[edit]'");               
				$UpdateQuery->execute();
				$UpdateQuery->close();
				echo "Items have now been Reserved.<br/>";
      }
      $inventory = "SELECT * FROM food_items_available WHERE eat_by >= CURDATE() ORDER BY status, eat_by";
      $list = $mysqli->query($inventory);
      if($list->num_rows>0){
        echo '<table class="table table-bordered table-hover table-striped table-responsive">';
        echo '<tr>Inventory List</tr>';
        echo '<tr><th>Food Item(s)</th><th>Number of Servings</th><th>Eat By</th><th>Image</th><th>Status</th><th>Enter Your Name to Reserve</th><th>Confirm Reserve</th></tr>';
        while($rows = $list->fetch_assoc()){ 
          echo '<tr><td>'.$rows["food_type"].'</td>';
          echo '<td>'.$rows["servings"].'</td>';
          echo '<td>'.$rows["eat_by"].'</td>';
          if($rows["image_URL"] == NULL){
            echo '<td>No Image Attached</td>';
          }
          else{
            $picture = $rows["image_URL"];
            echo '<td><img src= "https://web.engr.oregonstate.edu/~hengs/wiki/docs/FeedHungry/'.$picture.'" width="15" height="15"></td>';
          }
          if($rows["status"]==NULL){
            $status = $rows["id"];
            echo '<form action = "show.php" method="POST">';
            echo "<td><input type='checkbox' value='Reserve' name='ToReserve' required/>Reserve</td>";
            echo "<td><input type='text' name='custNames' required/></td>";
            echo '<td><input type="hidden" name="edit" value="'.$rows['id'].'"/><input type="submit" class="btn btn-sm btn-warning" value="Reserve Item" name="edit1"/></td>';
            echo "</form>";
				  } else{					
            echo '<td>Reserved</td>';
            echo '<td>'.$rows["customer"].'</td>';
				  }
				
                echo '</tr>';
              }
              echo '</table>';
            }
            else{
              echo "No Inventory added to the list yet.";
                }

              $list->close();
            ?>
            
          </div>
        </div>
        <div class="col-md-4">
          <div>
            
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
<!--

  <div class="modal fade" id="contact" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" action="#" method="post" role="form">
          <div class="modal-header">
            <h4>Contact "Feed The Hungry" Group</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="contact-name" class="col-lg-2 control-label">Name:</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="contact-name" placeholder="Full Name">
              </div>
            </div>
            
            <div class="form-group">
              <label for="contact-email" class="col-lg-2 control-label">Email:</label>
              <div class="col-lg-10">
                <input type="email" class="form-control" id="contact-email" placeholder="you@example.com">
              </div>
            </div>

            <div class="form-group">
              <label for="contact-msg" class="col-lg-2 control-label">Message:</label>
              <div class="col-lg-10">
                <textarea class="form-control" rows="8"></textarea>
              </div>
            </div>
          
          </div>
          <div class="modal-footer">
            <a class="btn btn-default" data-dismiss="modal">Cancel</a>
            <button class="btn btn-primary" type="submit">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
-->
<script src="https://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/prettify.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script language="javascript">
    /*$('.dropdown-toggle').dropdown();
    $('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
      });*/
</script>
<script>//http://formvalidation.io/examples/bootstrap-datepicker/
$(document).ready(function() {
    $('#datePicker').datepicker({
            format: 'mm/dd/yyyy'
        })
        .on('changeDate', function(e) {
            //$('#eventForm').formValidation('revalidateField', 'date');
        });

 /*   $('#eventForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The name is required'
                    }
                }
            },
            date: {
                validators: {
                    notEmpty: {
                        message: 'The date is required'
                    },
                    date: {
                        format: 'MM/DD/YYYY',
                        message: 'The date is not a valid'
                    }
                }
            }
        }
    });*/
});
</script>
  </body>
</html>

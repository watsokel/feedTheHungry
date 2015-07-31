<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include('dbpass.php');
$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'watsokel-db', $dbpass, 'watsokel-db');
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
} else echo "Connected to database<br>";
?>

<HTML>
  <BODY>
    <H1>UNIT TESTING FOR SHOW.PHP</H1>


  <SECTION="testSuite">
  <?php
  
  
	$unreserved="SELECT id FROM food_items_available WHERE status IS NULL";


	$list = $mysqli->query($unreserved);
          if($list->num_rows>0){
           while($rows = $list->fetch_assoc()){ 
           	$new_array[] = $rows['id'];
           	}

     foreach($new_array as $value){
     	updateFood(1, "Bill Cosby", $value);
     }}
			else{
				echo '<p>No food available to reserve</p>';
			}
     

  function updateFood($statusSet, $customerName, $value){
  	global $mysqli;
            if (!($updateQuery = $mysqli->prepare("UPDATE food_items_available SET status=?, customer=? WHERE id=?"))) {
              echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
            }
            
           
          	if (!$updateQuery->bind_param("isi", $statusSet, $customerName, $value)) {
              echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            }
		        if (!$updateQuery->execute()) {
              echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }else{
              echo '<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-ok"></span>
                    Thanks! Food item id#'.$value.' was successfully reserved by '.$customerName.'!!!</div>';  
            }
    				$updateQuery->close();
          }
  ?>

  </SECTION>
  </BODY>
</HTML>

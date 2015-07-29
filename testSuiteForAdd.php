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
    <H1>UNIT TESTING FOR ADD.PHP</H1>
    <FORM ACTION="testSuiteForAdd.php" METHOD="POST">
      <FIELDSET>
      <LEGEND>Enter time in MM/DD/YYYY format</LEGEND>
      <LABEL FOR="inputPassword" ID="eb">EAT BY</LABEL>
         <INPUT TYPE="text" NAME="eatByDate" id="eb">
         <INPUT TYPE="submit" NAME="submitFood">
      </FIELDSET>
    </FORM>
    <SECTION="unitTest">
  <?php
  if(isset($_POST['submitFood'])) {
    $eatBy = $_POST['eatByDate'];                   //retrieve eatByDate string
    $eatByDate = date("Y-m-d", strtotime($eatBy));  //reformat and create date object
    $currentDate = date("Y-m-d");                   //create date object
    $currentTime = strtotime($currentDate);         //convert date obj to sec since Epoch
    $eatByTime = strtotime($eatByDate);             //convert date obj to sec since Epoch
    echo "<P>\$eatByDate=$eatByDate and \$currentDate=$currentDate ";
    if($eatByTime < $currentTime) {                 //prevent database access if invalid eatBy
      echo "ERROR: PRECEDES CURRENT DATE.</P>";
    } else {
      echo "EAT BY DATE IS VALID</P>";
    }
  }
  ?>
  </SECTION>

  <SECTION="testSuite">
  <?php
  
  testValidateEatByDate("07/27/1982");
  testValidateEatByDate("07/25/1990");
  testValidateEatByDate("06/01/2015");
  testValidateEatByDate("12/20/2016");
  testValidateEatByDate("01/01/2050");

  addFood("Apples",5,"01/01/2016","www.somePage.com");
  addFood("Oranges",10,"01/01/2080","www.example.com");
  addFood("Pears & Mangos",20,"01/01/2099","www.example.com");
  addFood("Potato Chips",21,"01/01/2100","www.example.com");

  /*Determines if eatby date exceeds current date*/
  function validateEatByDate($eatBy){
    $eatByDate = date("Y-m-d", strtotime($eatBy));  //reformat and create date object
    $currentDate = date("Y-m-d");                   //create date object
    $currentTime = strtotime($currentDate);         //convert date obj to sec since Epoch
    $eatByTime = strtotime($eatByDate);             //convert date obj to sec since Epoch
    echo "<P>\$eatByDate=$eatByDate and \$currentDate=$currentDate ";
    return ($eatByTime < $currentTime)? NULL:$eatByDate;
  }

  /*Calls the validateEatByDate function*/
  function testValidateEatByDate($dateToEvaluate){
    if(validateEatByDate($dateToEvaluate)==NULL){
      echo "ERROR: PRECEDES CURRENT DATE.</P>";
    } else {
      echo "EAT BY DATE IS VALID</P>";
    }  
  }

  /*Tests adding food to database*/
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

  </SECTION>
  </BODY>
</HTML>

<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
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
validateEatByDate("01/01/1970");
validateEatByDate("07/27/1982");
validateEatByDate("07/25/1990");
validateEatByDate("06/01/2015");
validateEatByDate("12/20/2016");
validateEatByDate("01/01/2050");

function validateEatByDate($eatBy){
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
  </BODY>
</HTML>

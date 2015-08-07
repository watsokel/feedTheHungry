<?php 

//We include the photo upload function(s) to test here:
include('photoUpload.php');

?>
<HTML>
  <BODY>
    <H1>UNIT TESTING FOR PHOTO UPLOAD</H1>
    <FORM ACTION="testSuiteForPhotos.php" METHOD="POST" enctype="multipart/form-data">
      <FIELDSET>
      <LEGEND>Upload a photo:</LEGEND>
      <LABEL ID="fileToUpload">Photo</LABEL>
         <input type="file" name="fileToUpload" id="fileToUpload" class="">
         <input type="hidden" name="submitted" id="submitted" value="true">
         <INPUT TYPE="submit" NAME="submit">
         <br>
         Max Filesize is 500 kB.
      </FIELDSET>
    </FORM>
    <SECTION="Results">
    <?php 
        if (isset($_POST[submitted])){
            echo "<h3>Result of upload:</h3><br/>";
            $photoURL = uploadPhoto();

            echo "photoURL = ";
            if (is_null($photoURL) === true) {
                echo "NULL<br>\n";
                echo "File either rejected, or not submitted.<br/>";
            } else {
                echo $photoURL . "<br>\n";
                echo "<img src='" . $photoURL . "' alt='Your uploaded photo'><br/>";
            }
        }
    ?>
    </SECTION>
  </BODY>
</HTML>
<?php
/*
* fileUploadError(str)
*---------------------
* For handling errors in file uploads later
*/
function fileUploadError($str) {
    echo $str . "</br>\n";
    return;
}


/*
* photoUpload()
* -----------
* For a file upload to $_FILES, checks aspects of that file, then uploads.
* Returns URL for successful uploads or NULL if unsuccessful
* 
* Based off of PHP 5 File Upload tutorial by W3 Schools at http://www.w3schools.com/php/php_file_upload.asp
* Better version may be at http://php.net/manual/en/features.file-upload.php
*/


function uploadPhoto() {
    //set NULL in cases where no file is selected
    if (!( isset($_FILES["fileToUpload"]["name"]) && $_FILES["fileToUpload"]["size"] > 0)) {
      return NULL;
    }
    
    //Target Directory to save file to:
    $target_dir = "photos";

    // Create the photos directory if it does not already exist
    if ( file_exists("photos") === false) {
        mkdir("photos", 0755);
    }
    
    // Append timestamp to file name
    $date = date('YmdHis');
    $raw_file_name = explode(".", basename($_FILES["fileToUpload"]["name"]));
    $target_file = $target_dir . "/" . $raw_file_name[0] . $date . '.' . $raw_file_name[1];
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            fileUploadError("File is not an image");
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        fileUploadError("That file already exists");
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        fileUploadError("File is too large.");
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        fileUploadError("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        return NULL;

    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            chmod($target_file, 0644);
            return $target_file;
        } else {
            fileUploadError("There was an error uploading the file.");
            return NULL;
        }
    }
}
?>
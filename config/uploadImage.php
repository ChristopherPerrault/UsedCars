<?php


// you can leave this alone until I get this working - Chris


require_once 'db.php';

// If file upload form is submitted 
$status = $statusMsg = '';
if (isset($_POST["submitImage"])) {
    $status = 'error';
    if (!empty($_FILES["image"]["name"])) {
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
            $image = $_FILES['image']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

            // Insert image content into database 
            $insert = $con->query("INSERT into `cars` (images) VALUES ('$images')");

            if ($insert) {
                $status = 'Success';
                $statusMsg = "File uploaded successfully.";
            } else {
                $statusMsg = "File upload failed, please try again.";
            }
        } else {
            $statusMsg = 'Ensure image is of type JPG, JPEG or PNG';
        }
    } else {
        $statusMsg = 'Please select an image file to upload.';
    }
}

// Display status message 
echo $statusMsg;
?>
<!-- 
<form action="uploadImage.php" method="POST" enctype="multipart/form-data">
    <label>Select Image File:</label>
    <input type="file" name="image">
    <input type="submit" name="submitImage" value="Upload"formaction="/action_page2.php">
</form> -->
<?php
session_start();
include_once 'dbh.inc.php';
$fireid = $_SESSION['u_fireid'];

if (isset($_POST['submitimg'])) {

  $imgName = $_FILES['image']['name'];
  $imgTmpName = $_FILES['image']['tmp_name'];
  $imgType = $_FILES['image']['type'];
  $imgSize = $_FILES['image']['size'];
  $imgError = $_FILES['image']['error'];

  $imgExt = explode('.', $imgName);
  $imgActualExt = strtolower(end($imgExt));

  $allowed = array('jpg', 'jpeg', 'png');
  if (!empty($imgName)) {
    if (in_array($imgActualExt, $allowed)) {
      if ($imgError === 0) {
        if ($imgSize < 4000000) {

            $imgUniqName = "profile".$fireid.".".$imgActualExt;

            $imgDestination = "../uploads/".$imgUniqName;

            move_uploaded_file($imgTmpName, $imgDestination);

            function resize_img($imgDestination, $max_res){
              if(file_exists($imgDestination)){
                switch ($imgType) {
                  case 'image/jpeg':
                  case 'image/jpg':
                    $original_img = imagecreatefromjpeg($imgDestination);
                    break;

                  case: 'image/png':
                    $original_img = imagecreatefrompng($imgDestination);
                    break;
                }


                  //resolution
                  $original_res = imagesx();
              }

            }

            //change value of propic_check to override display of default/ninjaCat
            $sql = "UPDATE profile SET propic_check=1 WHERE user_fireid='$fireid'";
            mysqli_query($conn, $sql);

            header("Location: ../myprofile.php?upload=success");

        } else {
          echo "Your file size is too large!";
        }
      } else {
        echo "There was an error uploading your image!";
      }
    } else {
      echo "The uploaded file must be a .jpg, .jpeg, or .png!";
    }
  } else {
    echo "No image selected"; //need to change to header with $_GET error message
  }


}

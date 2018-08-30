<?php

session_start();
include_once 'dbh.inc.php';
$fireid = $_SESSION['u_fireid'];

//find proper file extension
$imgName = "../uploads/profile".$fireid."*";
$imgInfo = glob($imgName);
$imgExt = explode(".", $imgInfo[0]);
$imgActualExt = $imgExt[3];

$img = "../uploads/profile".$fireid.".".$imgActualExt;

if (!unlink($img)) {
  //check if delete was successful
  echo "file deletion error!";    //change to header function for error message display
} else {
  //delete the file
  echo "file was deleted";        //change to header function for error message display
  //update database propic_check to reset display of default profile picture
  $sql = "UPDATE profile SET propic_check=0 WHERE user_fireid='$fireid';";
  mysqli_query($conn, $sql);

  header("Location: ../myprofile.php?delete=success");
}

?>

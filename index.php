<?php
session_start();
 ?>

<!DOCTYPE HTML>
<html>
<head>
<title>Bethesda Fire Department | Members' Login</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/index.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

<script src="http://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600" rel="stylesheet">

</head>

<body>
<div class="container">

  <div class="background"></div>

<!-- Error handler messages-->
      <?php
        if (!isset($_GET['login']) && !isset($_GET['form']) && !isset($_GET['reset']) && !isset($_GET['code']) && !isset($_GET['unauthorized'])) {
          include 'login/login.php';
        } else {
          if (isset($_GET['login'])) {
              include 'login/login.php';
          } elseif (isset($_GET['form'])) {
              include 'login/requestlogin.php';
          } elseif (isset($_GET['reset'])) {
              include 'login/resetpwd.php';
          } elseif (isset($_GET['code'])) {
              include 'login/changepwd.php';
          } elseif (isset($_GET['unauthorized'])) {
              include 'login/unauthorized.php';
          }
        }

       ?>

  <div class="footer">
    <ul>
      <li><a href="http://www.bethesdafire.org">Bethesdafire.org</a></li>
      <li><a href="#">Contact Us</a></li>
      <li id=facebook><a href="https://www.facebook.com/BethesdaFire/"><i class="fab fa-facebook-square"></i></a></li>
      <li id=instagram><a href="https://www.instagram.com/bethesdafd/"><i class="fab fa-instagram"></i></a></li>
    </ul>

  </div>



</div>

</body>

</html>

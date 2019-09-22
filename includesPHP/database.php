<?php
// configure these values
$dbuser="";
$dbhost="";
$dbpass="";
$dbname="";
$connection=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
error_reporting(0);

if (!isset($connection)){
      echo "Some Error occoured. Please Contact Administrators";
      die();
  }
?>
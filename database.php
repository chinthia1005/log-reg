<?php
$hostName = 'localhost';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'login_reg';

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if(!$conn){
    die("Ada yang tidak beres;");
}

?>
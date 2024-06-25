<?php
// $http_host = 'localhost/journal';
$http_host = '//'.$_SERVER['HTTP_HOST'].'/journal';
$http_root = $_SERVER['DOCUMENT_ROOT'].'/journal';


$host = "localhost";
$username = "root";
$password = ""; 
$database = "journal";


$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

?>
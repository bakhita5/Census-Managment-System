<?php
$servername="localhost";
$username="census";
$password="census2024";
$dbname="censusdb";

//creating a connection between php and mysql database 
$conn=mysqli_connect($servername,$username,$password,$dbname);

//check if the connection works
if(!$conn){
    die("Connection Failed".mysqli_connect_error());
    }
//echo "Connected successfully";

?>
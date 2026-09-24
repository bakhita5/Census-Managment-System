<?php
//include database connection
include 'connect.php';

if(isset($_POST['submit'])){
//harvested array by userregistration.php 
$name=$_POST['name'];
$username=$_POST['username'];
$password = $_POST['password'];
//$password = password_hash($_POST['password'], PASSWORD_DEFAULT);//password hash is a built in php function,password default is a predefined constant that tells the function  which hashing algorithim to use
$email=$_POST['email'];
$role=$_POST['role'];

//creating an sql string to be executed 
$sql= "INSERT INTO users (name,username,password,email,role)
 VALUES ('$name','$username','$password','$email','$role')";
}

//executing $sql string
$result=mysqli_query($conn,$sql);//receives connection to the database and the sql string

if($result){
     echo "Submitted successfully";
     header("location:login.html");

}
 else
    {
    echo "Error".mysqli_error($conn);
    }
?>

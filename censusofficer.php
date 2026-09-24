<?php 
include 'connect.php';//database connection

//harvests the data posted from censusofficer.php
if(isset($_POST['submit'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $phone_number=$_POST['phone_number'];
    $email=$_POST['email'];
    $national_id=$_POST['national_id'];
    $supervisor_id=$_POST['supervisor_id'];
    $user_id=$_POST['user_id'];
    //sql string that need to be created is executed
    $sql="INSERT INTO CENSUS_OFFICER (fname,lname,phone_number,email,national_id,supervisor_id,user_id)
    VALUES('$fname','$lname','$phone_number','$email','$national_id','$supervisor_id','$user_id')";

}
//executing $mysql string
$result=mysqli_query($conn,$sql);//receives connection to the database

if($result){
    echo "connected successfully";
      

}

else{
    echo "Error".mysqli_error($conn);
}

?>
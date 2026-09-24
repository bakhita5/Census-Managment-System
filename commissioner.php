<?php 
include 'connect.php';//include database connection

//harvesting array by commissioner.php
if(isset($_POST['submit'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $phone_number=$_POST['phone_number'];
    $email=$_POST['email'];
    $national_id=$_POST['national_id'];
    $county_id=$_POST['county_id'];
    $user_id=$_POST['user_id'];

    //sql string to be executed 
    $sql="INSERT INTO COMMISSIONER (fname,lname,phone_number,email,national_id,county_id,user_id)
    VALUES('$fname','$lname','$phone_number','$email','$national_id','$county_id','$user_id')";

}
//executing $sql string
$result=mysqli_query($conn,$sql);

if($result){
    echo "connected successfully";

}

else{
    echo "Error".mysqli_error($conn);
}

?>
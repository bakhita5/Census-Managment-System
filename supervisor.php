<?php 
include 'connect.php';

//include database connection

//harvested array by supervisor.php 
if(isset($_POST['submit'])){
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $phone_number=$_POST['phone_number'];
    $email=$_POST['email'];
    $national_id=$_POST['national_id'];
    $ward_id=$_POST['ward_id'];


    //creating an sql string to be executed 
    $sql="INSERT INTO SUPERVISOR (fname,lname,phone_number,email,national_id,ward_id)
    VALUES('$fname','$lname','$phone_number','$email','$national_id','$ward_id')";

}

//execute $sql string
$result=mysqli_query($conn,$sql);//receives connection to the database

if($result){
    echo "connected successfully";
    

}

else{
    echo "Error".mysqli_error($conn);
}

?>
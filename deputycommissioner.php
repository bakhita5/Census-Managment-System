<?php 
session_start();
include 'connect.php';//include database connection

if(isset($_POST['submit'])){

//harvested array by deputycommissioner.php
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $phone_number=$_POST['phone_number'];
    $email=$_POST['email'];
    $national_id=$_POST['national_id'];
    $subcounty_id=$_POST['subcounty_id'];
    $user_id=$_POST['user_id'];

    $sql="INSERT INTO DEPUTY_COMMISSIONER(fname,lname,phone_number,email,national_id,subcounty_id,user_id)
    VALUES ('$fname','$lname','$phone_number','$email','$national_id','$subcounty_id','$user_id')";

}
//executing $sql string
$result=mysqli_query($conn,$sql);

if($result){
  echo "
        <script>
            alert('Deputy Commissioner successfully submitted');
            window.location='commissionerdashboard.php?page=deputycommissioner';
        </script>
        ";
}

else{
    echo "Error".mysqli_error($conn);
}

?>
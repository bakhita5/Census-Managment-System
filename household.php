<?php
include 'connect.php';

if(isset($_POST['submit'])){
    $censusofficer_id=$_POST['censusofficer_id'];
    $family_size=$_POST['family_size'];
    $access_to_electricity=$_POST['access_to_electricity'];
    $access_to_water=$_POST['access_to_water'];
    $assets=$_POST['assets'];
    $residential_status=$_POST['residential_status'];
    

    $sql="INSERT INTO HOUSEHOLD(censusofficer_id,family_size,access_to_electricity,access_to_water,assets,residential_status)
     VALUES ('$censusofficer_id','$family_size','$access_to_electricity','$access_to_water','$assets','$residential_status')";

}

$result=mysqli_query($conn,$sql);

if($result){
    echo "connected successfully";
     header("location:censusofficerdashboard.php");
    exit();
}

else{
    echo "connection failed".mysqli_error($conn);
}
?>
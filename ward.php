<?php
include 'connect.php';

if(isset($_POST['submit'])){
    $ward_name=$_POST['ward_name'];
    $subcounty_id=$_POST['subcounty_id'];

    $sql="INSERT INTO ward(ward_name,subcounty_id) 
    VALUES ('$ward_name','$subcounty_id')";
}

$result=mysqli_query($conn,$sql);

if($result){
    echo "connected successfully";
}
else{
   echo "Error".mysqli_error($conn);
}
?>
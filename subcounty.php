<?php
include 'connect.php';

if(isset($_POST['submit'])){
    $subcounty_name=$_POST['subcounty_name'];
    $county_id=$_POST['county_id'];

    $sql="INSERT INTO SUBCOUNTY(subcounty_name,county_id) 
    VALUES ('$subcounty_name','$county_id')";


$result=mysqli_query($conn,$sql);

if($result){
     echo "
        <script>
            alert('Subcounty Added successfully ');
            window.location='commissionerdashboard.php?page=subcounty';
        </script>
        ";

}
else{
   echo "Error".mysqli_error($conn);
}
}
?>
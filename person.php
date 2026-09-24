<?php
include 'connect.php';

if(isset($_POST['submit'])){

    $household_id = $_POST['household_id'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $marital_status = $_POST['marital_status'];
    $education = $_POST['education'];
    $religion = $_POST['religion'];
    $occupation = $_POST['occupation'];
    $employment_status = $_POST['employment_status'];
    $tribe = $_POST['tribe'];

    $sql = "INSERT INTO PERSON
    (household_id, age, gender, marital_status, education, religion, occupation, employment_status, tribe)
    VALUES
    ('$household_id', '$age', '$gender', '$marital_status', '$education', '$religion', '$occupation', '$employment_status', '$tribe')";

    $result = mysqli_query($conn, $sql);

   if($result){
     echo "Submitted successfully";
     header("location:censusofficerdashboard.php");

    } else {
        echo "Insert failed: " . mysqli_error($conn);
    }
}
?>
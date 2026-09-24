<?php
session_start();
include 'connect.php';

$person_id = $_GET['id'] ?? null;

if (!$person_id) {
    header("Location: censusofficerdashboard.php");
    exit();
}

// Delete Person
if (isset($_GET['action']) && $_GET['action'] == "delete") {

    $delete_sql = "DELETE FROM PERSON WHERE person_id='$person_id'";

    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['message'] = "Person deleted successfully!";
        header("Location: censusofficerdashboard.php");
        exit();
    } else {
        $error = "Error deleting person: " . mysqli_error($conn);
    }
}

// Update Person
if (isset($_POST['update'])) {

    $household_id = $_POST['household_id'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $marital_status = $_POST['marital_status'];
    $education = $_POST['education'];
    $religion = $_POST['religion'];
    $occupation = $_POST['occupation'];
    $employment_status = $_POST['employment_status'];
    $tribe = $_POST['tribe'];

    $update_sql = "UPDATE PERSON SET
        household_id='$household_id',
        age='$age',
        gender='$gender',
        marital_status='$marital_status',
        education='$education',
        religion='$religion',
        occupation='$occupation',
        employment_status='$employment_status',
        tribe='$tribe'
        WHERE person_id='$person_id'";

    if (mysqli_query($conn, $update_sql)) {

        $_SESSION['message'] = "Person updated successfully!";
        header("Location: censusofficerdashboard.php");
        exit();

    } else {

        $error = "Error updating person: " . mysqli_error($conn);
    }
}

// Fetch Person
$sql = "SELECT * FROM PERSON WHERE person_id='$person_id'";
$result = mysqli_query($conn, $sql);

$person = mysqli_fetch_assoc($result);

if (!$person) {
    header("Location: censusofficerdashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Person</title>

    <link rel="stylesheet" href="commissionerdashboard.css">

    <link rel="stylesheet" href="manage_person.css">

</head>

<body>

<div class="main">

    <div class="header">
        <h1>Manage Person #<?= $person_id ?></h1>
    </div>

    <?php if(isset($error)): ?>
        <div class="error-message">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <div class="form-container">

        <h2>Edit Person</h2>

        <form method="POST">

            <div class="form-group">
                <label>Household ID</label>
                <input type="text" name="household_id" value="<?= $person['household_id']; ?>" required>
            </div>

            <div class="form-group">
                <label>Age</label>
                <input type="number"  name="age" value="<?= $person['age']; ?>" required>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select name="gender">
           <option value="Male"    <?= ($person['gender']=="Male") ? "selected" : ""; ?>>   Male</option>
           <option value="Female" <?= ($person['gender']=="Female") ? "selected" : ""; ?>> Female   </option>
         </select>

            </div>

            <div class="form-group">
                <label>Marital Status</label>

                <select name="marital_status">

                    <option value="Single" <?= ($person['marital_status']=="Single")?"selected":""; ?>>Single</option>

                    <option value="Married" <?= ($person['marital_status']=="Married")?"selected":""; ?>>Married</option>

                    <option value="Divorced" <?= ($person['marital_status']=="Divorced")?"selected":""; ?>>Divorced</option>

                    <option value="Separated" <?= ($person['marital_status']=="Separated")?"selected":""; ?>>Separated</option>

                    <option value="Widowed" <?= ($person['marital_status']=="Widowed")?"selected":""; ?>>Widowed</option>

                </select>

            </div>

            <div class="form-group">
                <label>Education</label>
                <input type="text" name="education" value="<?= $person['education']; ?>">
            </div>

            <div class="form-group">
                <label>Religion</label>
                <input type="text" name="religion" value="<?= $person['religion']; ?>">
            </div>

            <div class="form-group">
                <label>Occupation</label>
                <input type="text"  name="occupation"  value="<?= $person['occupation']; ?>">
            </div>

            <div class="form-group">
                <label>Employment Status</label>
                <input type="text"name="employment_status"value="<?= $person['employment_status']; ?>">
            </div>

            <div class="form-group">
               <label>Tribe</label>
                <input type="text" name="tribe" value="<?= $person['tribe']; ?>">
            </div>

            <div class="button-group">

                <button type="submit"  name="update" class="btn-update">Update Person </button>
                   <a href="manage_person.php?id=<?= $person_id ?>&action=delete" class="btn-delete">  Delete Person</a>
                    <a href="censusofficerdashboard.php?page=person" class="btn-cancel">  Cancel</a>
            </div>
        </form>
    </div>
</div>


<style>{
    margin:0;
    padding:0;
    font-family:Arial, Helvetica, sans-serif;
    background:#f4f4f4;
}

.main{
    padding:20px;
}

.header{
    text-align:center;
    margin-bottom:20px;
}

.header h1{
    color:#333;
}

.form-container{
    max-width:600px;
    margin:20px auto;
    padding:20px;
    background:#fff;
    border-radius:8px;
    box-shadow:0 2px 10px rgba(0,0,0,0.15);
}

.form-container h2{
    text-align:center;
    color:#333;
    margin-bottom:20px;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    color:#333;
}

.form-group input,
.form-group select{
    width:100%;
    padding:10px;
    border:1px solid #ccc;
    border-radius:5px;
    font-size:15px;
    box-sizing:border-box;
}

.form-group input:focus,
.form-group select:focus{
    outline:none;
    border-color:#4CAF50;
}

.button-group{
    display:flex;
    justify-content:space-between;
    gap:10px;
    margin-top:20px;
}

.button-group button,
.button-group a{
    flex:1;
    text-align:center;
    padding:10px;
    border:none;
    border-radius:5px;
    text-decoration:none;
    cursor:pointer;
    font-size:15px;
    transition:0.3s;
}

.btn-update{
    background:#4CAF50;
    color:white;
}

.btn-update:hover{
    background:#45a049;
}

.btn-delete{
    background:#f44336;
    color:white;
}

.btn-delete:hover{
    background:#d32f2f;
}

.btn-cancel{
    background:#666;
    color:white;
}

.btn-cancel:hover{
    background:#555;
}

.error-message{
    color:red;
    background:#ffe6e6;
    border:1px solid red;
    padding:10px;
    margin-bottom:15px;
    border-radius:5px;
    text-align:center;
}

.success-message{
    color:green;
    background:#e8f5e9;
    border:1px solid green;
    padding:10px;
    margin-bottom:15px;
    border-radius:5px;
    text-align:center;
}
</style>

</body>
</html>
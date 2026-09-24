<?php
session_start();//invokes the start of a session using the superglobal function $_Session
include 'connect.php';//include the database

$user_id = $_SESSION['user_id'];//we assign user_id variable to read/retrieve data from the superglobal variable $_session
$page = $_GET['page'] ?? 'home';//gets the page parameter from the URL  and if it does not exists it takes it to home(default value)

$sql_county="SELECT county_name FROM COUNTY";//it is an sql that is used to retrieve the county_name from the county table 
$result_county=mysqli_query($conn,$sql_county);//mysqli_query is a function that is carried out againist the database and contains the sql string that is to be  executed 
$county_row = mysqli_fetch_assoc($result_county);//mysqli_fetch_assoc is associative array that holds key values pairs from the result county
$county_name = $county_row['county_name'] ?? 'County';//it retrieves the county name from the array and if it does not exists it defaults to county


$sql_name="SELECT fname,lname FROM COMMISSIONER";//string that is to be executed to retrieve the first name and last name from the commissioners table
$result_name=mysqli_query($conn,$sql_name);//result_name is assigned to mysqli_query which is a PHP function that is run against the database and contains the SQL string
$commissioner_row = mysqli_fetch_assoc($result_name);//mysqli_fetch_assoc which is an associative array which stores values in key-value pairs for the result_name
$commissioner_name = ($commissioner_row['fname'] ?? '') . ' ' . ($commissioner_row['lname'] ?? '');//commissioner_name is assigned to fetch the first name from the commissioner_row array and the last name from the commissioner_row array


$sql_subcounty = "SELECT * FROM SUBCOUNTY";
$result_subcounty = mysqli_query($conn, $sql_subcounty);

$sql_ward = "SELECT * FROM WARD";
$result_ward = mysqli_query($conn, $sql_ward);

$sql_deputycommissioner="SELECT * FROM DEPUTY_COMMISSIONER";
$result_deputycommissioner=mysqli_query($conn,$sql_deputycommissioner);

$sql_supervisors = "SELECT * FROM SUPERVISOR";
$result_supervisor = mysqli_query($conn, $sql_supervisors);

$sql_censusofficer = "SELECT * FROM CENSUS_OFFICER";
$result_censusofficer = mysqli_query($conn, $sql_censusofficer);

$sql_household = "SELECT * FROM HOUSEHOLD";
$result_household = mysqli_query($conn, $sql_household);

$sql_person = "SELECT * FROM PERSON";
$result_person = mysqli_query($conn, $sql_person);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Census Commissioner Dashboard</title>
    <link rel="stylesheet" href="commissionerdashboard.css">
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <h2>Welcome</h2>
        <p>Commissioner <?= $commissioner_name ?></p>
        </div>

        <ul class="menu">
            <li><a href="commissionerdashboard.php">Dashboard</a></li>
            <li><a href="commissionerdashboard.php?page=subcounty">Add Subcounties</a></li>
            <li><a href="commissionerdashboard.php?page=ward">Add Wards</a></li>
            <li><a href="commissionerdashboard.php?page=deputycommissioner">Add Deputies</a></li>
            <li><a href="commissionerdashboard.php?page=supervisor">Add Supervisors</a></li>
            <li><a href="commissionerdashboard.php?page=censusofficer">Add Census Officers</a></li>
            <li><a href="commissionerreports.php">Reports</a></li>
            <li><a href="homepage.html">Logout</a></li>
        </ul>

        
    </div>

    <!-- Main Content -->
    <div class="main">
        <?php if ($page == 'home' || $page == 'viewsubcounty' || $page == 'viewward' || $page == 'viewsupervisor' || $page == 'viewcensusofficer' || $page == 'viewhousehold' || $page == 'viewpeople'): ?>
            <div class="header">
                <h1>Commissioner Dashboard</h1>
                <p><u><?=$county_name?> County</u></p>
            </div>

            <!-- Dashboard Cards -->
            <div class="cards">
                <div class="card">
                    <h2><?= mysqli_num_rows($result_subcounty) ?></h2>
                    <p>Subcounties</p>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_ward) ?></h2>
                    <p>Wards</p>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_deputycommissioner) ?></h2>
                    <p>Deputy Commissioners</p>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_supervisor) ?></h2>
                    <p>Supervisors</p>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_censusofficer) ?></h2>
                    <p>Census Officers</p>
               </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_household) ?></h2>
                    <p>Counted households</p>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_person) ?></h2>
                    <p>People Counted</p>
                </div>
            </div>
        <?php endif; ?>

        <?php
        if ($page == 'subcounty') {
            include 'subcounty.html';
        } else if ($page == 'ward') {
            include 'ward.html';
        } else if ($page == 'deputycommissioner') {
            include 'deputycommissioner.html';
        } else if ($page == 'supervisor') {
            include 'supervisor.html';
        } else if ($page == 'censusofficer') {
            include 'censusofficer.html';
        } else if ($page == 'household') {
            include 'household.html';
        } else if ($page == 'person') {
            include 'person.html';
        }
        ?>
      
</html>
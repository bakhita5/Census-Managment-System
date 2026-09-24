<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];
$page = $_GET['page'] ?? 'home';


$sql_supervisor="SELECT fname,lname FROM SUPERVISOR WHERE user_id = '$user_id'";
$result_supervisor=mysqli_query($conn,$sql_supervisor);
$supervisor_row = mysqli_fetch_assoc($result_supervisor);
$supervisor_name = ($supervisor_row['fname'] ?? '') . ' ' . ($supervisor_row['lname'] ?? '');


$sql_ward="SELECT WARD.ward_name FROM SUPERVISOR JOIN WARD ON SUPERVISOR.ward_id = WARD.ward_id WHERE SUPERVISOR.user_id = '$user_id'";
$result_ward=mysqli_query($conn,$sql_ward);
$ward_row = mysqli_fetch_assoc($result_ward);
$ward_name = $ward_row['ward_name'] ?? 'ward';

// --- CENSUS OFFICERS (Only in this Supervisor's Ward) ---
$sql_censusofficer = "SELECT CENSUS_OFFICER.* 
FROM CENSUS_OFFICER 
JOIN SUPERVISOR ON CENSUS_OFFICER.supervisor_id = SUPERVISOR.supervisor_id 
JOIN WARD ON SUPERVISOR.ward_id = WARD.ward_id 
WHERE WARD.ward_id = (SELECT ward_id FROM SUPERVISOR WHERE user_id = '$user_id')";
$result_censusofficer = mysqli_query($conn, $sql_censusofficer);

// --- HOUSEHOLDS (Only in this Supervisor's Ward) ---
$sql_household = "SELECT HOUSEHOLD.* 
FROM HOUSEHOLD 
JOIN CENSUS_OFFICER ON HOUSEHOLD.censusofficer_id = CENSUS_OFFICER.censusofficer_id 
JOIN SUPERVISOR ON CENSUS_OFFICER.supervisor_id = SUPERVISOR.supervisor_id 
JOIN WARD ON SUPERVISOR.ward_id = WARD.ward_id 
WHERE WARD.ward_id = (SELECT ward_id FROM SUPERVISOR WHERE user_id = '$user_id')";
$result_household = mysqli_query($conn, $sql_household);

// --- PERSONS (Only in this Supervisor's Ward) ---
$sql_person = "SELECT PERSON.* 
FROM PERSON 
JOIN HOUSEHOLD ON PERSON.household_id = HOUSEHOLD.household_id 
JOIN CENSUS_OFFICER ON HOUSEHOLD.censusofficer_id = CENSUS_OFFICER.censusofficer_id 
JOIN SUPERVISOR ON CENSUS_OFFICER.supervisor_id = SUPERVISOR.supervisor_id 
JOIN WARD ON SUPERVISOR.ward_id = WARD.ward_id 
WHERE WARD.ward_id = (SELECT ward_id FROM SUPERVISOR WHERE user_id = '$user_id')";
$result_person = mysqli_query($conn, $sql_person);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
    <link rel="stylesheet" href="commissionerdashboard.css">
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        <h2>Welcome</h2>
          <p>Supervisor <?= $supervisor_name ?></p>
    </div>

    <ul class="menu">
        <li><a href="supervisordashboard.php">Dashboard</a></li>
        <li><a href="supervisordashboard.php?page=censusofficer">Add Census Officers</a></li>
        <li><a href="supervisordashboardreport.php">Reports</a></li>
        <li><a href="homepage.html">Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main">
 <?php if ($page == 'home' || $page == 'viewsubcounty' || $page == 'viewward' || $page == 'viewsupervisor' || $page == 'viewcensusofficer' || $page == 'viewhousehold' || $page == 'viewpeople'): ?>
    <!-- HEADER - ALWAYS SHOWS -->
    <div class="header">
        <h1>Supervisor Dashboard</h1>
         <p><u><?=$ward_name?> Ward</u></p>
    </div>

    <!-- CARDS - ALWAYS SHOWS -->
    <div class="cards">
       
        <div class="card">
            <h2><?= mysqli_num_rows($result_censusofficer) ?></h2>
            <p>Census Officers</p>
           
        </div>

        <div class="card">
            <h2><?= mysqli_num_rows($result_household) ?></h2>
            <p> Counted Households</p>
          
        </div>

        <div class="card">
            <h2><?= mysqli_num_rows($result_person) ?></h2>
            <p>People Counted</p>
          
        </div>
    </div>
 <?php endif; ?>
    
   

    <!-- INCLUDE PAGES FOR ADDING -->
    <?php
    if($page == 'ward'){
        include 'ward.html';
    }
    else if($page == 'censusofficer'){
        include 'censusofficer.html';
    }
    ?>

</div>

</body>
</html>
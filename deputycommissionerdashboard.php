<?php
session_start();//invokes the start of a session using the superglobal function $_Session
include 'connect.php';//include the database connection file

$user_id = $_SESSION['user_id'];////we assign user_id variable to read/retrieve data from the superglobal variable $_session

$page = $_GET['page'] ?? 'home';//gets the page parameter from the URL  and if it does not exists it takes it to home(default value)




$sql_name="SELECT fname,lname FROM DEPUTY_COMMISSIONER WHERE user_id=$user_id";
$result_name=mysqli_query($conn,$sql_name);
$deputycommissioner_row = mysqli_fetch_assoc($result_name);
$deputycommissioner_name = ($deputycommissioner_row['fname'] ?? '') . ' ' . ($deputycommissioner_row['lname'] ?? '');


$sql_subcounty="SELECT SUBCOUNTY.subcounty_name
FROM DEPUTY_COMMISSIONER
JOIN SUBCOUNTY
ON DEPUTY_COMMISSIONER.subcounty_id = SUBCOUNTY.subcounty_id
WHERE DEPUTY_COMMISSIONER.user_id = '$user_id'";
$result_subcounty=mysqli_query($conn,$sql_subcounty);
$subcounty_row = mysqli_fetch_assoc($result_subcounty);
$subcounty_name = $subcounty_row['subcounty_name'] ?? 'SubCounty';


// --- WARDS (Only in this Subcounty) ---
$sql_ward = "SELECT WARD.* 
FROM WARD 
JOIN SUBCOUNTY ON WARD.subcounty_id = SUBCOUNTY.subcounty_id 
WHERE SUBCOUNTY.subcounty_name = '$subcounty_name'";
$result_ward = mysqli_query($conn, $sql_ward);

// --- SUPERVISORS (Only in this Subcounty) ---
$sql_supervisors = "SELECT SUPERVISOR.* 
FROM SUPERVISOR 
JOIN WARD ON SUPERVISOR.ward_id = WARD.ward_id 
JOIN SUBCOUNTY ON WARD.subcounty_id = SUBCOUNTY.subcounty_id 
WHERE SUBCOUNTY.subcounty_name = '$subcounty_name'";
$result_supervisor = mysqli_query($conn, $sql_supervisors);

// --- CENSUS OFFICERS (Only in this Subcounty) ---
$sql_censusofficer = "SELECT CENSUS_OFFICER.* 
FROM CENSUS_OFFICER 
JOIN SUPERVISOR ON CENSUS_OFFICER.supervisor_id = SUPERVISOR.supervisor_id 
JOIN WARD ON SUPERVISOR.ward_id = WARD.ward_id 
JOIN SUBCOUNTY ON WARD.subcounty_id = SUBCOUNTY.subcounty_id 
WHERE SUBCOUNTY.subcounty_name = '$subcounty_name'";
$result_censusofficer = mysqli_query($conn, $sql_censusofficer);

$sql_household = "SELECT
    HOUSEHOLD.household_id,
    HOUSEHOLD.family_size,
    HOUSEHOLD.access_to_electricity,
    HOUSEHOLD.access_to_water,
    HOUSEHOLD.assets,
    HOUSEHOLD.residential_status,
    CONCAT(CENSUS_OFFICER.fname, ' ', CENSUS_OFFICER.lname) AS census_officer
FROM HOUSEHOLD
JOIN CENSUS_OFFICER
ON HOUSEHOLD.censusofficer_id = CENSUS_OFFICER.censusofficer_id
JOIN SUPERVISOR
ON CENSUS_OFFICER.supervisor_id = SUPERVISOR.supervisor_id
JOIN WARD
ON SUPERVISOR.ward_id = WARD.ward_id
JOIN SUBCOUNTY
ON WARD.subcounty_id = SUBCOUNTY.subcounty_id
WHERE SUBCOUNTY.subcounty_name = '$subcounty_name'";// The HOUSEHOLD table is linked to the CENSUS_OFFICER, who is linked to a SUPERVISOR, then to a WARD, and finally to a SUBCOUNTY. 
//These joins allow the query to reach the SUBCOUNTY table so that the WHERE clause can filter households from the selected subcounty.
$result_household = mysqli_query($conn, $sql_household);

$sql_person = "SELECT PERSON.*
FROM PERSON
JOIN HOUSEHOLD
ON PERSON.household_id = HOUSEHOLD.household_id
JOIN CENSUS_OFFICER
ON HOUSEHOLD.censusofficer_id = CENSUS_OFFICER.censusofficer_id
JOIN SUPERVISOR
ON CENSUS_OFFICER.supervisor_id = SUPERVISOR.supervisor_id
JOIN WARD
ON SUPERVISOR.ward_id = WARD.ward_id
JOIN SUBCOUNTY
ON WARD.subcounty_id = SUBCOUNTY.subcounty_id
WHERE SUBCOUNTY.subcounty_name = '$subcounty_name'";
$result_person = mysqli_query($conn, $sql_person);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deputy Commissioner Dashboard</title>
    <link rel="stylesheet" href="commissionerdashboard.css">
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        <h2>Welcome</h2>
        <p>Deputy Commissioner <?= $deputycommissioner_name ?></p>
    </div>

    <ul class="menu">
        <li><a href="deputycommissionerdashboard.php">Dashboard</a></li>
        <li><a href="deputycommissionerdashboard.php?page=ward">Add Wards</a></li>
        <li><a href="deputycommissionerdashboard.php?page=supervisor">Add Supervisors</a></li>
        <li><a href="deputycommissionerdashboard.php?page=censusofficer">Add Census Officers</a></li>
        <li><a href="deputycommissionerreports.php">Reports</a></li>
        <li><a href="homepage.html">Logout</a></li>
    </ul>
</div>

<!-- Main Content -->
<div class="main">
<?php if ($page == 'home' || $page == 'viewsubcounty' || $page == 'viewward' || $page == 'viewsupervisor' || $page == 'viewcensusofficer' || $page == 'viewhousehold' || $page == 'viewpeople'): ?>
           
    
    <div class="header">
        <h1>Deputy Commissioner Dashboard</h1>
        <p><?=$subcounty_name?> SubCounty</p>
    </div>

    
    <div class="cards">
        <div class="card">
            <h2><?= mysqli_num_rows($result_ward) ?></h2>
            <p>Wards</p>
            
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
            <p> Counted Households</p>
          
        </div>

        <div class="card">
            <h2><?= mysqli_num_rows($result_person) ?></h2>
            <p>People Counted</p>
           
    </div>
 <?php endif; ?>

    <!-- INCLUDE PAGES FOR ADDING (Keep these for the "Add" links) -->
    <?php
    if($page == 'ward'){
        include 'ward.html';
    }
    else if($page == 'supervisor'){
        include 'supervisor.html';
    }
    else if($page == 'censusofficer'){
        include 'censusofficer.html';
    }
    else if($page == 'household'){
        include 'household.html';
    }
    else if($page == 'person'){
        include 'person.html';
    }
    ?>

</div>

</body>
</html>
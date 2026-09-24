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


$sql_censusofficer = "SELECT
    CENSUS_OFFICER.censusofficer_id,
    CENSUS_OFFICER.fname,
    CENSUS_OFFICER.lname,
    WARD.ward_name
FROM CENSUS_OFFICER
JOIN SUPERVISOR
ON CENSUS_OFFICER.supervisor_id = SUPERVISOR.supervisor_id
JOIN WARD
ON SUPERVISOR.ward_id = WARD.ward_id
WHERE WARD.ward_id = (SELECT ward_id FROM SUPERVISOR WHERE user_id = '$user_id')";
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
WHERE WARD.ward_id = (SELECT ward_id FROM SUPERVISOR WHERE user_id = '$user_id')";
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
WHERE WARD.ward_id = (SELECT ward_id FROM SUPERVISOR WHERE user_id = '$user_id')";
$result_person = mysqli_query($conn, $sql_person);



//code for the filter
$gender = $_GET['gender'] ?? '';
$employment_status = $_GET['employment_status'] ?? '';
$religion = $_GET['religion'] ?? '';
$min_age = $_GET['min_age'] ?? '';
$max_age = $_GET['max_age'] ?? '';


$sql_person_filter = "SELECT
    PERSON.*,
    WARD.ward_name,
    SUBCOUNTY.subcounty_name
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
WHERE 1=1
AND WARD.ward_id = (SELECT ward_id FROM SUPERVISOR WHERE user_id = '$user_id')";


 if($gender != ""){
    $sql_person_filter .= " AND PERSON.gender='$gender'";
}

  if($employment_status != ""){
    $sql_person_filter .= " AND PERSON.employment_status='$employment_status'";
}

  if($religion != ""){
    $sql_person_filter .= " AND PERSON.religion='$religion'";
}

if($min_age != ""){
    $sql_person_filter .= " AND PERSON.age >= $min_age";
}

if($max_age != ""){
    $sql_person_filter .= " AND PERSON.age <= $max_age";
}


$result_person_filter = mysqli_query($conn,$sql_person_filter);


// Get data for tables when needed
 if($page == 'viewcensusofficer') {
   
    $result_censusofficer = mysqli_query($conn, $sql_censusofficer);
}
else if($page == 'viewhousehold') {
   
    $result_household= mysqli_query($conn, $sql_household);
}
else if($page == 'viewpeople') {   
   
    $result_person= mysqli_query($conn, $sql_person_filter);
}






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
            <a href="supervisordashboardreport.php?page=viewcensusofficer">View All</a>
        </div>

        <div class="card">
            <h2><?= mysqli_num_rows($result_household) ?></h2>
            <p>Counted Households</p>
            <a href="supervisordashboardreport.php?page=viewhousehold">View All</a>
        </div>

        <div class="card">
            <h2><?= mysqli_num_rows($result_person) ?></h2>
            <p>People Counted</p>
            <a href="supervisordashboardreport.php?page=viewpeople">View All</a>
        </div>
    </div>
 <?php endif; ?>
    
    <!-- TABLE - CENSUS OFFICERS -->
    <?php if($page == 'viewcensusofficer'): ?>
        <div class="table-section">
            <h3>Census Officers List</h3>
            <table border="1">
                <thead>
                    <tr>
                        
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Ward Assigned To</th>
                      
                     
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result_censusofficer) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_censusofficer)): ?>
                            <tr>
                                <td><?= $row['fname'] ?></td>
                                <td><?= $row['lname'] ?></td>
                                <td><?= $row['ward_name'] ?></td>
                               
                                
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No census officers found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- TABLE - HOUSEHOLDS -->
    <?php if($page == 'viewhousehold'): ?>
        <div class="table-section">
            <h3>Households List</h3>
            <table border="1">
                <thead>
                    <tr>
                        <th>Household Number</th>
                        <th>Family Size</th>
                        <th> Access to Electricity</th>
                        <th>Access to Water</th>
                        <th>Assets</th>
                        <th>Residential Status</th>
                        <th>Data Collected By</th>
                       
                       
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result_household) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_household)): ?>
                            <tr>
                             <td><?= $row['household_id'] ?></td>
                                <td><?= $row['family_size'] ?></td>
                                <td><?= $row['access_to_electricity'] ?></td>
                                <td><?= $row['access_to_water'] ?></td>
                                <td><?= $row['assets'] ?></td>
                                <td><?= $row['residential_status'] ?></td>
                                <td><?= $row['census_officer'] ?></td>
                             
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No households found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- TABLE - PERSONS ENUMERATED -->
    <?php if($page == 'viewpeople'): ?>
        <div class="table-section">
            <h3>Persons Enumerated List</h3>
<!--filter container-->
    <div class="filter-container">
     <form method="GET" class="filter-form" >
      <input type="hidden" name="page" value="viewpeople">

 <select name="gender">
            <option value="">All Gender</option>
            <option value="Male" <?= $gender == "Male" ? "selected" : "" ?>>Male</option>
            <option value="Female" <?= $gender == "Female" ? "selected" : "" ?>>Female</option>
        </select>

        <select name="employment_status">
    <option value="">All Employment</option>
    <option value="Employed" <?= $employment_status == "Employed" ? "selected" : "" ?>>Employed</option>
    <option value="Self employed" <?= $employment_status == "Self employed" ? "selected" : "" ?>>Self employed</option>
    <option value="Student" <?= $employment_status == "Student" ? "selected" : "" ?>>Student</option>
    <option value="Retired" <?= $employment_status == "Retired" ? "selected" : "" ?>>Retired</option>
    <option value="Not employed" <?= $employment_status == "Not employed" ? "selected" : "" ?>>Not employed</option>

        </select>

        <input type="number" name="min_age" placeholder="Min Age"   value="<?=$min_age ?>" >

        <input type="number" name="max_age" placeholder="Max Age"  value="<?=$max_age?>">

    <select name="religion">
    <option value="">All Religion</option>
    <option value="Christian" <?= $religion == "Christian" ? "selected" : "" ?>>Christian</option>
    <option value="Muslim" <?= $religion == "Muslim" ? "selected" : "" ?>>Muslim</option>
    <option value="Hindu" <?= $religion == "Hindu" ? "selected" : "" ?>>Hindu</option>
    <option value="Atheist" <?= $religion == "Atheist" ? "selected" : "" ?>>Atheist</option>
</select>

        <button type="submit">Apply Filters</button>

</form>
<!--filter container-->



 <table border="1">
                <thead>
                    <tr>
                           
                        <th>Household ID</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Marital Status</th>
                        <th>Education</th>
                        <th>Religion</th>
                        <th>Occupation</th>
                        <th>Employment</th>
                        <th>Tribe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result_person_filter) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_person_filter)): ?>
                            <tr>
                                
                                <td><?= $row['household_id'] ?></td>
                                <td><?= $row['age'] ?></td>
                                <td><?= $row['gender'] ?></td>
                                <td><?= $row['marital_status'] ?></td>
                                <td><?= $row['education'] ?></td>
                                <td><?= $row['religion'] ?></td>
                                <td><?= $row['occupation'] ?></td>
                                <td><?= $row['employment_status'] ?></td>
                                <td><?= $row['tribe'] ?></td>
                              
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11">No persons found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- INCLUDE PAGES FOR ADDING -->
    <?php
    if($page == 'censusofficer'){
        include 'censusofficer.html';
    }
    ?>

</div>

</body>
</html>
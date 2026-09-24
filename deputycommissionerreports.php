<?php
session_start();
include 'connect.php';

$user_id = $_SESSION['user_id'];//invokes the starts session using the super global variable $_SESSION
$page = $_GET['page'] ?? 'home';//gets the page parameter from the URL and if it does not exist it is taken to home (default value)



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




$sql_ward = "SELECT
    WARD.ward_name,
    SUBCOUNTY.subcounty_name
FROM WARD
JOIN SUBCOUNTY
ON WARD.subcounty_id = SUBCOUNTY.subcounty_id";//sql string to be executed to retrieve the ward name from the table ward and subcounty from subcounty table
$result_ward = mysqli_query($conn, $sql_ward);//result ward is a user defined variable that runs the my_sli_querry which is a php function that


$sql_supervisor = "SELECT
    SUPERVISOR.fname,
    SUPERVISOR.lname,
    WARD.ward_name
FROM SUPERVISOR
JOIN WARD
ON SUPERVISOR.ward_id = WARD.ward_id";//sql string that is to be executed to retrive the first name of the supervisor the last name of the supervisor and joins to the ward to obtain the ward name of the supervisor  from the ward table
$result_supervisor = mysqli_query($conn, $sql_supervisor);//a php function that queries againist the database and executes the sql_supervisor


$sql_censusofficer = "SELECT
    CENSUS_OFFICER.censusofficer_id,
    CENSUS_OFFICER.fname,
    CENSUS_OFFICER.lname,
    WARD.ward_name
FROM CENSUS_OFFICER
JOIN SUPERVISOR
ON CENSUS_OFFICER.supervisor_id = SUPERVISOR.supervisor_id
JOIN WARD
ON SUPERVISOR.ward_id = WARD.ward_id";//sql string to be executed to retrieve /read the first and last name and the ward that they belong to
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
WHERE SUBCOUNTY.subcounty_name = '$subcounty_name'";
//households joins with census officer to know the officer who collected that data
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
//for each row in the table check if the condition is true ,if its true ,return all rows
//all person columns,--wardname from ward table,--subcounty from subcounty table,--connects person to their household(125)
//--connects household to the officer who collected the data,--connects the census officer to their supervisor,--connects the census officer to their supervisor
//--connects their supervisor to their wards,--connects ward to its ward


//code for the filter

$ward = $_GET['ward'] ?? '';//$_subcounty is assigned to $_get which is associate array that gets the url parameter for subcounty and if there it is not there i.e the url it defaults to empty
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
AND SUBCOUNTY.subcounty_name = '$subcounty_name'";  
//for each row in the table check if the condition is true ,if its true ,return all rows
//all person columns,--wardname from ward table,--subcounty from subcounty table,--connects person to their household(125)
//--connects household to the officer who collected the data,--connects the census officer to their supervisor,--connects the census officer to their supervisor
//--connects their supervisor to their wards,--connects ward to its ward


if($ward != ""){
    $sql_person_filter .= " AND WARD.ward_name='$ward'";
}//if $ward is not empty then add this sql condition to the user defined varibale sql_person_filter so that the querry will filter results to show records from ward


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
if($page == 'viewward') {

    $result_ward= mysqli_query($conn, $sql_ward);
}
if($page == 'viewsupervisor') {
    
    $result_supervisor = mysqli_query($conn, $sql_supervisor);
}
if($page == 'viewcensusofficer') {
   
    $result_censusofficer = mysqli_query($conn, $sql_censusofficer);
}
if($page == 'viewhousehold') {

    $result_household = mysqli_query($conn, $sql_household);
}
if($page == 'viewpeople') {   
  
    $result_person = mysqli_query($conn, $sql_person_filter);
}





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

    
    <div class="header">
        <h1>Deputy Commissioner Dashboard</h1>
        <p><?=$subcounty_name?> SubCounty</p>
    </div>

    
    <div class="cards">
        <div class="card">
            <h2><?= mysqli_num_rows($result_ward) ?></h2>
            <p>Wards</p>
            <a href="deputycommissionerreports.php?page=viewward">View All</a>
        </div>

        <div class="card">
            <h2><?= mysqli_num_rows($result_supervisor) ?></h2>
            <p>Supervisors</p>
            <a href="deputycommissionerreports.php?page=viewsupervisor">View All</a>
        </div>

        <div class="card">
            <h2><?= mysqli_num_rows($result_censusofficer) ?></h2>
            <p>Census Officers</p>
            <a href="deputycommissionerreports.php?page=viewcensusofficer">View All</a>
        </div>

        <div class="card">
            <h2><?= mysqli_num_rows($result_household) ?></h2>
            <p>Counted Households</p>
            <a href="deputycommissionerreports.php?page=viewhousehold">View All</a>
        </div>

        <div class="card">
            <h2><?= mysqli_num_rows($result_person) ?></h2>
            <p>People Counted</p>
            <a href="deputycommissionerreports.php?page=viewpeople">View All</a>
        </div>
    </div>

    
    <?php if($page == 'viewward'): ?>
        <div class="table-section">
            <h3>Wards List</h3>
            <table border="1">
                <thead>
                    <tr>
                        
                        <th>Ward Name</th>
                        <th>Subcounty Name</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result_ward) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_ward)): ?>
                            <tr>
        
                                <td><?= $row['ward_name'] ?></td>
                                <td><?= $row['subcounty_name']  ?></td>
                                
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No wards found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    
    <?php if($page == 'viewsupervisor'): ?>
        <div class="table-section">
            <h3>Supervisors List</h3>
            <table border="1">
                <thead>
                    <tr>
                        
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Ward Name</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result_supervisor) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_supervisor)): ?>
                            <tr>
                     
                                <td><?= $row['fname'] ?></td>
                                <td><?= $row['lname'] ?></td>
                                <td><?= $row['ward_name'] ?></td>
                               
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No supervisors found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    
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


        <select name="ward">
    <option value="">All Wards</option>
    <option value="Chania" <?= $ward == "Chania" ? "selected" : "" ?>>Chania</option>
    <option value="Mangu" <?= $ward == "Mangu" ? "selected" : "" ?>>Mangu</option>
    <option value="Kiamwangi" <?= $ward == "Kiamwangi" ? "selected" : "" ?>>Kiamwangi</option>
    <option value="Ngenda" <?= $ward == "Ngenda" ? "selected" : "" ?>>Ngenda</option>
    <option value="Witeithie" <?= $ward == "Witeithie" ? "selected" : "" ?>>Witeithie</option>
    <option value="Kalimoni" <?= $ward == "Kalimoni" ? "selected" : "" ?>>Kalimoni</option>
    <option value="Tigoni" <?= $ward == "Tigoni" ? "selected" : "" ?>>Tigoni</option>
    <option value="Ndeiya" <?= $ward == "Ndeiya" ? "selected" : "" ?>>Ndeiya</option>
    <option value="Karuri" <?= $ward == "Karuri" ? "selected" : "" ?>>Karuri</option>
    <option value="Kikuyu" <?= $ward == "Kikuyu" ? "selected" : "" ?>>Kikuyu</option>
        </select>

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
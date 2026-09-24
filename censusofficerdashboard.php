<?php
session_start();
include 'connect.php';


$user_id = $_SESSION['user_id'];
$page = $_GET['page'] ?? 'home';


$sql_officer="SELECT fname,lname FROM CENSUS_OFFICER WHERE user_id = '$user_id'";
$result_officer=mysqli_query($conn,$sql_officer);
$officer_row = mysqli_fetch_assoc($result_officer);
$officer_name = ($officer_row['fname'] ?? '') . ' ' . ($officer_row['lname'] ?? '');


$sql_ward="SELECT WARD.ward_name
FROM CENSUS_OFFICER
JOIN SUPERVISOR
ON CENSUS_OFFICER.supervisor_id = SUPERVISOR.supervisor_id
JOIN WARD
ON SUPERVISOR.ward_id = WARD.ward_id
WHERE CENSUS_OFFICER.user_id = '$user_id'";
$result_ward=mysqli_query($conn,$sql_ward);
$ward_row = mysqli_fetch_assoc($result_ward);
$ward_name = $ward_row['ward_name'] ?? 'ward';



$sql_household = "SELECT
    HOUSEHOLD.household_id,
    HOUSEHOLD.family_size,
    HOUSEHOLD.access_to_electricity,
    HOUSEHOLD.access_to_water,
     HOUSEHOLD.assets,
      HOUSEHOLD.residential_status,
    CONCAT( CENSUS_OFFICER.fname, ' ', CENSUS_OFFICER.lname) AS census_officer
FROM HOUSEHOLD
JOIN CENSUS_OFFICER
ON HOUSEHOLD.censusofficer_id = CENSUS_OFFICER.censusofficer_id
WHERE CENSUS_OFFICER.user_id = '$user_id'";
$result_household = mysqli_query($conn, $sql_household);

$sql_person = "
SELECT PERSON.*
FROM PERSON
JOIN HOUSEHOLD
ON PERSON.household_id = HOUSEHOLD.household_id
JOIN CENSUS_OFFICER
ON HOUSEHOLD.censusofficer_id = CENSUS_OFFICER.censusofficer_id
WHERE CENSUS_OFFICER.user_id = '$user_id'
";
$result_person = mysqli_query($conn, $sql_person);


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Census officer Dashboard</title>

<link rel="stylesheet" href="commissionerdashboard.css">
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">

    <div class="logo">
        <h2>Welcome</h2>
           <h3>Officer  <?=$officer_name?> </h3>
    </div>

    <ul class="menu">
      <li><a href="censusofficerdashboard.php">Dashboard</a></li>
      <li><a href="censusofficerdashboard.php?page=household">  Add household data </a></li>
       <li><a href="censusofficerdashboard.php?page=person">  Add Persons  </a></li>
       <li><a href="homepage.html">Logout</a></li>
      </ul>

</div>

<!-- Main Content -->
<div class="main">

    <?php
    if($page == 'home'){
    ?>
 
     <div class="header">
        <h1> Census Officer Dashboard</h1>
          <p><u><?=$ward_name?> Ward</u></p>
    </div>

    <h2>MY SUBMISSIONS</h2>
   
        <div class="table-section">
            <h3>Households List</h3>
            <table border="1">
                <thead>
                    <tr>
                          <th>Household Number </th>
                            <th>Family size</th>
                            <th>Access to electricity</th>
                            <th>Access to water</th>
                            <th>Assets</th>
                            <th>Residential status</th>
                            <th>Data Collected By</th>
                            <th>Action</th>
                         
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
                                    
                                <td>
                                    <a href="manage_data.php?id=<?= $row['household_id'] ?>"  class="action-btn btn-edit">Edit</a>
                                    <a href="manage_data.php?id=<?= $row['household_id'] ?>" class="action-btn btn-edit onclick="return confirm('Are you sure?') ">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No households Submitted</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    

   
        <div class="table-section">
            <h3>Persons Enumerated List</h3>
            <table border="1">
                <thead>
                    <tr>
                          <th>Household ID</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Marital status</th>
                            <th>Education</th>
                            <th>Religion</th>
                            <th>Occupation</th>
                            <th>Employment status</th>
                            <th>Tribe</th> 
                              <th>Action</th> 
                         
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result_person) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result_person)): ?>
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
                                <td>
                                   <a href="manage_person.php?action=edit_person&id=<?= $row['person_id'] ?>" class="action-btn btn-edit">Edit</a>
                                     <a href="manage_person.php?action=delete_person&id=<?= $row['person_id'] ?>" class="action-btn btn-delete" onclick="return confirm('Are you sure you want to delete this person?');">Delete </a>    
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11">No persons Submitted</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>


    <?php
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
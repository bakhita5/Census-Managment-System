<?php
session_start();//invokes the starts session using the super global variable $_SESSION
include 'connect.php';//database connection file(includes the database)

$user_id = $_SESSION['user_id'];//we assign user_id variable to retrieve or read data user_id from superglobal variable $_session
$page = $_GET['page'] ?? 'home';//gets the page parameter from the URL and if it does not exist it is taken to home (default value)

$sql_county="SELECT county_name FROM COUNTY";//sql string to get county_name from the county table
$result_county=mysqli_query($conn,$sql_county);//it contains the connection to the database and the sql string that is to be executed 
$county_row = mysqli_fetch_assoc($result_county);//mysqli_fetch_assoc is associative array that holds key value pairs for result_county
$county_name = $county_row['county_name'] ?? 'County';//it retrieves the name of the county from the array and if it does not exist it defaults to county/displays county


$sql_name="SELECT fname,lname FROM COMMISSIONER";//is an sql string that is to be executed to retrive the first name and last name from the commissioner's table-this querry is executed by result_name
$result_name=mysqli_query($conn,$sql_name);//it is a mysqli_function that is run againist the database and contains executed the sql string
$commissioner_row = mysqli_fetch_assoc($result_name);//mysqli_function is an associative array that contains the key values for result name
$commissioner_name = ($commissioner_row['fname'] ?? '') . ' ' . ($commissioner_row['lname'] ?? '');//commissioner_name is assigned to fetch the fname and last name from the commissioner_row array


$sql_subcounty = "SELECT * FROM SUBCOUNTY";//it a user defined sql that is assigned to an sql string that select all from the subcounty
$result_subcounty = mysqli_query($conn, $sql_subcounty);//it a php fuction that is run againist the database and contains the sql string

$sql_ward = "SELECT
    WARD.ward_name,
    SUBCOUNTY.subcounty_name
FROM WARD
JOIN SUBCOUNTY
ON WARD.subcounty_id = SUBCOUNTY.subcounty_id";//sql string to be executed to retrieve the ward name from the table ward and subcounty from subcounty table
$result_ward = mysqli_query($conn, $sql_ward);//result ward is a user defined variable that runs the my_sli_querry which is a php function that


$sql_deputycommissioner="SELECT
    DEPUTY_COMMISSIONER.deputy_commissioner_id,
    DEPUTY_COMMISSIONER.fname,
    DEPUTY_COMMISSIONER.lname,
    SUBCOUNTY.subcounty_name
FROM DEPUTY_COMMISSIONER
JOIN SUBCOUNTY
ON DEPUTY_COMMISSIONER.subcounty_id = SUBCOUNTY.subcounty_id;";//sql string to be executed for the first name and last name of the deputy commissioner and joins to subcounty table to show the subcounty they belong to
$result_deputycommissioner=mysqli_query($conn,$sql_deputycommissioner);//sql query a function that is run againist the database and contains the sql string for the deputy commissioner


$sql_supervisors = "SELECT
    SUPERVISOR.fname,
    SUPERVISOR.lname,
    WARD.ward_name
FROM SUPERVISOR
JOIN WARD
ON SUPERVISOR.ward_id = WARD.ward_id";//sql string that is to be executed to retrive the first name of the supervisor the last name of the supervisor and joins to the ward to obtain the ward name of the supervisor  from the ward table
$result_supervisor = mysqli_query($conn, $sql_supervisors);//a php function that queries againist the database and executes the sql_supervisor

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
    CONCAT( CENSUS_OFFICER.fname, ' ', CENSUS_OFFICER.lname) AS census_officer
FROM HOUSEHOLD
JOIN CENSUS_OFFICER
ON HOUSEHOLD.censusofficer_id = CENSUS_OFFICER.censusofficer_id;";//households joins with census officer to know the officer who collected that data
$result_household = mysqli_query($conn, $sql_household);

$sql_person = "SELECT * FROM PERSON";//sql string that is to be exected to get all the people from the database
$result_person = mysqli_query($conn, $sql_person);

if ($page == 'viewsubcounty') {
    $result_subcounty = mysqli_query($conn, $sql_subcounty);// If the page is equal to viewsubcounty, then the $result_subcounty query will be executed against the database, and the $sql_subcounty string will be run
} 

 else if ($page == 'viewward') {
    $result_ward= mysqli_query($conn, $sql_ward); 
} 

 else if ($page == 'viewdeputycommissioner') {
   
    $result_deputycommissioner= mysqli_query($conn, $sql_deputycommissioner);
} 

else if ($page == 'viewsupervisor') {
   
    $result_supervisor= mysqli_query($conn, $sql_supervisors);
} 

 else if ($page == 'viewcensusofficer') {
    $result_censusofficer = mysqli_query($conn, $sql_censusofficer);
}

 else if ($page == 'viewhousehold') {
    $result_household = mysqli_query($conn, $sql_household);
} 
else if ($page == 'viewpeople') {
    $result_person= mysqli_query($conn, $sql_person);
}




//code for the filter
$subcounty = $_GET['subcounty'] ?? '';//$_subcounty is assigned to $_get which is associate array that gets the url parameter for subcounty and if there it is not there i.e the url it defaults to empty
$ward = $_GET['ward'] ?? '';
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
WHERE 1=1";//for each row in the table check if the condition is true ,if its true ,return all rows
//all person columns,--wardname from ward table,--subcounty from subcounty table,--connects person to their household(125)
//--connects household to the officer who collected the data,--connects the census officer to their supervisor,--connects the census officer to their supervisor
//--connects their supervisor to their wards,--connects ward to its ward



if($subcounty != ""){
    $sql_person_filter .= " AND SUBCOUNTY.subcounty_name='$subcounty'";
}//if $subcounty is not empty then add this sql condition to the user defined varibale sql_person_filter so that the querry will filter results to show records from that subcounty

 if($ward != ""){
    $sql_person_filter .= " AND WARD.ward_name='$ward'";
}

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

//the difference between if and if else if only one option can be chosen and if multiple querries can be combined

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
            <p>Commissioner <?= $commissioner_name ?> </p>
        </div>

        <ul class="menu">
            <li><a href="commissionerdashboard.php">Dashboard</a></li>
            <li><a href="commissionerdashboard.php?page=subcounty">Add Subcounties</a></li>
            <li><a href="commissionerdashboard.php?page=ward">Add Wards</a></li>
            <li><a href="commissionerdashboard.php?page=deputycommissioner">Add Deputies</a></li>
            <li><a href="commissionerdashboard.php?page=supervisor">Add Supervisors</a></li>
            <li><a href="commissionerdashboard.php?page=censusofficer">Add Census Officers</a></li>
            <li><a href="homepage.html">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main">
        <?php if ($page == 'home' || $page == 'viewsubcounty' || $page == 'viewward' ||    $page == 'viewdeputycommissioner' || $page == 'viewsupervisor' || $page == 'viewcensusofficer' || $page == 'viewhousehold' || $page == 'viewpeople'): ?>
            <div class="header">
                <h1>Commissioner Dashboard</h1>
                <p><?=$county_name?> County</p>
            </div>

            <!-- Dashboard Cards -->
            <div class="cards">
                <div class="card">
                    <h2><?= mysqli_num_rows($result_subcounty) ?></h2>
                    <p>Subcounties</p>
                    <a href="commissionerreports.php?page=viewsubcounty">View All</a>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_ward) ?></h2>
                    <p>Wards</p>
                    <a href="commissionerreports.php?page=viewward">View All</a>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_deputycommissioner) ?></h2>
                    <p>Deputy Commissioners</p>
                     <a href="commissionerreports.php?page=viewdeputycommissioner">View All</a>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_supervisor) ?></h2>
                    <p>Supervisors</p>
                    <a href="commissionerreports.php?page=viewsupervisor">View All</a>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_censusofficer) ?></h2>
                    <p>Census Officers</p>
                    <a href="commissionerreports.php?page=viewcensusofficer">View All</a>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_household) ?></h2>
                    <p>Counted Households</p>
                    <a href="commissionerreports.php?page=viewhousehold">View All</a>
                </div>

                <div class="card">
                    <h2><?= mysqli_num_rows($result_person) ?></h2>
                    <p>People counted</p>
                    <a href="commissionerreports.php?page=viewpeople">View All</a>
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

        <?php if ($page == 'viewsubcounty'): ?>
            <div class="table-section">
                <h3>Subcounties List</h3>
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subcounty Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_subcounty) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_subcounty)): ?>
                                <tr>
                                    <td><?= $row['subcounty_id'] ?></td>
                                    <td><?= $row['subcounty_name'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No subcounties found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($page == 'viewward'): ?>
            <div class="table-section">
                <h3>Ward List</h3>
                <table border="1">
                    <thead>
                        <tr>
                            
                            <th>Ward Name</th>
                              <th>Subcounty Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_ward) > 0): ?>  
                            <?php while ($row = mysqli_fetch_assoc($result_ward)): ?> 
                                <tr>
                            
                                    <td><?= $row['ward_name'] ?></td>
                                    <td><?= $row['subcounty_name'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2">No Ward found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

           <?php if ($page == 'viewdeputycommissioner'): ?>
            <div class="table-section">
                <h3>Deputy Commissioner List</h3>
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Subcounty Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_deputycommissioner) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_deputycommissioner)): ?>
                                <tr>
                                    <td><?= $row['deputy_commissioner_id'] ?></td>
                                    <td><?= $row['fname'] ?></td>
                                    <td><?= $row['lname'] ?></td>
                                    <td><?= $row['subcounty_name'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No Deputy Commissioner found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($page == 'viewsupervisor'): ?>
            <div class="table-section">
                <h3>Supervisor List</h3>
                <table border="1">
                    <thead>
                        <tr>
                     
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Ward name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_supervisor) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_supervisor)): ?>
                                <tr>
                                  
                                    <td><?= $row['fname'] ?></td>
                                    <td><?= $row['lname'] ?></td>
                                    <td><?= $row['ward_name'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No supervisor found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($page == 'viewcensusofficer'): ?>
            <div class="table-section">
                <h3>Census Officer List</h3>
                <table border="1">
                    <thead>
                        <tr>
                            
                            <th>First name</th>
                            <th>Last name</th>
                            <th>Ward Assigned to</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_censusofficer) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_censusofficer)): ?>
                                <tr>
                                    
                                    <td><?= $row['fname'] ?></td>
                                    <td><?= $row['lname'] ?></td>
                                      <td><?= $row['ward_name'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No Census officer found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php if ($page == 'viewhousehold'): ?>
            <div class="table-section">
                <h3>Household List</h3>
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
                         
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result_household) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result_household)): ?>
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
                                <td colspan="8">No Household found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>


<?php if ($page == 'viewpeople'): ?>
<div class="table-section">
    <h3>Person List</h3>

    <!--filter container-->
    <div class="filter-container">
     <form method="GET" class="filter-form" >
      <input type="hidden" name="page" value="viewpeople">

        <select name="subcounty" >
    <option value="">All Subcounties</option>
    <option value="Gatundu North" <?= $subcounty == "Gatundu North" ? "selected" : "" ?>>Gatundu North</option>
    <option value="Gatundu South" <?= $subcounty == "Gatundu South" ? "selected" : "" ?>>Gatundu South</option>
    <option value="Juja" <?= $subcounty == "Juja" ? "selected" : "" ?>>Juja</option>
    <option value="Limuru" <?= $subcounty == "Limuru" ? "selected" : "" ?>>Limuru</option>
    <option value="Kiambaa" <?= $subcounty == "Kiambaa" ? "selected" : "" ?>>Kiambaa</option>
    <option value="Ruiru" <?= $subcounty == "Ruiru" ? "selected" : "" ?>>Ruiru</option>
    <option value="Githunguri" <?= $subcounty == "Githunguri" ? "selected" : "" ?>>Githunguri</option>
    <option value="Kabete" <?= $subcounty == "Kabete" ? "selected" : "" ?>>Kabete</option>
    <option value="Kikuyu" <?= $subcounty == "Kikuyu" ? "selected" : "" ?>>Kikuyu</option>
    <option value="Lari" <?= $subcounty == "Lari" ? "selected" : "" ?>>Lari</option>

     </select>

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
                <th>Marital status</th>
                <th>Education</th>
                <th>Religion</th>
                <th>Occupation</th>
                <th>Employment status</th>
                <th>Tribe</th>
            </tr>
        </thead>

        <tbody>
            <?php if (mysqli_num_rows($result_person_filter) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result_person_filter)): ?>
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
                    <td colspan="9">No People found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
    </div>
</body>
</html>
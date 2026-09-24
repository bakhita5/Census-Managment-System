<?php
session_start();//it invokes the start of a session using the superglobal variable $_session.
include 'connect.php';
 
if (isset($_POST['login'])) { // if isset is true checks if the associative array $_post login button has been clicked.
//harvest the array from login.html
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);


    //sql string that is to be executed and check from the users table a match from the database(users table) an only limits it to one result(at most one result)
    //preparing sql statement that will be executed-executed by mysqli_query
    $sql="SELECT user_id,name,username,password,role FROM users where username='$username' AND password='$password'LIMIT 1";
    $result = mysqli_query($conn, $sql);//mysqli_query is a function that performs a query againist the database.
    

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
//$row is an associative array that holds the result set values 
        $row = mysqli_fetch_assoc($result);//fetch data from database-my sli_fetch_assoc is an php function that is used to fetch one row of data from the data base as an associative array

        // if (password_verify($password, $row['password'])) {//password verify checks that a password matches a hash

        
        //setting session variables
        $_SESSION['user_id'] = $row['user_id'];//takes user_id from the database and stores it to $_session
        $_SESSION['username'] = $row['username'];
        $role= strtolower($row['role']);//row gets the role value from the array 
        
       if ($role == "commissioner") {
            header("Location: commissionerdashboard.php");
        }

        else if ($role == "deputy commissioner") {
            header("Location: deputycommissionerdashboard.php");
        }

        else if ($role == "supervisor") {
            header("Location: supervisordashboard.php");
        }

        else if ($role == "census officer") {
            header("Location: censusofficerdashboard.php");
        }

        else {
            echo "execution failed";
        }

        exit();//stops the execution of the below statements 

    } else {
        
        echo "Invalid username or password";
          
    }
}
//}
?>
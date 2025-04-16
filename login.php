<?php
session_start();
if (isset($_SESSION["email"])) {
    session_destroy();
}
include_once 'dbConnection.php';
$ref = @$_GET['q'];
$email = $_POST['email'];
$password = $_POST['password'];

// Sanitize input to prevent SQL injection
$email = stripslashes($email);
$email = addslashes($email);
$password = stripslashes($password);
$password = addslashes($password);
$password = md5($password); // Hash the password

// Check if the user is disabled
$query = "SELECT name, status FROM user WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($con, $query) or die('Error');
$count = mysqli_num_rows($result);

if ($count == 1) {
    $row = mysqli_fetch_array($result);
    $name = $row['name'];
    $status = $row['status'];

    if ($status == 1) { // Check if the user is enabled
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;
        header("location:account.php?q=1");
    } else {
        header("location:$ref?w=Your account has been disabled. Please contact support.");
    }
} else {
    header("location:$ref?w=Wrong Username or Password");
}
?>
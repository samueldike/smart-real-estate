<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;
session_start();

    
    $adminId = $_SESSION['admin'];
    $password = md5(sha1(md5($class->purify($_POST['password']))));
    
        $query = "SELECT * FROM admins WHERE id = '$adminId' AND password='$password'";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $row = mysqli_num_rows($result);
        if($row > 0){
           echo "Success";
        }
        else{
            echo "Failure";

        }

?>
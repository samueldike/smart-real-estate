<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;
session_start();

	$adminId =  $class->purify($_POST['adminId']);
    $password =  md5(sha1(md5($class->purify($_POST['password']))));
    if ($class->lengthify_password($_POST['password']) == false) {
        echo "Password length must be between 8 and 11";
    }elseif(mysqli_query($con, "UPDATE admins SET password = '$password' WHERE id= '$adminId'")){
            echo "Success";
    }else{
        echo "Error changing your password. Please try again later.";

    }

?>
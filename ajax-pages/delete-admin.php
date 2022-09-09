<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

    $adminId =  $class->purify($_POST['adminId']);

    if(mysqli_query($con, "DELETE FROM admins  WHERE id= '$adminId'")){
            echo "Success";
    }else{
        echo "Error deleting admin";

    }

?>
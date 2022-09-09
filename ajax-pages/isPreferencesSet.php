<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;
session_start();
   
if (!isset($_SESSION['user'])) {
	echo "Not Logged In";
}else{
	$myId = $_SESSION['user'];
	$query = "SELECT * FROM preferences WHERE user_id = '$myId'";
    $result = $con->query($query);
    $row = $result->fetch_assoc();
    $num = $result->num_rows;
    if($num == 0){
       echo "No";
    }else{
        echo "Yes";
    }
}
?>
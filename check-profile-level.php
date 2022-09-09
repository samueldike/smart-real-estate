<?php
session_start();
if (isset($_SESSION['user'])) {
   $agent_id = $_SESSION['user'];
}
include('class.php');
$class = new main();
$class->db_connect();

$ratio = $class->profileCompletionRatio();
$part = explode("|", $ratio);
$complete = $part[0];
$incomplete = $part[1];

if($complete >= 66.666666666666666666666666666667){
    //Profile is Good to go!
    echo "submit-property.php";
}else{
    //Profile is not good to go. Derirect to build profile
    echo "build-profile.php";
}

?>
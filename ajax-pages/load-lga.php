<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

if($_POST['state_id'] != ''){
    $state_id = $class->purify($_POST['state_id']);
    $gu = mysqli_query($con, "SELECT * FROM locals WHERE state_id = '$state_id'");
    if ($gu == true) {
        while ($r = $gu->fetch_assoc()) {
            echo $r['local_name'];
        }
    }else{
        echo "Failure";
    }
    

}else{
        echo "Failure";
}

?>
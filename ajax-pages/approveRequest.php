<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;\
session_start();
$myId = $_SESSION['user'];

if($_POST['id'] != ''){
    $id = $class->purify($_POST['id']);
    $gu = mysqli_query($con, "UPDATE real_users SET pref_to = '$id', m_status = 'married' WHERE id = '$myId'");
    $gu1 = mysqli_query($con, "UPDATE real_users SET pref_by = '$myId' , m_status = 'married' WHERE id = '$id'");
    if ($gu == true AND $gu1 == true) {
        echo "Success";
    }
}

?>
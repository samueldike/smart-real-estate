<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;\
session_start();
$myId = $_SESSION['user'];

if($_POST['user_id'] != ''){
    $user_id = $class->purify($_POST['user_id']);
    $type = $class->purify($_POST['type']);
    //Disapprove
    $gu = mysqli_query($con, "INSERT INTO disapprove(myId,user_id,type,date_disapproved) VALUES ('$myId','$user_id','$type',NOW())");
    if ($type == 'Permanent') {
    	//Delete all Temporary Disapprovals
    	$con->query("DELETE FROM disapprove WHERE myId = '$myId' AND user_id = '$user_id' AND type = 'Temporary'");
    }
    if ($type == 'Temporary') {
    	//Delete all Permanent Disapprovals
    	$con->query("DELETE FROM disapprove WHERE myId = '$myId' AND user_id = '$user_id' AND type = 'Permanent'");
    }
    //Disengage user
    $mydis = $class->getAgentDetailsById($myId);
    $myPrefBy = $mydis['pref_by'];

    $userdis = $class->getAgentDetailsById($user_id);
    $userPrefTo = $userdis['pref_to'];

    $Mydis = $class->getAgentDetailsById($myId);
    $MyPrefTo = $Mydis['pref_to'];

    if ($myPrefBy == $user_id) {
    	//This User is still engaged to me
    	//Disenage
        if ($MyPrefTo == $user_id) {
            $gu = mysqli_query($con, "UPDATE real_users SET pref_by = '' , m_status = 'free', pref_rank = '' WHERE id = '$myId'");
        }
        if ($myPrefBy == $user_id) {
            $gu = mysqli_query($con, "UPDATE real_users SET pref_by = '' , m_status = 'free', pref_rank = '' WHERE id = '$myId'");
        }

    	
    }

    if ($userPrefTo == $myId) {
    	//I am still engaged to this user
    	//Disenage
    	$gu1 = mysqli_query($con, "UPDATE real_users SET pref_to = '' , m_status = 'free', pref_rank = '' WHERE id = '$user_id'") or die(mysqli_error($con));
    }
    //Clear all associative Our_Pref_Rank Data
    $con->query("DELETE FROM our_pref_rank WHERE userId = '$myId' AND myId = '$user_id'");

    if ($gu == true OR $gu1 == true) {
        echo "Success";
    }
}

?>
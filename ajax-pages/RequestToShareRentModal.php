<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

if($_POST['id'] != ''){
    $id = $class->purify($_POST['id']);
    $gu = mysqli_query($con, "SELECT * FROM real_users WHERE id = '$id'");
    if ($gu == true) {
        while ($r = $gu->fetch_assoc()) {
           echo "<div >
           		<div class='col-sm-5' style='padding:0px;padding-bottom:10px'>
           			<img src='user-pics/".$id.".jpg' style='width:98%'>
           		</div>
           		<div class='col-sm-7' style='padding:0px;padding-bottom:10px'>
           			<span class='col-sm-8' style='padding:0px'><b>Name: </b>".$r['firstname']." ".$r['lastname']."</span>
           			<span class='col-sm-4' style='padding:0px'><b>Sex: </b>".$r['sex']."</span>
           			<h5 class='my_underline'>PREFERENCES</h5><br>
           			";
           			$rtvd = $con->query("SELECT preference FROM preferences WHERE user_id = '$id'");
           			while ($rpref = $rtvd->fetch_assoc()) {
           				echo "<span style='border:1px solid #E6E6E6;padding:2px;margin-right:2px;'>".$rpref['preference']."</span>";
           			}
           	echo "
           		<div class='btn btn-default' id='approveBtn' style='width:100%;border-radius:5px;color:white' onClick=approveRequest('".$id."')>Approve to Share Rent with ".$r['firstname']." ".$r['lastname']."</div>	
           		<span class='btn btn-sm btn-success pull-right' id='tempDisapproveBtn' style='width:50%;border-radius:5px;color:green' onClick=disapprove('".$id."','Temporary','tempDisapproveBtn')>Dispprove Temporarily</span>
           		<span class='btn btn-sm btn-success pull-right' id='permDisapproveBtn' style='width:50%;border-radius:5px;color:red' onClick=promptPermdisapprove('".$id."','Permanent','permDisapproveBtn')>Dispprove Permanently</span>
           		</div>
           </div>";
        }
    }
}

?>
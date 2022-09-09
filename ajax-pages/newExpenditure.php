<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;
session_start();
$branch_id = $_SESSION['admin'];


if($_POST['amount'] == ''){
    echo "Amount cannot be empty.";
}elseif(!is_numeric($_POST['amount'])){
    echo "Amount must be digits only";
}elseif($_POST['purpose'] == ''){
    echo "Expenditure Purpose cannot be empty.";
}elseif($_POST['date_removed'] == ''){
    echo "Select Expenditure Date.";
}else{
    $purpose = $class->purify($_POST['purpose']);
    $amount = $class->purify($_POST['amount']);
    $date_removed = $class->purify($_POST['date_removed']);
    
        $query = mysqli_query($con, "INSERT INTO expenditure (amount,purpose,branch_id,date_removed) VALUES('$amount','$purpose','$branch_id','$date_removed')") or die(mysqli_error($con));
        if($query == true){
            echo "Success";
        }
        else{
            echo "Error submiting your new expenditure. Please try again later.";

        }


}

?>

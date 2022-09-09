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
}elseif($_POST['income_source'] == ''){
    echo "Source of Income cannot be empty.";
}elseif($_POST['date_received'] == ''){
    echo "Select Income Date";
}else{
    $income_source = $class->purify($_POST['income_source']);
    $amount = $class->purify($_POST['amount']);
    $date_received = $class->purify($_POST['date_received']);
    
        $query = mysqli_query($con, "INSERT INTO income (amount,source,branch_id,date_received) VALUES('$amount','$income_source','$branch_id','$date_received')") or die(mysqli_error($con));
        if($query == true){
            echo "Success";
        }
        else{
            echo "Error submiting your new income. Please try again later.";

        }


}

?>

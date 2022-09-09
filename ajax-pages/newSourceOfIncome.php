<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;
session_start();
$branch_id = $_SESSION['admin'];

$source = ucfirst(strtolower($class->purify($_POST['source'])));
//CHECK IF SOURCE OF INCOME EXIST
$src = $con->query("SELECT * FROM source_of_income WHERE source = '$source' AND branch_id = '$branch_id'");

if($_POST['source'] == ''){
    echo "Source of Income cannot be empty.";
}elseif($src->num_rows > 0){
    echo "Source of Income already exist.";
}else{
        $query = mysqli_query($con, "INSERT INTO source_of_income (source,branch_id,date_added) VALUES('$source','$branch_id',NOW())") or die(mysqli_error($con));
        if($query == true){
            echo "Success";
        }
        else{
            echo "Error adding new Source of Income. Please try again later.";

        }


}

?>

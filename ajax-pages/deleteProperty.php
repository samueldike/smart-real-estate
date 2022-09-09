<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

    $property_id =  $class->purify($_POST['property_id']);
    $gyh = $con->query("SELECT * FROM real_properties WHERE id = '$property_id'");
    $rghy = $gyh->fetch_assoc();
    $slug = $rghy['slug'];
    $img_1 = $rghy['img_1'];
    $img_2 = $rghy['img_2'];
    $img_3 = $rghy['img_3'];
    $img_4 = $rghy['img_4'];
    $img_5 = $rghy['img_5'];
    //DELETE ALL PROPERTY IMAGE(S)
    if (file_exists("../property-images/".$img_1.".jpg")) {
    	unlink("../property-images/".$img_1.".jpg");
    }
    if (file_exists("../property-images/".$img_2.".jpg")) {
    	unlink("../property-images/".$img_2.".jpg");
    }
    if (file_exists("../property-images/".$img_3.".jpg")) {
    	unlink("../property-images/".$img_3.".jpg");
    }
    if (file_exists("../property-images/".$img_4.".jpg")) {
    	unlink("../property-images/".$img_4.".jpg");
    }
    if (file_exists("../property-images/".$img_5.".jpg")) {
    	unlink("../property-images/".$img_5.".jpg");
    }
    $del = mysqli_query($con, "DELETE FROM real_properties  WHERE id= '$property_id'");
    if($del == true){
            echo "Success";
    }else{
        echo "Error deleting Property. Please try again later";

    }

?>
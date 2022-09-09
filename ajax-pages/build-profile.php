<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;
session_start();
$myId = $_SESSION['user'];
if($_POST['firstname'] == ''){
    echo "First Name cannot be empty.";
}elseif($_POST['lastname'] == ''){
    echo "Last Name cannot be empty.";
}elseif($_POST['phoneNo'] == ''){
    echo "Phone Number cannot be empty.";
}elseif($_POST['address'] == ''){
    echo "Address cannot be empty.";
}elseif($_POST['bio'] == ''){
    echo "Bio cannot be empty.";
}else{
    $firstname = $class->purify($_POST['firstname']);
    $lastname = $class->purify($_POST['lastname']);
    $phoneNo = $class->purify($_POST['phoneNo']);
    $address = $class->purify($_POST['address']);
    $bio = $class->purify($_POST['bio']);
    $facebook = $class->purify($_POST['facebook']);
    $twitter = $class->purify($_POST['twitter']);
    $website = $class->purify($_POST['website']);

    if (move_uploaded_file($_FILES['images']['tmp_name'], 'user-pics/'.$myId.".jpg")) {
         //UPDATE
        $query = mysqli_query($con, "UPDATE real_users SET firstname='$firstname',lastname='$lastname',address='$address',phoneNo='$phoneNo',address='$address',bio='$bio',facebook='facebook',twitter='$twitter',website='$website' WHERE id = '$myId'");
        if($query == true){
            echo "Success";
        }
        else{
            echo "Profile Building Error. Please try again later.";

        }
    }
       

}

?>

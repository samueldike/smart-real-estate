<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;
session_start();
if($_POST['email'] == ''){
    echo "Email cannot be empty.";
}elseif($_POST['password'] == ''){
    echo  "Password cannot be empty.";
}else{
    $email = $class->purify($_POST['email']);
    $password = md5(sha1(md5($class->purify($_POST['password']))));
    $query = "SELECT * FROM real_users WHERE email = '$email' AND password='$password'";
    $result = mysqli_query($con, $query);
    $row = $result->fetch_assoc();
    $num = $result->num_rows;
    if($num > 0){
        
        $_SESSION['user'] = $row['id']; 
        echo "Success";
    }
    else{
        echo "Login details incorrect.";

    }
}

?>
<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

if($_POST['name'] == ''){
    echo "Name cannot be empty.";
}elseif($_POST['email'] == ''){
    echo "Email cannot be empty.";
}elseif($_POST['password'] == ''){
    echo "Password cannot be empty.";
}elseif($class->lengthify_password($_POST['password']) == false){
    echo  "Password length must be between 8 and 11";
}else{
    $name = $class->purify($_POST['name']);
    $email = $class->purify($_POST['email']);
    $password = md5(sha1(md5($class->purify($_POST['password']))));

    //CHECK IF EMAIL ALREADY EXIST
    $gu = mysqli_query($con, "SELECT email FROM real_users WHERE email='$email'");
    
    if (mysqli_num_rows($gu)>0) {
        echo "Email Already Exist";
    }else{
        $query = mysqli_query($con, "INSERT INTO real_users(username,email,password,date_registered) VALUES('$name','$email','$password',NOW())");
        if($query == true){
            echo "Success";
        }
        else{
            echo "Registeration Error. Please try again later.";

        }
    }

}

?>
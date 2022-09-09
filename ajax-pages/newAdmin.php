<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

if($_POST['full_name'] == ''){
    echo "Full Name cannot be empty.";
}elseif($_POST['email'] == ''){
    echo "Email cannot be empty.";
}elseif($_POST['phoneNo'] == ''){
    echo "Phone Number cannot be empty.";
}elseif($_POST['password'] == ''){
    echo "Password cannot be empty.";
}elseif($_POST['sex'] == ''){
    echo  "Sex cannot be empty";
}elseif($_POST['dob'] == ''){
    echo  "Date of Birth cannot be empty";
}elseif($_POST['address'] == ''){
    echo  "Address cannot be empty";
}elseif($_POST['admin_role'] == ''){
    echo  "Admin Role cannot be empty";
}elseif($class->lengthify_password($_POST['password']) == false){
    echo  "Password length must be between 8 and 11";
}else{
    $email = $class->purify($_POST['email']);
    $phoneNo = $class->purify($_POST['phoneNo']);
    $full_name = $class->purify($_POST['full_name']);
    $sex = $class->purify($_POST['sex']);
    $dob = $class->purify($_POST['dob']);
    $admin_role = $class->purify($_POST['admin_role']);
    $address = $class->purify($_POST['address']);
    $password = md5(sha1(md5($class->purify($_POST['password']))));

    //CHECK IF EMAIL ALREADY EXIST
    $gu = mysqli_query($con, "SELECT email FROM admins WHERE email='$email'");
    if (mysqli_num_rows($gu)>0) {
        echo "Email Already Exist";
    }else{
        $query = mysqli_query($con, "INSERT INTO admins(name,email,password,phoneNo,address,sex,dob,admin_role,date_registered) VALUES('$full_name','$email','$password','$phoneNo','$address','$sex','$dob','$admin_role',NOW())");
        if($query == true){
            echo "Success";
        }
        else{
            echo "Error creating admin account. Please try again later.";

        }
    }

}

?>
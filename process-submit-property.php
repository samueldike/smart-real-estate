<?php
session_start();
$_SESSION['user'] = "1";
$agent_id = $_SESSION['user'];
include('class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;
$error_message = '';
$success_message = '';
echo $_POST['propertyname'];
if (isset($_POST['propertyname'])) {
    //Process Property Submition form
    $propertyprice = $class->purify($_POST['propertyprice']);
    $propertyname = $class->purify($_POST['propertyname']);
    $phone = $class->purify($_POST['phone']);
    $description = $class->purify($_POST['description']);
    $type = $class->purify($_POST['type']);
    $state = $class->purify($_POST['state']);
    $city = $class->purify($_POST['city']);
    $address = $class->purify($_POST['address']);
    $quality = $class->purify($_POST['quality']);
    $built_in = $class->purify($_POST['built_in']);
    $bedrooms = $class->purify($_POST['bedrooms']);
    $car_garages = $class->purify($_POST['car_garages']);
    $bathrooms = $class->purify($_POST['bathrooms']);
    $toilets = $class->purify($_POST['toilets']);
    $story_building = $class->purify($_POST['story_building']);
    $swimming_pool = $class->purify($_POST['swimming_pool']);
    $tnc = $class->purify($_POST['tnc']);
    echo $propertyname;
    $e = '';
    if ($propertyname == '') {
        $e = $e+1;
        $e1 = "<li>Property Name is required in Step 1</li>";
    }else{
        $e1 = '';
    }

    if ($propertyprice == '') {
        $e = $e+1;
        $e2 = "<li>Property Price is required in Step 1</li>";   
    }else{
        $e2 = '';
    }

    if ($phone == '') {
        $e = $e+1;
        $e3 = "<li>Seller Phone Number is required in Step 1</li>";
    }else{
        $e3 = '';
    }

    if ($description == '') {
        $e = $e+1;
        $e4 = "<li>Property Description is required i Step 2</li>";
    }else{
        $e4 = '';
    }

    if ($type == '') {
        $e = $e+1;
        $e5 = "<li>Property Type is required in Step 2</li>";
    }else{
        $e5 = '';
    }

    if ($state == '') {
        $e = $e+1;
        $e6 = "<li>Property State is required in Step 2</li>";
    }else{
        $e6 = '';
    }

    if ($city == '') {
        $e = $e+1;
        $e7 = "<li>Property City is required in Step 2</li>";
    }else{
        $e7 = '';
    }

    if ($address == '') {
        $e = $e+1;
        $e8 = "<li>Property Address is required in Step 2</li>";
    }else{
        $e8 = '';
    }

    if ($quality == '') {
        $e = $e+1;
        $e9 = "<li>Property Quality is required in Step 2</li>";
    }else{
        $e9 = '';
    }

    if ($built_in == '') {
        $e = $e+1;
        $e10 = "<li>The property was built is required in Step 2</li>";
    }else{
        $e10 = '';
    }

    if ($bedrooms == '') {
        $e = $e+1;
        $e11 = "<li>Number of property bedroom is required in Step 2</li>";
    }else{
        $e11 = '';
    }

    if ($car_garages == '') {
        $e = $e+1;
        $e12 = "<li>Number of property Car Garage is required in Step 2</li>";
    }else{
        $e12 = '';
    }

    if ($bathrooms == '') {
        $e = $e+1;
        $e13 = "<li>Number of property Bathroom is required in Step 2</li>";
    }else{
        $e13 = '';
    }

    if ($toilets == '') {
        $e = $e+1;
        $e14 = "<li>Number of property toilet is required in Step 2</li>";
    }else{
        $e14 = '';
    }

    if ($story_building == '') {
        $e = $e+1;
        $e15 = "<li>Number of property story Building is required in Step 2, if none select Not Story building</li>";
    }else{
        $e15 = '';
    }

    if ($tnc == "") {
        $e = $e+1;
        $e16 = "<li>You must accept the Terms and Conditions to proceed.</li>";
    }else{
        $e16 = '';
    }


    if ($e != '') {
        $error_message = "<h4 style='margin-left:20px;color:rgb(173, 28, 28)'><span class='fa fa-warning'></span>Check the following Errors:</h4> <ul style='color:#F00'>".$e1.$e2.$e3.$e4.$e5.$e6.$e7.$e8.$e9.$e10.$e11.$e12.$e13.$e14.$e15.$e16."</ul>";
    }else{
        echo "True";
        //Specify property image directory
        $image_file_dir = "property-images/";
        //Specify property video directory
        $video_file_dir = "property-videos/";
        //Generate a file name with slug
        $file_name = $class->slugify($propertyname)."-".date("s-m-h-d-m-Y");
        $uploaded_vid = array();
        foreach ($_FILES['file'] as $key => $value) {
            if (count($_FILES['file']) == 0) {
                //No file selected for Images or Video
                $er = true;
                $error_message = "<div class='alert alert-warning'> No file selected for property images or video</div>";
            }else{
                //PROCEED TO PROCCESS UPLOAD
                //PROCESS IMAGES
                if ($_FILES['file']['type'][$key] == 'image/jpeg' || $_FILES['file']['type'][$key] == 'image/jpg' || $_FILES['file']['type'][$key] == 'image/png' || $_FILES['file']['type'][$key] == 'image/gif') {
                    //Specify an image's unique name using the file $key
                    $image_file_destination = $image_file_dir.$file_name."-".$key.".jpg";
                    //Do upload
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $image_file_destination)) {
                        //Define image file name as the name.
                        $k_plus = $key+1;
                        "img_".$k_plus = $image_file_destination;
                    }else{
                        //Define image file name as nothing, because upload failed
                        $k_plus = $key+1;
                        "img_".$k_plus = '';
                    }
                //PROCCESS VIDEO
                }else if ($_FILES['file']['type'][$key] == 'video/mp4' || $_FILES['file']['type'][$key] == 'video/mpeg' || $_FILES['file']['type'][$key] == 'video/mpg' || $_FILES['file']['type'][$key] == 'video/avi') {
                   //Specify an video's unique name using the file $key
                    $video_file_destination = $video_file_dir.$file_name."-".$key.".mp4";
                    //Do upload
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$key], $video_file_destination)) {
                        //Define video file name as the name.
                        $k_plus = $key+1;
                        "vid_".$k_plus = $video_file_destination;
                        array_push($uploaded_vid, "vid_".$k_plus);
                    }else{
                        //Define video file name as nothing, because upload failed
                        $k_plus = $key+1;
                        "vid_".$k_plus = '';
                    }
                }else{
                    //invalid file formats for images and videos
                    $error_message = "<div class='alert alert-warning'>Invalid Image or Video formats.</div>";
                }
            }
        }
        //Check if at least one image was uploaded, because it is compulsory.
        if ("img_1" == '') {
            //No image was selected
            
            //Check if any video was uploaded
            if (count($uploaded_vid) > 0) {
                //Video uploaded, Delete all ploaded videos
                //Loop through video upload array to locate uploaded video(s)
                for ($i=1; $i <= count($uploaded_vid); $i++) { 
                    if (file_exists($uploaded_vid[$i])) {
                        unset($uploaded_vid[$i]);
                    }
                }
            }
            //Display Error Message
            $error_message = "<div class='alert alert-warning'>You must select at least one property image.</div>";

        }else if ($er != true) {
            //At least one of image or video was selected and uploaded
            //Do INSERT ALL FORM DATA AND IMAGE/VIDEO FILE PATH TO DATABASE
            $query = $con->query("INSERT INTO real_properties (propertyname,propertyprice,phone,description,type,state,city,address,quality,built_in,bedrooms,car_garages,bathrooms,toilets,story_building,swimming_pool,img_1,img_2,img_3,img_4,img_5,img_6,img_7,img_8,img_9,img_10,vid_1,agent_id,date_uploaded) VALUES ('$propertyname','$propertyprice','$phone','$description','$type
                ','$state','$city','$address','$quality','$built_in','$bedrooms','$car_garages','$bathrooms','$toilets','$story_building','$swimming_pool','$img_1','$img_2','$img_3','$img_4','$img_5','$img_6','$img_7','$img_8','$img_9','$img_10','$vid_1','$agent_id',NOW())");
            if ($query == true) {
                $success_message = "<div class='alert alert-success'>Property Successfully Uploaded.</div>";
            }
        }
        
    }

}

?><?php echo $error_message.$success_message ?>
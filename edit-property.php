<?php
session_start();
$agent_id = $_SESSION['user'];


include('class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

$property_slug = $class->purify($_GET['n']);
$own = $class->getPopertyDetailsBySlug($property_slug);
$owner = $own['agent_id'];
if ($owner != $agent_id) {
    header("Location: property.php?n=".$property_slug);
    exit();
}

$error_message = '';
$success_message = '';
$er = false;
if (isset($_POST['submitBtn'])) {
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
    if (isset($_POST['swimming_pool'])) {
        $swimming_pool = $class->purify($_POST['swimming_pool']);    
    }else{
        $swimming_pool = 'off';
    }
    
    $tnc = $class->purify($_POST['tnc']);
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

    if ($tnc == 'no') {
        $e = $e+1;
        $e16 = "<li>You must accept the Terms and Conditions to proceed.</li>";
    }else{
        $e16 = '';
    }


    if (strlen($e) > 0) {
        $error_message = "<h4 style='margin-left:20px;color:rgb(173, 28, 28)'><span class='fa fa-warning'></span>Check the following Errors:</h4> <ul style='color:#F00'>".$e1.$e2.$e3.$e4.$e5.$e6.$e7.$e8.$e9.$e10.$e11.$e12.$e13.$e14.$e15.$e16."</ul>";
    }else{                                    
            $query = $con->query("UPDATE real_properties SET propertyname = '$propertyname',propertyprice = '$propertyprice',phone = '$phone',description = '$description',type = '$type',state = '$state',city = '$city',address = '$address',quality = '$quality',built_in = '$built_in',bedrooms = '$bedrooms',car_garages = '$car_garages',bathrooms = '$bathrooms',toilets = '$toilets',story_building = '$story_building',swimming_pool = '$swimming_pool',last_modified_date = NOW() WHERE slug = '$property_slug'") or die(mysqli_error($con));
            if ($query == true) {
                header("Location: property.php?n=".$property_slug);
            }
    }

}

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo ucfirst($class->getVariable('site_name')); ?> | Edit property</title>
    <meta name="description" content="GARO is a real-estate template">
    <meta name="author" content="Kimarotec">
    <meta name="keyword" content="html5, css, bootstrap, property, real-estate theme , bootstrap template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/fontello.css">
    <link href="assets/fonts/icon-7-stroke/css/pe-icon-7-stroke.css" rel="stylesheet">
    <link href="assets/fonts/icon-7-stroke/css/helper.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css"> 
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/icheck.min_all.css">
    <link rel="stylesheet" href="assets/css/price-range.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">  
    <link rel="stylesheet" href="assets/css/owl.theme.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css"> 
    <link rel="stylesheet" href="assets/css/wizard.css"> 
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <!-- Body content -->

    <!-- Header Content -->
    <?php include('incs/header.php') ?>
    <!-- Header Content Ends -->

    <div class="page-head"> 
        <div class="container">
            <div class="row">
                <div class="page-head-content">
                    <h1 class="page-title">Hi <?php $agentRow = $class->getAgentDetailsById($agent_id); echo $agentRow['username'] ?>! Edit your property</h1>               
                </div>
            </div>
        </div>
    </div>
    <!-- End page header -->

    <!-- property area -->
    <div class="content-area submit-property" style="background-color: #FCFCFC;">&nbsp;
        <div class="container">
            <div class="clearfix" > 
                <div class="wizard-container"> 

                    <div class="wizard-card ct-wizard-orange" id="wizardProperty">
                        
                        <form method="POST" id="property_upload_form" enctype="multipart/form-data">
                            <div class="wizard-header">
                                <h3>
                                    <b>Edit</b> YOUR PROPERTY <br>
                                    <small>You are permited to make some basic changes.</small>
                                </h3>
                                
                            </div>

                                    <div class="row p-b-15  ">
                                        <h4 class="info-text"> Let's start with the basic information (with validation)</h4>
                                        <div id='error_messages' class='col-sm-12'><?php echo $error_message.$success_message ?></div>
                                        <div class='col-sm-3'></div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Property name <small>(required)</small></label>
                                                <input type="text" name="propertyname" id="propertyname"  value="<?php echo $class->getPopertyDetailsBySlug2($property_slug,'propertyname'); ?>" class="form-control" placeholder="Super villa ..." required>
                                            </div>

                                            <div class="form-group">
                                                <label>Property price in ₦ <small>(required)</small></label>
                                                <input name="propertyprice" id="propertyprice" type="text" value="<?php echo $class->getPopertyDetailsBySlug2($property_slug,'propertyprice'); ?>" class="form-control" placeholder="3330000" required>
                                            </div> 
                                            <div class="form-group">
                                                <label>Telephone <small>(required)</small></label>
                                                <input name="phone" id="phone" type="text" class="form-control" value="<?php echo $class->getPopertyDetailsBySlug2($property_slug,'phone'); ?>" placeholder="+234 123 456 7890" required>
                                            </div>
                                        </div>
                                        <div class='col-sm-3'></div>
                                    </div>
                                    <h4 class="info-text"> How much your Property is Beautiful ? </h4>
                                    <div class="row">
                                        <div class="col-sm-12"> 
                                            <div class="col-sm-12"> 
                                                <div class="form-group">
                                                    <label>Property Description :</label>
                                                    <textarea name="description" id="description" class="form-control" required><?php echo $class->getPopertyDetailsBySlug2($property_slug,'description'); ?></textarea>
                                                </div> 
                                            </div> 
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Property Type  :</label>
                                                    <select id="type" name="type" class="selectpicker show-tick form-control" required>
                                                        <option selected=""><?php echo $class->getPopertyDetailsBySlug2($property_slug,'type'); ?></option>
                                                        <option value=''> -Type- </option>
                                                        <option>For Lease</option>
                                                        <option>For Sale</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Property State :</label>
                                                    <select name="state" id="state" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Select your state" required>
                                                        <option selected="" value="<?php echo $class->getPopertyDetailsBySlug2($property_slug,'state') ?>"><?php echo $class->getStateNameById($class->getPopertyDetailsBySlug2($property_slug,'state')); ?></option>
                                                        <?php
                                                        $re = $con->query("SELECT * FROM states ORDER BY name ASC");
                                                        while ($r = $re->fetch_assoc()) {
                                                            $s_id = $r['state_id'];
                                                            echo "<option value='".$s_id."'>".$r['name']."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Property City :</label>
                                                        <!-- <select id="lga" class="selectpicker" onClick="load_lga()" data-live-search="true" data-live-search-style="begins" title="Select your city">
                                                    </select> -->
                                                    <input type="text" class="form-control" name="city" value="<?php echo $class->getPopertyDetailsBySlug2($property_slug,'city') ?>" id="city" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Property Address :</label>
                                                        <!-- <select id="lga" class="selectpicker" onClick="load_lga()" data-live-search="true" data-live-search-style="begins" title="Select your city">
                                                    </select> -->
                                                    <input type="text" class="form-control" name="address" value="<?php echo $class->getPopertyDetailsBySlug2($property_slug,'address') ?>" id="address" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Property Quality  :</label>
                                                    <select id="quality" name="quality" class="selectpicker show-tick form-control" required>
                                                        <option selected=""><?php echo $class->getPopertyDetailsBySlug2($property_slug,'quality'); ?></option>
                                                        <option value=''> -Quality- </option>
                                                        <option>New </option>
                                                        <option>Used</option>  

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Built In  :</label>
                                                    <select id="built_in" name="built_in" class="selectpicker show-tick form-control" required>
                                                        <option selected=""><?php echo $class->getPopertyDetailsBySlug2($property_slug,'built_in'); ?></option>
                                                        <option value=''>-Built In-</option>
                                                        <?php
                                                        for ($i=1980; $i <= date("Y"); $i++) { 
                                                            echo "<option>".$i."</option>";
                                                        }
                                                        ?>


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Bedrooms :</label>
                                                    <select id="bedrooms" name="bedrooms" class="selectpicker show-tick form-control" required>
                                                        <option selected=""><?php echo $class->getPopertyDetailsBySlug2($property_slug,'bedrooms'); ?></option>
                                                        <option value=''>-Bedrooms-</option>
                                                        <?php
                                                        for ($i=1; $i <= 10; $i++) { 
                                                            if ($i == 1) {
                                                                $s = '';
                                                            }else{
                                                                $s = 's';
                                                            }
                                                            echo "<option value='".$i."'>".$i." Bedroom".$s."</option>";
                                                        }
                                                        ?>


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Car Garages  :</label>
                                                    <select id="car_garages" name="car_garages" class="selectpicker show-tick form-control" required>
                                                        <option selected=""><?php echo $class->getPopertyDetailsBySlug2($property_slug,'car_garages'); ?></option>
                                                        <option value=''>-Car Garages-</option>
                                                        <?php
                                                        for ($i=0; $i <= 10; $i++) { 
                                                            if ($i == 1) {
                                                                $s = '';
                                                                $ii = $i;
                                                            }else if($i == 0){
                                                                $s = '';
                                                                $ii = "No";
                                                            }else{
                                                                $s = 's';
                                                                $ii = $i;
                                                            }
                                                            echo "<option value='".$i."'>".$ii." Car Garage".$s."</option>";
                                                        }
                                                        ?>


                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 padding-top-15">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Bathrooms :</label>
                                                    <select id="bathrooms" name="bathrooms" class="selectpicker show-tick form-control" required>
                                                        <option selected=""><?php echo $class->getPopertyDetailsBySlug2($property_slug,'bathrooms'); ?></option>
                                                        <option value=''>-Bathrooms-</option>
                                                        <?php
                                                        for ($i=0; $i <= 10; $i++) { 
                                                            if ($i == 1) {
                                                                $s = '';
                                                                $ii = $i;
                                                            }else if($i == 0){
                                                                $s = '';
                                                                $ii = "No";
                                                            }else{
                                                                $s = 's';
                                                                $ii = $i;
                                                            }
                                                            echo "<option value='".$i."'>".$ii." Bathroom".$s."</option>";
                                                        }
                                                        ?>


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Toilets :</label>
                                                    <select id="toilets" name="toilets" class="selectpicker show-tick form-control" required>
                                                        <option selected=""><?php echo $class->getPopertyDetailsBySlug2($property_slug,'toilets'); ?></option>
                                                        <option value=''>-Toilets-</option>
                                                        <?php
                                                        for ($i=0; $i <= 10; $i++) { 
                                                            if ($i == 1) {
                                                                $s = '';
                                                                $ii = $i;
                                                            }else if($i == 0){
                                                                $s = '';
                                                                $ii = "No";
                                                            }else{
                                                                $s = 's';
                                                                $ii = $i;
                                                            }
                                                            echo "<option value='".$i."'>".$ii." Toilet".$s."</option>";
                                                        }
                                                        ?>


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Story Building :</label>
                                                    <select id="story_building" name="story_building" class="selectpicker show-tick form-control" required>
                                                        <option selected=""><?php echo $class->getPopertyDetailsBySlug2($property_slug,'story_building'); ?></option>
                                                        <option value=''>-Story Building-</option>
                                                        <?php
                                                        for ($i=0; $i <= 50; $i++) { 
                                                            if ($i == 1) {
                                                                $s = '';
                                                                $ii = $i;
                                                            }else if($i == 0){
                                                                $s = '';
                                                                $ii = "Not";
                                                            }else{
                                                                $s = 's';
                                                                $ii = $i;
                                                            }
                                                            echo "<option value='".$i."'>".$ii." Story Building".$s."</option>";
                                                        }
                                                        ?>


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <div class="checkbox">
                                                        <label>
                                                            <?php
                                                                if ($class->getPopertyDetailsBySlug2($property_slug,'swimming_pool') == 'on') {
                                                                    echo '<input type="checkbox" name="swimming_pool" id="swimming_pool" checked > Swimming Pool';
                                                                }else{
                                                                    echo '<input type="checkbox" name="swimming_pool" id="swimming_pool"> Swimming Pool';
                                                                }
                                                            ?>
                                                            
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                                                       
                                    <!-- <h4 class="info-text">Give us a video ? </h4>
                                    <div class="row">  
                                        <div class="col-sm-4"> 

                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label for="property-images">Chose Video :</label>
                                                <input type="file" name="file[]" id='property_video' onchange='video_preview()'>
                                                <div id='vid_prev' style='text-align:center'></div>

                                            </div>
                                        </div>
                                        <div class="col-sm-4"> 

                                        </div>
                                    </div> -->
                                    <div class='row'>
                                        <div class='col-sm-12'>
                                               <button class='pull-right btn btn-success' name='submitBtn'>SUBMIT</button>
                                        </div>
                                    </div>	
                        </form>
                    </div>
                    <!-- End submit form -->
                </div> 
            </div>
        </div>
    </div>

    <!-- Footer area-->
    <?php include('incs/footer.php') ?>
    <!-- Footer area Ends-->

    <script src="assets/js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="assets/js/jquery-1.10.2.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/bootstrap-hover-dropdown.js"></script>
    <script src="assets/js/easypiechart.min.js"></script>
    <script src="assets/js/jquery.easypiechart.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/wow.js"></script>
    <script src="assets/js/icheck.min.js"></script>

    <script src="assets/js/price-range.js"></script> 
    <script src="assets/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>
    <script src="assets/js/jquery.validate.min.js"></script>
    <script src="assets/js/wizard.js"></script>

    <script src="assets/js/main.js"></script>


</body>
</html>
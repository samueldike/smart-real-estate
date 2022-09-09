<?php
    session_start();
    $myId = $_SESSION['user'];
    include('class.php');
    $class = new main();
    $class->db_connect();
    GLOBAL $con;
    $alert = '';

    if (!isset($_SESSION['user'])) {
        header("Location:signup-signin.php");
    }
    $agent = $class->getUserDetailById($myId);
    $username = $agent['username'];

    if (isset($_POST['buildBtn'])) {
        if($_POST['firstname'] == ''){
            $alert =  "<div class='alert alert-warning'>First Name cannot be empty.</div>";
        }elseif($_POST['lastname'] == ''){
            $alert =  "<div class='alert alert-warning'>Last Name cannot be empty.</div>";
        }elseif($_POST['phoneNo'] == ''){
            $alert =  "<div class='alert alert-warning'>Phone Number cannot be empty.</div>";
        }elseif($_POST['address'] == ''){
            $alert =  "<div class='alert alert-warning'>Address cannot be empty.</div>";
        }
        elseif($_POST['sex'] == ''){
            $alert =  "<div class='alert alert-warning'>Sex cannot be empty.</div>";
        }
        elseif($_POST['state'] == ''){
            $alert =  "<div class='alert alert-warning'>State cannot be empty.</div>";
        }elseif($_POST['bio'] == ''){
            $alert =  "<div class='alert alert-warning'>Bio cannot be empty.</div>";
        }else{
            $firstname = $class->purify($_POST['firstname']);
            $lastname = $class->purify($_POST['lastname']);
            $phoneNo = $class->purify($_POST['phoneNo']);
            $address = $class->purify($_POST['address']);
            $sex = $class->purify($_POST['sex']);
            $state = $class->purify($_POST['state']);
            $bio = $class->purify($_POST['bio']);
            $facebook = $class->purify($_POST['facebook']);
            $twitter = $class->purify($_POST['twitter']);
            $website = $class->purify($_POST['website']);
            if (strlen($_FILES['images']['name']) >0) {
                if (move_uploaded_file($_FILES['images']['tmp_name'], 'user-pics/'.$myId.".jpg")) {
                 //UPDATE WITH IMAGE
                    $query = mysqli_query($con, "UPDATE real_users SET firstname='$firstname',lastname='$lastname',address='$address',phoneNo='$phoneNo',sex='$sex',state='$state',bio='$bio',facebook='$facebook',twitter='$twitter',website='$website' WHERE id = '$myId'") or die(mysqli_error($con));
                    if($query == true){
                        header("Location: submit-property.php");
                    }
                    else{
                        $alert =  "<div class='alert alert-warning'>Profile Building Error. Please try again later.</div>";

                    }
                }
            }else{
                //UPDATE WITHOUT IMAGE
                    $query = mysqli_query($con, "UPDATE real_users SET firstname='$firstname',lastname='$lastname',address='$address', sex='$sex',state='$state',phoneNo='$phoneNo',bio='$bio',facebook='$facebook',twitter='$twitter',website='$website' WHERE id = '$myId'") or die(mysqli_error($con));
                    if($query == true){
                        header("Location: submit-property.php");
                    }
                    else{
                        $alert =  "<div class='alert alert-warning'>Profile Building Error. Please try again later.</div>";

                    }
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
        <title><?php echo ucfirst($class->getVariable('site_name')); ?> | Build Profile </title>
        <meta name="description" content="GARO is a real-estate template">
        <meta name="author" content="Kimarotec">
        <meta name="keyword" content="html5, css, bootstrap, property, real-estate theme , bootstrap template">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800' rel='stylesheet' type='text/css'>

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="icon" href="favicon.ico" type="image/x-icon">

        <script type="text/javascript">
            function build_profile(){
            loading('buildBtn');
            $('#multiple_upload_form').ajaxForm({
                            /*target:'#images_preview',*/
                            beforeSubmit:function(e){
                                $('.uploading').show();
                            },
                            success:function(e){
                                /*$('.uploading').hide();*/
                                alert('Success');
                            },
                            error:function(e){
                                showMessage(e,"BuildProfileMssg","warning");
                            }
                        }).submit();
        }
        </script>
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
        <script type="text/javascript" src="assets/js/jquery.form.js"></script>
        
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
                        <h1 class="page-title">Hello : <span class="orange strong"><?php echo $username ?></span></h1>               
                    </div>
                </div>
            </div>
        </div>
        <!-- End page header --> 

        <!-- property area -->
        <div class="content-area user-profiel" style="background-color: #FCFCFC;">&nbsp;
            <div class="container">   
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1 profiel-container" id="upload_div">

                        <form method="post" name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data">
                            <div class="profiel-header">
                                <h3>
                                    <b>BUILD</b> YOUR PROFILE <br>
                                    <small>This information will let us know more about you.</small>
                                </h3>
                                <hr>
                                <?php echo $alert; ?>
                                <div style="text-align: center;"><span id='BuildProfileMssg'></span></div>
                            </div>

                            <div class="clear">
                                <div class="col-sm-3 col-sm-offset-1">
                                    <?php
                                        if (file_exists("user-pics/".$myId.".jpg")) {
                                            echo "<img src='user-pics/".$myId.".jpg'/>";
                                        }else{
                                            echo '<div class="picture-container">
                                                    <div class="picture">
                                                        <img src="assets/img/default-property.jpg" class="picture-src" id="wizardPicturePreview" title=""/>
                                                        <input type="file" name="images" id="images">
                                                    </div>
                                                    <h6>Choose Picture</h6>
                                                </div>';
                                        }
                                    ?>
                                </div>

                                <div class="col-sm-3 padding-top-25">

                                    <div class="form-group">
                                        <label>First Name <small>(required)</small></label>
                                        <input name="firstname" if="firstname" required type="text" class="form-control" value="<?php echo $agent['firstname'] ?>" placeholder="Andrew...">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name <small>(required)</small></label>
                                        <input name="lastname" id="lastname" required type="text" class="form-control" value="<?php echo $agent['lastname'] ?>" placeholder="Smith...">
                                    </div>
                                </div>
                                <div class="col-sm-3 padding-top-25">
                                    <div class="form-group">
                                        <label>Phone Number <small>(required)</small></label>
                                        <input name="phoneNo" id="phoneNo" required type="text" value="<?php echo $agent['phoneNo'] ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Address : <small>(required)</small></label>
                                        <input type="text" name='address' required id='address' value="<?php echo $agent['address'] ?>" class="form-control">
                                    </div>
                                </div>  
                                <!-- <div class="col-sm-3 padding-top-25 col-sm-offset-1">
                                    
                                </div>  --> 
                                <div class="col-sm-3 padding-top-20">
                                    <div class="form-group">
                                        <label>Sex : <small>(required)</small></label>
                                        <select  name='sex' required class="from-control selectpicker" data-live-search="true" data-live-search-style="begins" title="Select Your Sex" <?php if($agent['sex'] != ''){ $selected = "<option selected>".$agent['sex']."</option>";}else{$selected = '<option>Male</option><option>Female</option>';}?>>
                                            <?php echo $selected; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3 padding-top-20">
                                    <div class="form-group">
                                        <label>State of Origin <small>(required)</small></label>
                                        <select  name='state' required class="from-control selectpicker" data-live-search="true" data-live-search-style="begins" title="Select Your State">
                                                        
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
                                <div class="col-sm-9 col-sm-offset-1">
                                    <div class="form-group">
                                        <label>Bio <small>(required)</small></label>
                                        <textarea name='bio' id='bio' class="form-control"><?php echo $agent['bio'] ?></textarea>
                                    </div>
                                </div>   

                            </div>

                            <div class="clear">
                                <br>
                                <hr>
                                <br>
                                <div class="col-sm-9 col-sm-offset-1">
                                    <div class="form-group">
                                        <label>Facebook :</label>
                                        <input name="facebook" id="facebook" type="text" value="<?php echo $agent['facebook'] ?>" class="form-control" placeholder="https://facebook.com/user">
                                    </div>
                                    <div class="form-group">
                                        <label>Twitter :</label>
                                        <input name="twitter" id="twitter" type="text" class="form-control" value="<?php echo $agent['twitter'] ?>" placeholder="https://Twitter.com/@user">
                                    </div>
                                    <div class="form-group">
                                        <label>Website :</label>
                                        <input name="website" id="website" type="text" class="form-control" value="<?php echo $agent['website'] ?>" placeholder="https://yoursite.com/">
                                    </div>
                                </div>  

 
                            </div>
                    
                            <div class="col-sm-5 col-sm-offset-1">
                                <br>
                                <input type='submit' id='buildBtn' class='btn btn-finish btn-primary' name='buildBtn' value='Finish' />
                            </div>
                            <br>
                    </form>

                </div>
            </div><!-- end row -->

        </div>
    </div>


          <!-- Footer area-->
        <?php include('incs/footer.php') ?>
        <!-- Footer area Ends-->


        <script src="assets/js/vendor/modernizr-2.6.2.min.js"></script>
        <script src="assets/js//jquery-1.10.2.min.js"></script>
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
        <script src="assets/js/jquery.form.js"></script>

</body>
</html>
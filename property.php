<?php
session_start();
include('class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

$slug = $class->purify($_GET['n']);
$propertyRow = $class->getPopertyDetailsBySlug($slug);
$agentRow = $class->getAgentDetailsById($propertyRow['agent_id']);
$agent_id = $agentRow['id'];

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
        <title><?php echo ucfirst($class->getVariable('site_name')); ?>  | <?php echo $propertyRow['propertyname'] ?></title>
        <meta name="description" content="company is a real-estate template">
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
        <link href="assets/css/animate.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="assets/css/bootstrap-select.min.css"> 
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/icheck.min_all.css">
        <link rel="stylesheet" href="assets/css/price-range.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css">  
        <link rel="stylesheet" href="assets/css/owl.theme.css">
        <link rel="stylesheet" href="assets/css/owl.transitions.css">
        <link rel="stylesheet" href="assets/css/lightslider.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/responsive.css">

        <style type="text/css">
            .img-avatar {
              border-radius: 50em; }

            .avatar {
              position: relative;
              display: inline-block;
              width: 36px; }
              .avatar .img-avatar {
                width: 36px;
                height: 36px; }
              .avatar .avatar-status {
                position: absolute;
                right: 0;
                bottom: 0;
                display: block;
                width: 10px;
                height: 10px;
                border: 1px solid #fff;
                border-radius: 50em; }

            .avatar.avatar-xs {
              position: relative;
              display: inline-block;
              width: 20px; }
              .avatar.avatar-xs .img-avatar {
                width: 20px;
                height: 20px; }
        </style>
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
                        <h1 class="page-title"><?php echo $propertyRow['propertyname'] ?></h1>               
                    </div>
                </div>
            </div>
        </div>
        <!-- End page header -->

        <!-- property area -->
        <div class="content-area single-property" style="background-color: #FCFCFC;">&nbsp;
            <div class="container">   

                <div class="clearfix padding-top-40" >

                    <div class="col-md-8 single-property-content prp-style-1 ">
                        <div class="row">
                            <div class="light-slide-item">            
                                <div class="clearfix">
                                    <div class="favorite-and-print">
                                        <a class="add-to-fav" href="#login-modal" data-toggle="modal">
                                            <i class="fa fa-star-o"></i>
                                        </a>
                                        <a class="printer-icon " href="javascript:window.print()">
                                            <i class="fa fa-print"></i> 
                                        </a>
                                    </div> 

                                    <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                        <?php 
                                            if ($propertyRow['img_1'] != '') {
                                                $img_1 = $propertyRow['img_1'];
                                                echo " <li data-thumb='property-images/".$img_1."'> 
                                                        <img src='property-images/".$img_1."' />
                                                        </li>";
                                            }
                                            if ($propertyRow['img_2'] != '') {
                                                $img_2 = $propertyRow['img_2'];
                                                echo " <li data-thumb='property-images/".$img_2."'> 
                                                        <img src='property-images/".$img_2."' />
                                                        </li>";
                                            }
                                            if ($propertyRow['img_3'] != '') {
                                                $img_3 = $propertyRow['img_3'];
                                                echo " <li data-thumb='property-images/".$img_3."'> 
                                                        <img src='property-images/".$img_3."' />
                                                        </li>";
                                            }

                                            if ($propertyRow['img_4'] != '') {
                                                $img_4 = $propertyRow['img_4'];
                                                echo " <li data-thumb='property-images/".$img_4."'> 
                                                        <img src='property-images/".$img_4."' />
                                                        </li>";
                                            }

                                            if ($propertyRow['img_5'] != '') {
                                                $img_5 = $propertyRow['img_5'];
                                                echo " <li data-thumb='property-images/".$img_5."'> 
                                                        <img src='property-images/".$img_5."' />
                                                        </li>";
                                            }

                                        ?>
                                                                                
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="single-property-wrapper">
                            <div class="single-property-header">                                          
                                <h1 class="property-title pull-left"><?php echo $propertyRow['propertyname']; ?></h1>
                                <span class="property-price pull-right">₦ <?php echo number_format($propertyRow['propertyprice']) ?></span>
                            </div>

                            <div class="property-meta entry-meta clearfix ">   
                                <?php
                                    if ($propertyRow['type'] == 'For Lease') {
                                        //Define icon src for lease
                                    }else if($propertyRow['type'] == 'For Sale'){
                                        //Define icon src for sale
                                    }
                                    $property_type = $propertyRow['type'];
                                    echo '<div class="col-xs-6 col-sm-3 col-md-3 p-b-15">
                                            <span class="property-info-icon icon-tag">                                        
                                                <img src="assets/img/icon/sale-orange.png">
                                            </span>
                                            <span class="property-info-entry">
                                                <span class="property-info-label">Property Type</span>
                                                <span class="property-info-value">'.$property_type.'</span>
                                            </span>
                                        </div>';

                                    $bedrooms = $propertyRow['bedrooms'];
                                    echo '<div class="col-xs-6 col-sm-3 col-md-3 p-b-15">
                                            <span class="property-info-icon icon-bed">
                                                <img src="assets/img/icon/bed-orange.png">
                                            </span>
                                            <span class="property-info-entry">
                                                <span class="property-info-label">Bedrooms</span>
                                                <span class="property-info-value">'.$bedrooms.'</span>
                                            </span>
                                        </div>';

                                    $bathrooms = $propertyRow['bathrooms'];
                                    echo '<div class="col-xs-6 col-sm-3 col-md-3 p-b-15">
                                             <span class="property-info-icon icon-bath">
                                                <img src="assets/img/icon/os-orange.png">
                                            </span>
                                            <span class="property-info-entry">
                                                <span class="property-info-label">Bathrooms</span>
                                                <span class="property-info-value">'.$bathrooms.'</span>
                                            </span>
                                        </div>';

                                    $car_garages = $propertyRow['car_garages'];
                                    echo '<div class="col-xs-6 col-sm-3 col-md-3 p-b-15">
                                            <span class="property-info-icon icon-bed">
                                                <img src="assets/img/icon/cars-orange.png">
                                            </span>
                                            <span class="property-info-entry">
                                                <span class="property-info-label">Car Garages</span>
                                                <span class="property-info-value">'.$car_garages.'</span>
                                            </span>
                                        </div>';

                                    $toilets = $propertyRow['toilets'];
                                    echo '<div class="col-xs-6 col-sm-3 col-md-3 p-b-15">
                                            <span class="property-info-icon icon-bed">
                                                <img src="assets/img/icon/cars-orange.png">
                                            </span>
                                            <span class="property-info-entry">
                                                <span class="property-info-label">Toilets</span>
                                                <span class="property-info-value">'.$toilets.'</span>
                                            </span>
                                        </div>';

                                    $story_building = $propertyRow['story_building'];
                                    echo '<div class="col-xs-6 col-sm-3 col-md-3 p-b-15">
                                            <span class="property-info-icon icon-bed">
                                                <img src="assets/img/icon/cars-orange.png">
                                            </span>
                                            <span class="property-info-entry">
                                                <span class="property-info-label">Story Building</span>
                                                <span class="property-info-value">'.$story_building.'</span>
                                            </span>
                                        </div>';

                                    if ($propertyRow['swimming_pool'] == 'on') {
                                        $swimming_pool = "Available";
                                    }else{
                                        $swimming_pool = "Not Available";
                                    }
                                    echo '<div class="col-xs-6 col-sm-3 col-md-3 p-b-15">
                                            <span class="property-info-icon icon-bed">
                                                <img src="assets/img/icon/cars-orange.png">
                                            </span>
                                            <span class="property-info-entry">
                                                <span class="property-info-label">Swimming Pool</span>
                                                <span class="property-info-value">'.$swimming_pool.'</span>
                                            </span>
                                        </div>';

                                    $built_in = $propertyRow['built_in'];
                                    echo '<div class="col-xs-6 col-sm-3 col-md-3 p-b-15">
                                            <span class="property-info-icon icon-bed">
                                                <img src="assets/img/icon/cars-orange.png">
                                            </span>
                                            <span class="property-info-entry">
                                                <span class="property-info-label">Built in</span>
                                                <span class="property-info-value">'.$built_in.'</span>
                                            </span>
                                        </div>';

                                ?>

                                <!-- <div class="col-xs-6 col-sm-3 col-md-3 p-b-15">
                                    <span class="property-info icon-area">
                                        <img src="assets/img/icon/room-orange.png">
                                    </span>
                                    <span class="property-info-entry">
                                        <span class="property-info-label">Area</span>
                                        <span class="property-info-value">3500<b class="property-info-unit">Sq Ft</b></span>
                                    </span>
                                </div> -->

                            </div>
                            <!-- .property-meta -->

                            <div class="section">
                                <h4 class="s-property-title">Description</h4>
                                <div class="s-property-content">
                                    <p><?php echo $propertyRow['description']; ?></p>
                                </div>
                            </div>
                            <!-- End description area  -->

                            
                            

                            <div class="section property-share"> 
                                <h4 class="s-property-title">Share width your friends </h4> 
                                <div class="roperty-social">
                                    <ul>                                         
                                        <li><a title="Share this on facebok " href="#"><span class='fa fa-facebook' style='font-size:25px;color:#8787ff'></span></li> 
                                        <li><a title="Share this on twitter " href="#"><span class='fa fa-twitter' style='font-size:25px;color:#87f2ff'></span></li> 
                                        <li><a title="Share this on linkedin " href="#"><span class='fa fa-google-plus' style='font-size:25px;color:#ff8787'></span></li>                                        
                                        <li><a title="Share this on linkedin " href="#"><span class='fa fa-linkedin' style='font-size:25px;color:#8787ff'></span></li>                                        
                                    </ul>
                                </div>
                            </div>
                            <!-- End video area  -->
                            
                        </div>
                    </div>


                    <div class="col-md-4 p0">
                        <aside class="sidebar sidebar-property blog-asside-right">
                            <div class="dealer-widget">
                                <div class="dealer-content">
                                    <div class="inner-wrapper">

                                        <div class="clear">
                                            <div class="col-xs-4 col-sm-4 dealer-face">
                                                    <img src="user-pics/<?php echo $agentRow['id'] ?>.jpg" class="img-avatar">
                                            </div>
                                            <div class="col-xs-8 col-sm-8 ">
                                                <h3 class="dealer-name">
                                                    <a href="" style='color:#CAC2C2'><?php echo $agentRow['firstname']." ".$agentRow['lastname'] ?></a>
                                                    <span><br>Real Estate Agent</span>        
                                                </h3>
                                                <div class="dealer-social-media">
                                                    <a class="twitter" target="_blank" href="<?php echo $agentRow['twitter']?>">
                                                        <i class="fa fa-twitter"></i>
                                                    </a>
                                                    <a class="facebook" target="_blank" href="<?php echo $agentRow['facebook']?>">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                    <a class="gplus" target="_blank" href="<?php echo $agentRow['website']?>">
                                                        <i class="fa fa-globe"></i>
                                                    </a> 
                                                </div>

                                            </div>
                                        </div>

                                        <div class="clear">
                                            <ul class="dealer-contacts">                                       
                                                <li><i class="pe-7s-map-marker strong"> </i> <?php echo $agentRow['address']; ?></li>
                                                <li><i class="pe-7s-mail strong"> </i> <?php echo $agentRow['email']; ?></li>
                                                <li><i class="pe-7s-call strong"> </i> <?php echo $agentRow['phoneNo']; ?></li>
                                            </ul>
                                            <p><?php echo $agentRow['bio']; ?></p>
                                            <a href="properties.php?a=<?php echo $agentRow['id']; ?>">
                                                <button class="btn" style="background-color:white;color:green">View my properties</button>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <?php
                                $full_name = $agentRow['firstname']." ".$agentRow['lastname'];

                                $moreResult = $con->query("SELECT * FROM real_properties WHERE agent_id = '$agent_id' LIMIT 4");
                                if ($moreResult->num_rows>1) {
                                    //Display more of this agent's propeerties
                                    echo '<div class="panel panel-default sidebar-menu similar-property-wdg wow fadeInRight animated">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">'.$full_name.' Properties</h3>
                                            </div>
                                            <div class="panel-body recent-property-widget">
                                                    <ul>';

                                    while ($moreRow = $moreResult->fetch_assoc()) {
                                        $firstImage = $moreRow['img_1'];
                                        $morePropertyPrice = $moreRow['propertyprice'];
                                        $morePropertyName = $moreRow['propertyname'];
                                        $morePropertySlug = $moreRow['slug'];
                                        echo '<li>
                                                        <div class="col-md-3 col-sm-3 col-xs-3 blg-thumb p0">
                                                            <a href="property.php?n='.$morePropertySlug.'"><img src="property-images/'.$firstImage.'"></a>
                                                            <span class="property-seeker">
                                                                <b class="b-1">A</b>
                                                                <b class="b-2">S</b>
                                                            </span>
                                                        </div>
                                                        <div class="col-md-8 col-sm-8 col-xs-8 blg-entry">
                                                            <h6> <a href="property.php?n='.$morePropertySlug.'">'.$morePropertyName.'</a></h6>
                                                            <span class="property-price">₦ '.number_format($morePropertyPrice).'</span>
                                                        </div>
                                                </li>';
                                    }
                                                   
                                   echo "             </ul>
                                            </div>
                                        </div>";
                              } 
                            ?> 

                            <?php include("incs/smart-search.php") ?>

                        </aside>
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
        <script type="text/javascript" src="assets/js/lightslider.min.js"></script>
        <script src="assets/js/main.js"></script>

        <script>
            $(document).ready(function () {

                $('#image-gallery').lightSlider({
                    gallery: true,
                    item: 1,
                    thumbItem: 9,
                    slideMargin: 0,
                    speed: 500,
                    auto: true,
                    loop: true,
                    onSliderLoad: function () {
                        $('#image-gallery').removeClass('cS-hidden');
                    }
                });
            });
        </script>

    </body>
</html>
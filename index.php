<?php
session_start();
if (isset($_SESSION['user'])) {
   $agent_id = $_SESSION['user'];
}


include('class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo ucfirst($class->getVariable('site_name')); ?> | Home</title>
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
        <link href="assets/css/animate.css" rel="stylesheet" media="screen">
        <link rel="stylesheet" href="assets/css/bootstrap-select.min.css"> 
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/icheck.min_all.css">
        <link rel="stylesheet" href="assets/css/price-range.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css">  
        <link rel="stylesheet" href="assets/css/owl.theme.css">
        <link rel="stylesheet" href="assets/css/owl.transitions.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/responsive.css">
        <script type="text/javascript">
            
        </script>
        
    </head>
    <body>

        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        <!-- Body content -->
        <!-- Header Content -->
        <?php include('incs/header.php') ?>
        <!-- Header Content Ends -->
        <div class="slider-area">
            <div class="slider">
                <div id="bg-slider" class="owl-carousel owl-theme">

                    <div class="item"><img src="assets/img/slide1/slider-image-1.jpg" alt="GTA V"></div>
                    <div class="item"><img src="assets/img/slide1/slider-image-2.jpg" alt="The Last of us"></div>
                    <div class="item"><img src="assets/img/slide1/slider-image-1.jpg" alt="GTA V"></div>

                </div>
            </div>
            <div class="slider-content">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12">
                        <h2>Real Estate Searching Just Got So Easy</h2>
                        <div class="search-form wow pulse" id="search-form" data-wow-delay="0.8s">

                            <form action="" class=" form-inline">
                                <!-- <button class="btn  toggle-btn" type="button"><i class="fa fa-bars"></i></button> -->

                                <div class="form-group">                                   
                                    <select  id='state' class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Select Desired State">
                                                        <?php
                                                            $re = $con->query("SELECT * FROM states ORDER BY name ASC");
                                                            while ($r = $re->fetch_assoc()) {
                                                                $s_id = $r['state_id'];
                                                                echo "<option value='".$s_id."'>".$r['name']."</option>";
                                                            }
                                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" id='city' autocomplete='off' onkeyup="city_auto_suggest()" class="form-control" placeholder="Desired City" autofocus="">
                                    <div id='city_auto_suggest' style='z-index:9000;position:absolute;color:black'></div>
                                </div>
                                <div class="form-group">                                     
                                    <!-- <select id="basic" class="selectpicker show-tick form-control">
                                        <option> -Status- </option>
                                        <option>Rent </option>
                                        <option>Boy</option>
                                        <option>used</option>  

                                    </select> -->
                                     <div class="form-group mar-r-20">
                                            <label for="price-range" style="color: #777">Price range (₦):</label>
                                            <input type="text" class="span2 price_range" value="" data-slider-min="20000" 
                                                   data-slider-max="50000000" data-slider-step="5" 
                                                   data-slider-value="[20000,50000000]" id="price-range" ><br />
                                            <b class="pull-left color">₦20,000</b> 
                                            <b class="pull-right color">₦50,000,000</b>
                                        </div>
                                </div>
                                <span class="btn btn-success" id='searchBtn' onClick='homeSearch()'><i class="fa fa-search"></i></span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- property area -->
        <div class="content-area home-area-1 recent-property" style="background-color: #FCFCFC; padding-bottom: 55px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                        <!-- /.feature title -->
                        <h2>Top submitted property</h2>
                        <!-- <p>Nulla quis dapibus nisl. Suspendisse ultricies commodo arcu nec pretium. Nullam sed arcu ultricies . </p> -->
                    </div>
                </div>

                <div class="row">
                    <div class="proerty-th">

                                <?php
                                    $query = $con->query("SELECT * FROM real_properties ORDER BY id DESC LIMIT 7");
                                    while($rowProperty = $query->fetch_assoc()){
                                        echo '<div class="col-sm-6 col-md-3 p0">
                                            <div class="box-two proerty-item">
                                                <div class="item-thumb">
                                                    <a href="property.php?n='.$rowProperty['slug'].'" ><img src="property-images/'.$rowProperty['img_1'].'"></a>
                                                </div>

                                                <div class="item-entry overflow">
                                                    <h5><a href="property.php?n='.$rowProperty['slug'].'"> '.$class->short_name($rowProperty['propertyname'],"2").' </a></h5>
                                                    <div class="dot-hr"></div>
                                                    <span class="pull-left" style="font-size:12px"><span class="fa fa-map-marker"></span> '.str_replace('State', '', $class->getStateNameById($rowProperty['state'])).' > '.$rowProperty['city'].'</span>
                                                    <span class="proerty-price pull-right">₦ '.number_format($rowProperty['propertyprice']).'</span>
                                                
                                                    <div class="property-icon">
                                                        <img src="assets/img/icon/bed.png">('.$rowProperty['bedrooms'].')|
                                                        <img src="assets/img/icon/shawer.png">('.$rowProperty['bathrooms'].')|
                                                        <img src="assets/img/icon/cars.png">('.$rowProperty['car_garages'].')  
                                                    </div>
                                                </div>


                                            </div>
                                        </div>';
                                    }
                                ?>

                        <div class="col-sm-6 col-md-3 p0">
                            <div class="box-tree more-proerty text-center">
                                <div class="item-tree-icon">
                                    <a href="properties.php" ><i class="fa fa-th"></i></a>
                                </div>
                                <div class="more-entry overflow">
                                    <h5><a href="properties.php" >CAN'T DECIDE ? </a></h5>
                                    <h5 class="tree-sub-ttl">Show all properties</h5>
                                    <a href="properties.php" ><button class="btn border-btn more-black" value="All properties">All properties</button></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--Welcome area -->
        <div class="Welcome-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 Welcome-entry  col-sm-12">
                        <div class="col-md-5 col-md-offset-2 col-sm-6 col-xs-12">
                            <div class="welcome_text wow fadeInLeft" data-wow-delay="0.3s" data-wow-offset="100">
                                <div class="row">
                                    <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                                        <!-- /.feature title -->
                                        <h2></h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div  class="welcome_services wow fadeInRight" data-wow-delay="0.3s" data-wow-offset="100">
                                <div class="row">
                                    <div class="col-xs-6 m-padding">
                                        <div class="welcome-estate">
                                            <div class="welcome-icon">
                                                <a href="properties.php"><i class="pe-7s-home pe-4x"></i></a>
                                            </div>
                                            <h3>Any property</h3>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 m-padding">
                                        <div class="welcome-estate">
                                            <div class="welcome-icon">
                                                <a href="javascript:isPreferencesSet('nav')"><i class="pe-7s-users pe-4x"></i></a>
                                            </div>
                                            <h3>Share Rent</h3>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 text-center">
                                        <i class="welcome-circle"></i>
                                    </div>

                                    <div class="col-xs-6 m-padding">
                                        <div class="welcome-estate">
                                            <div class="welcome-icon">
                                                <a href="#search-form"><i class="pe-7s-search pe-4x"></i></a>
                                            </div>
                                            <h3>Filter Search</h3>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 m-padding">
                                        <div class="welcome-estate">
                                            <div class="welcome-icon">
                                                <a href="contact.php"><i class="pe-7s-help2 pe-4x"></i></a>
                                            </div>
                                            <h3>Any help </h3>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--TESTIMONIALS -->
        <div class="testimonial-area recent-property" style="background-color: #FCFCFC; padding-bottom: 15px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title">
                        <!-- /.feature title -->
                        <h2>Our Users Said  </h2> 
                    </div>
                </div>

                <div class="row">
                    <div class="row testimonial">
                        <div class="col-md-12">
                            <div id="testimonial-slider">
                                <div class="item">
                                    <div class="client-text">                                
                                        <p>This can elivate real estate agents beyond what they achieved in the past 5 years.</p>
                                        <h4><strong>Michael Ken, </strong><i>Real Estate Consultant</i></h4>
                                    </div>
                                    <div class="client-face wow fadeInRight" data-wow-delay=".9s"> 
                                        <img src="assets/img/client-face1.png" alt="">
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="client-text">                                
                                        <p>The Share Rent integration just made it easy! I matches with high intelligence.</p>
                                        <h4><strong>Alisa John, </strong><i>Tenant</i></h4>
                                    </div>
                                    <div class="client-face">
                                        <img src="assets/img/client-face2.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Count area -->
        <!-- <div class="count-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 col-sm-12 text-center page-title"> -->
                        <!-- /.feature title -->
                        <!-- <h2>You can trust Us </h2> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 percent-blocks m-main" data-waypoint-scroll="true">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <div class="count-item">
                                    <div class="count-item-circle">
                                        <span class="pe-7s-users"></span>
                                    </div>
                                    <div class="chart" data-percent="5000">
                                        <h2 class="percent" id="counter">0</h2>
                                        <h5>HAPPY CUSTOMER </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <div class="count-item">
                                    <div class="count-item-circle">
                                        <span class="pe-7s-home"></span>
                                    </div>
                                    <div class="chart" data-percent="12000">
                                        <h2 class="percent" id="counter1">0</h2>
                                        <h5>Properties in stock</h5>
                                    </div>
                                </div> 
                            </div> 
                            <div class="col-sm-3 col-xs-6">
                                <div class="count-item">
                                    <div class="count-item-circle">
                                        <span class="pe-7s-flag"></span>
                                    </div>
                                    <div class="chart" data-percent="120">
                                        <h2 class="percent" id="counter2">0</h2>
                                        <h5>City registered </h5>
                                    </div>
                                </div> 
                            </div> 
                            <div class="col-sm-3 col-xs-6">
                                <div class="count-item">
                                    <div class="count-item-circle">
                                        <span class="pe-7s-graph2"></span>
                                    </div>
                                    <div class="chart" data-percent="5000">
                                        <h2 class="percent"  id="counter3">5000</h2>
                                        <h5>DEALER BRANCHES</h5>
                                    </div>
                                </div> 

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- boy-sale area -->
        <div class="boy-sale-area">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 col-sm-10 col-sm-offset-1 col-md-offset-0 col-xs-12">
                       <a href="properties.php"> 
                        <div class="asks-first">
                            <div class="asks-first-circle">
                                <span class="fa fa-search"></span>
                            </div>
                            <div class="asks-first-info">
                                <h2>ARE YOU LOOKING FOR A Property?</h2>
                                <p>Lest you get i touch with property owners across the nation.</p>                                        
                            </div>
                            <div class="asks-first-arrow">
                                <span class="fa fa-angle-right"></span>
                            </div>
                        </div>
                    </a>
                    </div>
                    <div class="col-md-6 col-sm-10 col-sm-offset-1 col-xs-12 col-md-offset-0">
                        <a href="submit-property.php">
                            <div  class="asks-first">
                            <div class="asks-first-circle">
                                <span class="fa fa-usd"></span>
                            </div>
                            <div class="asks-first-info">
                                <h2>DO YOU WANT TO SELL A Property?</h2>
                                <p>Lets we link you with property buyers nationwide.</p>
                            </div>
                            <div class="asks-first-arrow">
                                <span class="fa fa-angle-right"></span>
                            </div>
                        </div>
                    </a>
                    </div>
                    <div class="col-xs-12">
                        <p  class="asks-call">QUESTIONS? CALL US  : <span class="strong"> +234 701 056 6830</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer area-->
        <?php include('incs/footer.php') ?>
        <!-- Footer area Ends-->
        <script src="assets/js/modernizr-2.6.2.min.js"></script>

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

        <script src="assets/js/main.js"></script>

    </body>
</html>
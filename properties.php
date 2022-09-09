<?php
session_start();
include('class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

//PAGINATION
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_Recordset1 = 12;
$p = 0;
if (isset($_GET['p'])) {
   $p = $_GET['p'];
}
$startRow_Recordset1 = $p * $maxRows_Recordset1;

if (isset($_GET['a'])) {
    $a = $class->purify($_GET['a']);
    $query_Recordset1 = "SELECT * FROM real_properties WHERE agent_id = '$a' ORDER BY id DESC";
}else{
    $query_Recordset1 = "SELECT * FROM real_properties ORDER BY id DESC";
}
$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
$Recordset1 = mysqli_query($con, $query_limit_Recordset1) or die(mysqli_error($con));
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);

if (isset($_GET['n'])) {
   $n = $_GET['n'];
} else {
   $all_Recordset1 = mysqli_query($con, $query_Recordset1);
   $n = mysqli_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($n / $maxRows_Recordset1) - 1;

$queryString_Recordset1 = "";
if (!empty($_SERVER['QUERY_STRING'])) {
   $params = explode("&", $_SERVER['QUERY_STRING']);
   $newParams = array();
   foreach ($params as $param) {
       if (stristr($param, "p") == false &&
               stristr($param, "n") == false) {
           array_push($newParams, $param);
       }
   }
   if (count($newParams) != 0) {
       $queryString_Recordset1 = "&" . htmlentities(implode("&", $newParams));
   }
}
$queryString_Recordset1 = sprintf("&n=%d%s", $n, $queryString_Recordset1);


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
        <title><?php echo ucfirst($class->getVariable('site_name')); ?> | Properties</title>
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

                        <h1 class="page-title">
                            <?php
                                if (isset($_GET['a'])) {
                                    $rAgent = $class->getAgentDetailsById($a);
                                    $agentName = $rAgent['firstname']." ".$rAgent['lastname'];
                                    echo $agentName."'s "."Properties";
                                }else{
                                    echo "All Properties";
                                }
                            ?>
                        </h1>               
                    </div>
                </div>
            </div>
        </div>
        <!-- End page header -->

        <!-- property area -->
        <div class="properties-area recent-property" style="background-color: #FFF;">
            <div class="container">   
                <div class="row">
                    <div class="col-md-9 padding-top-40 properties-page">
                       

                        <div class="section clear"> 
                            <div id="list-type" class="proerty-th">
                                <?php
                                    do{
                                        echo '<div class="col-sm-6 col-md-4 p0">
                                            <div class="box-two proerty-item">
                                                <div class="item-thumb">
                                                    <a href="property.php?n='.$row_Recordset1['slug'].'" ><img src="property-images/'.$row_Recordset1['img_1'].'"></a>
                                                </div>

                                                <div class="item-entry overflow">
                                                    <h5><a href="property.php?n='.$row_Recordset1['slug'].'"> '.$class->short_name($row_Recordset1['propertyname'],"2").' </a></h5>
                                                    <div class="dot-hr"></div>
                                                    <span class="pull-left" style="font-size:12px"><span class="fa fa-map-marker"></span> '.str_replace('State', '', $class->getStateNameById($row_Recordset1['state'])).' > '.$row_Recordset1['city'].'</span>
                                                    <span class="proerty-price pull-right">₦ '.number_format($row_Recordset1['propertyprice']).'</span>
                                                    
                                                    <div class="property-icon">
                                                        <img src="assets/img/icon/bed.png">('.$row_Recordset1['bedrooms'].')|
                                                        <img src="assets/img/icon/shawer.png">('.$row_Recordset1['bathrooms'].')|
                                                        <img src="assets/img/icon/cars.png">('.$row_Recordset1['car_garages'].')  
                                                    </div>
                                                </div>


                                            </div>
                                        </div>';
                                    }while($row_Recordset1 = mysqli_fetch_assoc($Recordset1));

                                ?>
                                 

                                
                            </div>
                        </div>
                        <div class="section">
                            <div class='col-sm-12' style='padding:0px'>
                              <?php if ($p > 0) { // Show if not first page ?>
                              <a class="btn btn-default btn-sm" style='color:white;padding:9px' href="<?php printf("%s?p=%d%s", $currentPage, max(0, $p - 1), $queryString_Recordset1); ?>" title="View more"><span class="fa fa-arrow-circle-o-left"></span> Previous</a>
                              
                              <?php } // Show if not first page ?>
                              <?php if ($p < $totalPages_Recordset1) { // Show if not last page ?>
                              <a class="btn btn-default pull-right btn-sm" style='color:white;padding:9px' href="<?php printf("%s?p=%d%s", $currentPage, min($totalPages_Recordset1, $p + 1), $queryString_Recordset1); ?>" title="View more">View More <span class="fa fa-arrow-circle-right"></span></a>
                              <?php } ?>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-3 pl0 padding-top-40">
                        <div class="blog-asside-right pl0">
                            <?php include("incs/smart-search.php") ?>
                            <?php include("incs/recommended.php") ?>
                        </div>
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
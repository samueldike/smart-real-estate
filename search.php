<?php
session_start();
include('class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

if (isset($_GET['s'])) {
    //PAGINATION
$currentPage = $_SERVER["PHP_SELF"];

//GET SEARCH DATA
$state = $class->purify($_GET['s']);

$city = $class->purify($_GET['c']);
$city = str_replace("+", " ", $city);

$from_price = $class->purify($_GET['f']);
$to_price = $class->purify($_GET['t']);

if ($to_price == '') {
    //QUERY STRING
    $QS = "SELECT * FROM real_properties WHERE propertyprice >= '$from_price' AND state = '$state' AND city LIKE '%$city%'";
}else{
    //QUERY STRING
    $QS = "SELECT * FROM real_properties WHERE state = '$state' AND city LIKE '%$city%' AND propertyprice >= '$from_price' AND propertyprice <= '$to_price'";
}



$maxRows_Recordset1 = 12;
$p = 0;
if (isset($_GET['p'])) {
   $p = $_GET['p'];
}
$startRow_Recordset1 = $p * $maxRows_Recordset1;

$query_Recordset1 = $QS;
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
        <title><?php echo ucfirst($class->getVariable('site_name')); ?> | Search</title>
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
                    <div class="page-head-content text-center">
                        <h1 class="page-title">Search Result</h1> 
                        <div class='col-sm-2'></div>
                        <div class="col-sm-8 search-form wow pulse" data-wow-delay="0.8s">

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
                        <div class='col-sm-2'></div> 
                        <br>           
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
                            <div class="col-xs-10 page-subheader sorting pl0">
                                <ul class="sort-by-list">
                                    <li class="">
                                        <a href="javascript:void(0);" class="order_by_price" data-orderby="property_price" data-order="DESC">
                                           <?php if(isset($_GET['s'])){if($n>0){$plur = "s";}else{$plur = "";}echo $n." Result".$plur." Found"; }?>
                                        </a>
                                    </li>
                                    <li class="active">
                                        <a href="javascript:void(0);" class="order_by_date" data-orderby="property_date" data-order="ASC">
                                            <span class='fa fa-map-marker'></span> <?php if(isset($_GET['s'])){echo $_GET['c'].", ".$class->getStateNameById($_GET['s']);} ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-xs-2 layout-switcher">
                                <a class="layout-list" href="javascript:void(0);"> <i class="fa fa-th-list"></i>  </a>
                                <a class="layout-grid active" href="javascript:void(0);"> <i class="fa fa-th"></i> </a>                          
                            </div><!--/ .layout-switcher-->
                        </div>

                        <div class="section clear"> 
                            <div id="list-type" class="proerty-th">
                                <?php
                                if (isset($_GET['s'])) {
                                    if ($n > 0) {
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
                                                            <img src="assets/img/icon/bed.png">(5)|
                                                            <img src="assets/img/icon/shawer.png">(2)|
                                                            <img src="assets/img/icon/cars.png">(1)  
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>';
                                        }while($row_Recordset1 = mysqli_fetch_assoc($Recordset1));   
                                    }else{

                                    }   
                                }
                                ?>
                                 

                                
                            </div>
                        </div>
                        <div class="section">
                            <div class='col-sm-12' style='padding:0px'>
                              <?php if(isset($_GET['s'])){ if ($p > 0) { // Show if not first page ?>
                              <a class="btn btn-default btn-sm" style='color:white;padding:9px' href="<?php printf("%s?p=%d%s", $currentPage, max(0, $p - 1), $queryString_Recordset1); ?>" title="View more"><span class="fa fa-arrow-circle-o-left"></span> Previous</a>
                              
                              <?php } // Show if not first page ?>
                              <?php if ($p < $totalPages_Recordset1) { // Show if not last page ?>
                              <a class="btn btn-default pull-right btn-sm" style='color:white;padding:9px' href="<?php printf("%s?p=%d%s", $currentPage, min($totalPages_Recordset1, $p + 1), $queryString_Recordset1); ?>" title="View more">View More <span class="fa fa-arrow-circle-right"></span></a>
                              <?php } }?>
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
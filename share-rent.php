<?php
/*Problem description
         *  Given an equal number of men and women to be paired for marriage, each man ranks all the women in order of his preference and each women ranks all the men in order of her preference.
         *  A stable set of engagements for marriage is one where no man prefers a women over the one he is engaged to, where that other woman also prefers that man over the one she is engaged to. I.e. with consulting marriages, there would be no reason for the engagements between the people to change.
         *  Gale and Shapley proved that there is a stable set of engagements for any set of preferences and the first link above gives their algorithm for finding a set of stable engagements.*/
include('class.php');
$class = new main();
$class->db_connect();
session_start();
$myId = $_SESSION['user'];
if (!isset($_SESSION['user'])) {
    header("Location:signup-signin.php");
}
$return1 = '';
$return2 = '';
GLOBAL $mssg;
$mssg = '<h5><b>MOST PREFERRED CO-TENANT</b></h5>';
if (isset($_POST['match_btn'])) {
    //Disengage the current engagement
        $mssg =  $class->runFreeTenant();
   
}
if (isset($_POST['re_match_meBtn'])) {
    //Disengage the current engagement
        $prev_user = $class->purify($_POST['prev_user']);
        $rtgbu = $class->getAgentDetailsById($prev_user);
        if ($rtgbu['m_status'] == 'married') {
            //Devource
            $pref_usr = $rtgbu['pref_to'];
            //Loose my pattner
            if($con->query("UPDATE real_users SET m_status = 'free', pref_by = '',pref_to = '', pref_rank = '' WHERE id = '$prev_user'")){
            }
            //Loose myself
            if($con->query("UPDATE real_users SET m_status = 'free', pref_by = '',pref_to = '', pref_rank = '' WHERE id = '$myId'")){
            }
            $mssg =  $class->runFreeTenant();
        }else{
            
            $mssg =  $class->runFreeTenant();
            $con->query("UPDATE real_users SET m_status = 'free', pref_by = '', pref_rank = '' WHERE id = '$prev_user'");
        }
        

    
}
//The line below frees all Users in the system.
//$con->query("UPDATE real_users SET m_status = 'free', pref_by = '',pref_to = '', pref_rank = '',pref_user = ''");
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
        <title><?php echo ucfirst($class->getVariable('site_name')); ?>  | Share Rent</title>
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
    <body onload="isPreferencesSet('the_page')">

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
                        <h1 class="page-title">Hi! <?php $rmm = $class->getAgentDetailsById($myId);echo $rmm['username']; ?>, Share Rent With Someone</h1>               
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
                            <div id="list-type" class="col-sm-12 proerty-th">
                                <div class='col-sm-12 text-center' style='padding:0px'>
                                    <h3 class='my_underline'>Most Preferred Co-Tenant Matching Application</h3>
                                    <br>
                                    <i>This application implements an award winning matching algorithm.</i>
                                    <br><br></div>
                                <form method='post'>
                                    <div class='text-center'>
                                       <?php
                                            $hglk = $class->getAgentDetailsById($myId);
                                            if ($hglk['m_status'] == 'free') {
                                                echo "<button class='btn btn-success' name='match_btn'>Search for the most Preferred co-tenant</button>";
                                            }
                                        ?>
                                        <span class='btn btn-success' onClick='changeMyPrefs()'>Change my preferences</span>
                                        <br><br>
                                    </div>
                                </form>
                                <div class='col-sm-12' style='padding:0px'>
                                    
                                    <?php
                                        $reqResult = $con->query("SELECT * FROM real_users WHERE pref_to = '$myId' AND m_status != 'married'");
                                        echo "<h5 class='my_underline'>Request to Share Rent <span style='background-color:red;color:white;padding:2px'>".$reqResult->num_rows."</span></h5>
                                            <br>";
                                        while ($reqRow = $reqResult->fetch_assoc()) {
                                            $eId = $reqRow['id'];
                                            $reqUsr = $class->getAgentDetailsById($eId);
                                            echo "<span class='fa fa-user' title='Click to Approve' onClick='showRequestToShareRent(".$eId.")'  style='border:1px solid #E6E6E6;padding:2px;cursor:pointer'> ".$reqUsr['firstname']." ".$reqUsr['lastname']."</span>";
                                        }
                                    ?>
                                </div>

                                <?php echo $return1.$return2; ?>
                                <?php
                                
                                /*$prefs = array("Buhdist","Muslim","Pegan","Drinks Alcohol","Drinks Non-Alcohol","Late Night Return","Smoking","Female Visitors Permit","No Female Visitors Permit","Male Visitors Permit","No Male Visitors Permit","Traveling","Watching Movies","Playing Game","Playing Music Aloud","Playing Music","Speaks English","Speaks French","Speaks Igbo","Speaks Hausa","Speaks Yoruba","Igbo Tribe","Hausa Tribe","Yoruba Tribe","Empolyed","Unemployed","Student","Prayer");
                                for ($i=0; $i < count($prefs); $i++) { 
                                    $pref = $prefs[$i];
                                    $con->query("INSERT INTO preference_list (preference) VALUES('$pref')") or die(mysqli_error($con));
                                }*/

                                $qqk = $con->query("SELECT * FROM real_users WHERE id = '$myId'");
                                $rq = $qqk->fetch_assoc();
                                
                                    $pref_user = $rq['pref_to'];
                                    
                                    echo "<div class='col-sm-6 search-form' style='padding:10px'>";
                                    echo '<h5><b>MY PREFERENCES</b></h5>';
                                    $l = $con->query("SELECT * FROM preferences WHERE user_id = '$myId'");
                                    $mySn = 0;
                                    if ($l->num_rows>0) {
                                        echo "<div class='col-sm-12' style='padding:0px'>
                                                <span class='col-sm-6' style='padding:0px'>
                                                    <img src='user-pics/".$myId.".jpg' style='width:95%'>
                                                </span>
                                                <span class='col-sm-6' style='padding:0px'>
                                                </span>
                                            </div>";
                                        while ($op = $l->fetch_assoc()) {
                                            $mySn++;
                                            echo "<span class='col-sm-6' style='padding:0px'>".$mySn.". ".$op['preference']."</span>"; 
                                        }
                                    }
                                    echo "</div>";
                                   
                                    
                                    echo "<div class='col-sm-6 search-form' style='padding:10px'>";

                                    
                                if ($rq['m_status'] != 'free') { 
                                    $uio = $class->getUserDetailById($pref_user);
                                    echo "<h5><b>MOST PREFERRED CO-TENANT</b></h5>";
                                    
                                    $l2 = $con->query("SELECT * FROM preferences WHERE user_id = '$pref_user'");
                                    $UserSn = 0;

                                    if ($rq['pref_to'] != '') {
                                        echo "<div class='col-sm-12' style='padding:0px'>
                                                <span class='col-sm-6' style='padding:0px'>
                                                    <img src='user-pics/".$pref_user.".jpg' style='width:95%'>
                                                </span>
                                                <span class='col-sm-6' style='padding:0px'>
                                                    <b class='my_underline'>Name: </b> ".$uio['firstname']." ".$uio['lastname']."<br>
                                                    <b class='my_underline'>Sex: </b> ".$uio['sex']."<br>
                                                    <b class='my_underline'>State of Origin: </b> ".$class->getStateNameById($uio['state'])."<br>
                                                    <b class='my_underline'>Contact: </b> ".$uio['phoneNo']."<br>
                                                </span>
                                            </div>";
                                        while ($op2 = $l2->fetch_assoc()) {
                                         $UserSn++;
                                            echo "<span class='col-sm-6' style='padding:0px'>".$UserSn.". ".$op2['preference']."</span>";   
                                        }
                                    }
                                    if ($l2->num_rows>0) {
                                        echo "<div style='font-size:12px;color:red'>Don't like this Tenant?</div>
                                        <form method='post'>
                                        <input type='hidden' name='prev_user' value='".$pref_user."'>
                                        <button class='btn btn-success' name='re_match_meBtn' style='width:100%'>Search for the next most Preferred co-tenant</button>
                                        </form>";
                                    }
                                    

                                }else{
                                    echo $mssg;
                                }
                                    echo "</div>";
                                ?>
                                
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
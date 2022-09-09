<?php 
if (isset($_SESSION['user'])) {
 $myId = $_SESSION['user'];
 if (isset($_POST['setPreferenceBtn'])) {

        if (isset($_POST['preference'])) {
            $pref = $_POST['preference'];
            $num = count($pref);

            $perc = 100/$num;
            if ($num > 0) {
                foreach ($pref as $key => $value) {
                    if ($pref[$key] != '') {
                        $this_pref =  $pref[$key];
                    //Ensure there is no duplicate preference
                        $resD = $con->query("SELECT id FROM preferences WHERE user_id = '$myId' AND preference = '$this_pref'");
                        if ($resD->num_rows==0) {
                            $con->query("INSERT INTO preferences(user_id,preference,perc) VALUES('$myId','$this_pref','$perc')") or die(mysqli_error($con));    
                        }
                    }
                }
                //This user is ready for pair
                $con->query("UPDATE real_users SET pair = 'yes', m_status = 'free' WHERE id = '$myId'");
                $class->runFreeTenant();
            }
        }
        
    }
//CHANGE MY PREFERENCES
if (isset($_POST['changePref_btn'])) {
    //DELETE MY PREVIOUS PREFERENCES
    $con->query("DELETE FROM preferences WHERE user_id = '$myId'");
    if (isset($_POST['preference'])) {
            $pref = $_POST['preference'];
            $num = count($pref);

            $perc = 100/$num;
            if ($num > 0) {
                foreach ($pref as $key => $value) {
                    if ($pref[$key] != '') {
                        $this_pref =  $pref[$key];
                    //Ensure there is no duplicate preference
                        $resD = $con->query("SELECT id FROM preferences WHERE user_id = '$myId' AND preference = '$this_pref'");
                        if ($resD->num_rows==0) {
                            $con->query("INSERT INTO preferences(user_id,preference,perc) VALUES('$myId','$this_pref','$perc')") or die(mysqli_error($con));    
                        }
                    }
                }
                //I am ready for pair
                $con->query("UPDATE real_users SET pair = 'yes', m_status = 'free' WHERE id = '$myId'");
                //Disengage the previous user i am engaged
                $yyy = $con->query("SELECT * FROM real_users WHERE pref_by = '$myId'");
                $yyr = $yyy->fetch_assoc();
                $yyPReve_user = $yyr['id'];
                $con->query("UPDATE real_users SET m_status = 'free', pref_by = '', pref_rank = '' WHERE id = '$yyPReve_user'");
                $class->runFreeTenant();
            }
        }
}
} 

?>

</style>
<div class="header-connect">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-8  col-xs-12">
                <div class="header-half header-call">
                    <p>
                        <span><i class="pe-7s-call"></i> +234 701 056 6830</span>
                        <span><i class="pe-7s-mail"></i> your@company.com</span>
                    </p>
                </div>
            </div>
            <div class="col-md-2 col-md-offset-5  col-sm-3 col-sm-offset-1  col-xs-12">
                <div class="header-half header-social">
                    <ul class="list-inline">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-vine"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>        
<!--End top header -->

<nav class="navbar navbar-default ">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php"><img src="assets/img/logo.png" alt=""></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse yamm" id="navigation">
            <div class="button navbar-right">
                <?php
                if (!isset($_SESSION['user'])) {
                    echo "<a href='signup-signin.php'><button class='navbar-btn nav-button wow bounceInRight login' data-wow-delay='0.45s'>Signup/Signin</button></a>";         
                }
                if (isset($_SESSION['user'])) {
                    echo "<a href='logout.php'><button class='navbar-btn nav-button wow bounceInRight login' data-wow-delay='0.45s'><span class='fa fa-off'></span>Logout</button></a>";         
                }
                ?>

                <a href="submit-property.php"><button class="navbar-btn nav-button wow fadeInRight"  data-wow-delay="0.48s">Submit Property</button></a>
            </div>
            <ul class="main-nav nav navbar-nav navbar-right">
                <li class="dropdown ymm-sw " data-wow-delay="0.1s">
                    <a href="index.php">Home</a>
                </li>
                <?php
                if (isset($_SESSION['user'])) {
                    $usn = $class->getAgentDetailsById($myId);
                    $usnn = explode(" ", $usn['username']);
                    $username = $usnn[0];
                    echo "<li class='wow fadeInDown' data-wow-delay='0.3s'><a href='build-profile.php'><span class='fa fa-user'> ".$username."'s</span> Profile</a></li>";

                    echo "<li class='wow fadeInDown' data-wow-delay='0.3s'><a href='my-properties.php'><span class='fa fa-home'></span> My Properties</a></li>";
                }
                ?>
                <li class="wow fadeInDown" data-wow-delay="0.2s"><a class="" href="properties.php">Properties</a></li>
                <li class="wow fadeInDown" data-wow-delay="0.3s"><a class="" href="javascript:isPreferencesSet('nav')">Share Rent</a></li>
                        <!-- <li class="dropdown yamm-fw" data-wow-delay="0.4s">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="200">Template <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <div class="yamm-content">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h5>Home pages</h5>
                                                <ul>
                                                    <li>
                                                        <a href="index.php">Home Style 1</a>
                                                    </li>
                                                    <li>
                                                        <a href="index-2.php">Home Style 2</a>
                                                    </li>
                                                    <li>
                                                        <a href="index-3.php">Home Style 3</a>
                                                    </li>
                                                    <li>
                                                        <a href="index-4.php">Home Style 4</a>
                                                    </li>
                                                    <li>
                                                        <a href="index-5.php">Home Style 5</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <h5>Pages and blog</h5>
                                                <ul>
                                                    <li><a href="blog.php">Blog listing</a>  </li>
                                                    <li><a href="single.php">Blog Post (full)</a>  </li>
                                                    <li><a href="single-right.php">Blog Post (Right)</a>  </li>
                                                    <li><a href="single-left.php">Blog Post (left)</a>  </li>
                                                    <li><a href="contact.php">Contact style (1)</a> </li>
                                                    <li><a href="contact-3.php">Contact style (2)</a> </li>
                                                    <li><a href="contact_3.php">Contact style (3)</a> </li>
                                                    <li><a href="faq.php">FAQ page</a> </li> 
                                                    <li><a href="404.php">404 page</a>  </li>
                                                </ul>
                                            </div>
                                            <div class="col-sm-3">
                                                <h5>Property</h5>
                                                <ul>
                                                    <li><a href="property-1.php">Property pages style (1)</a> </li>
                                                    <li><a href="property-2.php">Property pages style (2)</a> </li>
                                                    <li><a href="property-3.php">Property pages style (3)</a> </li>
                                                </ul>

                                                <h5>Properties list</h5>
                                                <ul>
                                                    <li><a href="properties.php">Properties list style (1)</a> </li> 
                                                    <li><a href="properties-2.php">Properties list style (2)</a> </li> 
                                                    <li><a href="properties-3.php">Properties list style (3)</a> </li> 
                                                </ul>                                               
                                            </div>
                                            <div class="col-sm-3">
                                                <h5>Property process</h5>
                                                <ul> 
                                                    <li><a href="submit-property.php">Submit - step 1</a> </li>
                                                    <li><a href="submit-property.php">Submit - step 2</a> </li>
                                                    <li><a href="submit-property.php">Submit - step 3</a> </li> 
                                                </ul>
                                                <h5>User account</h5>
                                                <ul>
                                                    <li><a href="register.php">Register / login</a>   </li>
                                                    <li><a href="user-properties.php">Your properties</a>  </li>
                                                    <li><a href="submit-property.php">Submit property</a>  </li>
                                                    <li><a href="change-password.php">Change password</a> </li>
                                                    <li><a href="user-profile.php">Your profile</a>  </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </li> -->
                        <?php if (!isset($_SESSION['user'])) {
                                echo '<li class="wow fadeInDown" data-wow-delay="0.5s"><a href="contact.php">Contact</a></li>';
                            }
                        ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- End of nav bar -->

        <!-- MODAL -->
        <div class="modal fade" id="setPreferenceModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->

                <div class="modal-content col-sm-12">
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <center>
                            <h4 style='color:#0caa18'>SET YOUR PREFERENCES</h4> 
                            <hr>
                        </center>

                    </div>
                    <div class="modal-body col-sm-12" style='padding:0px'>
                        <div style='font-size:13px;line-height:19px'>
                            <span style='color:#0caa18;font-weight:bold'>Hi <?php if(isset($_SESSION['user'])){$rmm = $class->getAgentDetailsById($myId);echo $rmm['username']; }?>! </span>
                            this will help us match you with someone on this network who you will love to share rent with. We will require just some few preferences to know your kind of person. 
                            Thick your preferences.
                            <br><br>
                            <form method='post' action='share-rent.php'>

                                <?php
                                if (isset($_SESSION['user'])) {
                                    $qp = $con->query("SELECT preference FROM preference_list ORDER BY preference ASC");
                                    while ($rowp = $qp->fetch_assoc()) {
                                        echo "<div class='col-sm-4' style='padding:0px;margin-bottom:10px;'><input type='checkbox' name='preference[]' value='".$rowp['preference']."'> ".$rowp['preference']."</div>";
                                    }
                                }

                                ?>
                                <br>
                                <div class='col-sm-12'>
                                    <button name='setPreferenceBtn' class='btn btn-success pull-right'>Submit my Preferences</button>
                                    <div onClick=cancelShareRent('<?php if(isset($_SESSION['user'])){$rmm = $class->getAgentDetailsById($myId);echo $rmm['username']; }?>') class='btn btn-success pull-right'  style='margin-right:12px'>Cancel</div>
                                    <br><br><br>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- CHANGE PREFERENCE MODAL -->
        <div class="modal fade" id="changePreferenceModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->

                <div class="modal-content col-sm-12">
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <center>
                            <h4 style='color:#0caa18'>SET YOUR PREFERENCES</h4> 
                            <hr>
                        </center>
                        
                    </div>
                    <div class="modal-body col-sm-12" style='padding:0px'>
                        <div style='font-size:13px;line-height:19px'>
                            <span style='color:#0caa18;font-weight:bold'>Hi <?php if(isset($_SESSION['user'])){$rmm = $class->getAgentDetailsById($myId);echo $rmm['username']; }?>! </span>
                            this will help us match you with someone on this network who you will love to share rent with. We will require just some few preferences to know your kind of person. 
                            Thick your preferences.
                            <br><br>
                            <form method='post' action='share-rent.php'>
                                
                                <?php
                                if (isset($_SESSION['user'])) {
                                    $qp = $con->query("SELECT preference FROM preference_list ORDER BY preference ASC");
                                    while ($rowp = $qp->fetch_assoc()) {
                                        echo "<div class='col-sm-4' style='padding:0px;margin-bottom:10px;'><input type='checkbox' name='preference[]' value='".$rowp['preference']."'> ".$rowp['preference']."</div>";
                                    }
                                }
                                
                                ?>
                                <br>
                                <div class='col-sm-12'>
                                    <button name='changePref_btn' class='btn btn-success pull-right'>Change my Preferences</button>
                                    <div onClick=cancelShareRent('<?php if(isset($_SESSION['user'])){$rmm = $class->getAgentDetailsById($myId);echo $rmm['username']; }?>') class='btn btn-success pull-right'  style='margin-right:12px'>Cancel</div>
                                    <br><br><br>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- CHANGE PREFERNCE MODAL -->

        <!-- APPROVE REQUEST TO SHARE RENT MODAL -->
        <div class="modal fade" id="approveRequestToShareRentModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->

                <div class="modal-content col-sm-12">
                    <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal'>&times;</button>
                        <center>
                            <h4 class='my_underline' style='color:#0caa18'>APPROVE REQUEST TO SHARE RENT</h4> 
                        </center>
                        
                    </div>
                    <div class="modal-body col-sm-12" id='approveRequestToShareRentModalBody' style='padding:0px'>
                        
                    </div>

                </div>

            </div>
        </div>
        <!-- APPROVE REQUEST TO SHARE RENT MODAL -->

        <!-- NAVIGATION MODAL -->
        <div class="modal fade" data-keyboard="false" data-backdrop="static" id="navigationModal" role="dialog" style="margin-top: 20%">
            <div class="modal-dialog">

                <!-- Modal content-->

                <div class="modal-content col-sm-12" style="padding: 0px">
                    <div class="modal-body col-sm-12 text-center" id='navigationModalBody' style='font-size:24px;padding:0px'>
                        <div class="col-xs-12" style="color: green;font-size: 13px">Login Successful. What do you want to do next?</div>
                        <a href="submit-property.php">
                            <div class="col-sm-4" style="padding:20px;border-right:1px dotted green">
                                <div class="fa fa-home"></div>
                                <br>
                                Sell Property
                            </div>
                        </a>
                        <a href="properties.php">
                            <div class="col-sm-4" style="padding:20px;font-size: 23px;border-right:1px dotted green">
                                <div class="fa fa-shopping-cart"></div>
                                <br>
                                Buy Property
                            </div>
                        </a>
                        <a href="share-rent.php">
                            <div class="col-sm-4" style="padding:20px">
                                <div class="fa fa-users"></div> 
                                <br>
                                Share Rent
                            </div>
                        </a>
                    </div>

                </div>

            </div>
        </div>
        <!-- NAVIGATION MODAL -->
        <!-- MODAL -->

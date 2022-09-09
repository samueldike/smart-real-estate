<div class="panel panel-default sidebar-menu wow fadeInRight animated" style='z-index:0'>
                                <div class="panel-heading">
                                    <h3 class="panel-title">Recommended</h3>
                                </div>
                                <div class="panel-body recent-property-widget">
                                    <ul>
                                        <?php
                                            $hyde = $con->query("SELECT * FROM real_properties ORDER BY RAND() LIMIT 4");
                                            while ($recomRow = $hyde->fetch_assoc()) {
                                                $imgg = $recomRow['img_1'];
                                                $slugg = $recomRow['slug'];
                                                $propImg = "<img src='property-images/".$imgg."'>";
                                                echo '<li>
                                                    <div class="col-md-3 col-sm-3 col-xs-3 blg-thumb p0">
                                                        <a href="property.php?n='.$slugg.'">'.$propImg.'</a>
                                                        <span class="property-seeker">
                                                            <b class="b-1">A</b>
                                                            <b class="b-2">S</b>
                                                        </span>
                                                    </div>
                                                    <div class="col-md-8 col-sm-8 col-xs-8 blg-entry">
                                                        <h6> <a href="property.php?n='.$slugg.'">'.$recomRow['propertyname'].'</a></h6>
                                                        <span class="property-price">₦ '.number_format($recomRow['propertyprice']).'</span>
                                                    </div>
                                                </li>';
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
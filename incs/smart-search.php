<div class="panel panel-default sidebar-menu wow fadeInRight animated">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Smart search</h3>
                                </div>
                                <div class="panel-body search-widget search-form"  style='padding:5px'>

                                        <fieldset>
                                            <div class="row">
                                                <div class="col-xs-12" style='z-index:90000000'>

                                                    <select  id='smart_state' class='form-control' title="Select Desired State">
                                                                        <?php
                                                                            $re = $con->query("SELECT * FROM states ORDER BY name ASC");
                                                                            while ($r = $re->fetch_assoc()) {
                                                                                $s_id = $r['state_id'];
                                                                                echo "<option value='".$s_id."'>".$r['name']."</option>";
                                                                            }
                                                                        ?>
                                                    </select>
                                                    <br>
                                                </div>
                                                <div class="col-xs-12">

                                                    <input type="text" id='smart_city' autocomplete='off' onkeyup="smart_city_auto_suggest()" class="form-control" placeholder="Desired City">
                                                    <div id='smart_city_auto_suggest' style='z-index:9000;position:absolute;color:black'></div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="padding-5">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <label for="property-geo">Property Price Range (₦) :</label>
                                                    <input type="text" class="span2 smart_price_range" value="" data-slider-min="20000" 
                                                           data-slider-max="50000000" data-slider-step="2" 
                                                           data-slider-value="[20000,50000000]" id="property-geo" ><br />
                                                    <b class="pull-left color">₦20,000</b> 
                                                    <b class="pull-right color">₦50,000,000</b>                                                
                                                </div>                                            
                                            </div>
                                        </fieldset>

                                        <fieldset >
                                            <div class="row">
                                                <div class="col-xs-12">  
                                                    <input class="button btn largesearch-btn" onClick="smart_search()"  id='smart_searchBtn' value="Search" type="submit">
                                                </div>  
                                            </div>
                                        </fieldset>
                                </div>
                            </div>
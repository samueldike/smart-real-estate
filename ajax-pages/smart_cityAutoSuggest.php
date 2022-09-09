<?php
include('../class.php');
$class = new main();
$class->db_connect();
GLOBAL $con;

if($_POST['city_keyword'] != ''){
    $city_keyword = $class->purify($_POST['city_keyword']);
    $gu = mysqli_query($con, "SELECT * FROM real_properties WHERE city LIKE '%$city_keyword%'");
    if ($gu == true) {
        while ($r = $gu->fetch_assoc()) {
            $city = $r['city'];
            $mCity = str_replace(" ", "_", $city);
            echo "<div class='col-sm-12 smart_city_suggest_text_".$mCity."' onClick=smart_insert_suggestion('smart_city_suggest_text_".$mCity."') id='smart_city_suggest_test'>".$r['city']."</div>";
        }
    }
}

?>
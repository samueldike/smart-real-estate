<?php

class main{

	public function db_connect(){

		$host = "localhost";
		$user = "root";
		$u_pass = "";
		$db = "real_estate_man";

		GLOBAL $con;
		$con = mysqli_connect($host, $user, $u_pass, $db);

	}function purify($value){
		GLOBAL $con;
		$result = mysqli_real_escape_string($con, trim($value));
		return $result;
	}
	function getVariable($var_name){
		GLOBAL $con;
		$result = mysqli_query($con, "SELECT * FROM variables WHERE id = '1'");
		$r = mysqli_fetch_assoc($result);
		return $r[$var_name];
	}
	function getUserDetailById($userId){
		GLOBAL $con;
		$result = mysqli_query($con, "SELECT * FROM real_users WHERE id = '$userId'");
		$r = mysqli_fetch_assoc($result);
		return $r;
	}
	function file_namify($file_name){
		$p = str_replace(" ", "-", $file_name);

		return $p;
	}
	
	function lengthify_password($password){
		if (strlen($password) >= 8 && strlen($password <= 11)) {
			return true;
		}else{
			return false;
		}
	} function timeAgo($time_ago){
		$time_ago =  strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
		$time  = time() - $time_ago;

		switch($time):
      // seconds
		case $time <= 60;
		return 'less than a minute ago';
      // minutes
		case $time >= 60 && $time < 3600;
		return (round($time/60) == 1) ? 'a minute' : round($time/60).' minutes ago';
      // hours
		case $time >= 3600 && $time < 86400;
		return (round($time/3600) == 1) ? 'an hour ago' : round($time/3600).' hours ago';
      // days
		case $time >= 86400 && $time < 604800;
		return (round($time/86400) == 1) ? 'a day ago' : round($time/86400).' days ago';
      // weeks
		case $time >= 604800 && $time < 2628000;
		return (round($time/604800) == 1) ? 'a week ago' : round($time/604800).' weeks ago';
      // months
		case $time >= 2628000 && $time < 31207680;
		return (round($time/2628000) == 1) ? 'a month ago' : round($time/2628000).' months ago';
      // years
		case $time >= 31547680;
		return (round($time/31547680) == 1) ? 'a year ago' : round($time/31547680).' years ago' ;

		endswitch;
	}
	function slugify($str){
	    # special accents
		$a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
		$b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
		return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
	}
	function check_slug($string){
		GLOBAL $con;
		$result = mysqli_query($con, "SELECT * FROM  real_properties WHERE slug = '$string'");
		$num = $result->num_rows;
		$er = false;
		if($num > 0){
			$er = true;
			//Slug Exist
			$new_num = $num+1;
			$new_slug = $string."-".$new_num;
			return $this->check_slug($new_slug);
		}else{
			$er = false;
			$slug = $string;
		}
		if ($er == false) {
			return $slug;
		}
	}
	function unique_slugify($str){
	    # special accents
		$a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
		$b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
		$slug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));

	    //Make Slug Unique
		$slug = $this->check_slug($slug);
		return $slug;
	}
	
	function getPopertyDetailsBySlug($slug){
		GLOBAL $con;
		$result = $con->query("SELECT * FROM real_properties WHERE slug = '$slug'");
		$r = $result->fetch_assoc();
		return $r;
	}
	function getPopertyDetailsBySlug2($slug,$field_name){
		GLOBAL $con;
		$result = $con->query("SELECT * FROM real_properties WHERE slug = '$slug'");
		$r = $result->fetch_assoc();
		return $r[$field_name];
	}
	function getAgentDetailsById($agent_id){
		GLOBAL $con;
		$result = $con->query("SELECT * FROM real_users WHERE id = '$agent_id'");
		$r = $result->fetch_assoc();
		return $r;
	}
	function getStateNameById($stateId){
		GLOBAL $con;
		$result = $con->query("SELECT * FROM states WHERE state_id = '$stateId'");
		$r = $result->fetch_assoc();
		return $r['name'];
	}
	function short_name($string, $count) {
	  preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $string, $matches);
	  $p = explode(" ", $string);
	  if (count($p)>$count) {
	  	return $matches[0]."...";
	  }else{
	  	return $matches[0];
	  }
	  
	}
	function getUserDisapprovalStatus($user_id,$who){
		GLOBAL $con;
		$myId = $_SESSION['user'];
		if ($who == 'i') {
			$res1 = $con->query("SELECT * FROM disapprove WHERE myId = '$myId' AND user_id = '$user_id' AND type = 'Permanent'") or die(mysqli_error($con));
			$res2 = $con->query("SELECT * FROM disapprove WHERE myId = '$myId' AND user_id = '$user_id' AND type = 'Temporary'") or die(mysqli_error($con));
		}elseif ($who == 'they') {
			$res1 = $con->query("SELECT * FROM disapprove WHERE myId = '$user_id' AND user_id = '$myId' AND type = 'Permanent'") or die(mysqli_error($con));
			$res2 = $con->query("SELECT * FROM disapprove WHERE myId = '$user_id' AND user_id = '$myId' AND type = 'Temporary'") or die(mysqli_error($con));
		}
		

		$numP = $res1->num_rows;
		$numT = $res2->num_rows;
		
		if ($numP > 0) {
			return "Permanent";
		}
		if ($numT > 0) {
			return "Temporary";
		}
		if ($numP == 0 AND $numT == 0) {
			return "None";
		}
	}
	function profileCompletionRatio(){
		GLOBAL $con;
		GLOBAL $agent_id;
		$result = $con->query("SELECT * FROM real_users WHERE id = '$agent_id'");
		$row = $result->fetch_assoc();

		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
		$phoneNo = $row['phoneNo'];
		$address = $row['address'];
		$bio = $row['bio'];
		$facebook = $row['facebook'];
		$twitter = $row['twitter'];
		$website = $row['website'];


		$completion = 0;
		$increament = 11.111111111111111111111111111111;

		$incompletion = 100;

		if ($firstname != '') {
			$completion = $completion + $increament;
		}else{
			$incompletion = $incompletion - $increament;
		}
		if ($lastname != '') {
			$completion = $completion + $increament;
		}else{
			$incompletion = $incompletion - $increament;
		}

		if ($phoneNo != '') {
			$completion = $completion + $increament;
		}else{
			$incompletion = $incompletion - $increament;
		}

		if ($address != '') {
			$completion = $completion + $increament;
		}else{
			$incompletion = $incompletion - $increament;
		}

		if ($bio != '') {
			$completion = $completion + $increament;
		}else{
			$incompletion = $incompletion - $increament;
		}

		if ($facebook != '') {
			$completion = $completion + $increament;
		}else{
			$incompletion = $incompletion - $increament;
		}

		if ($twitter != '') {
			$completion = $completion + $increament;
		}else{
			$incompletion = $incompletion - $increament;
		}

		if ($website != '') {
			$completion = $completion + $increament;
		}else{
			$incompletion = $incompletion - $increament;
		}


		if (file_exists("user-pics/".$agent_id.".jpg")) {
			$completion = $completion + $increament;
		}else{
			$incompletion = $incompletion - $increament;
		}

		return $completion."|".$incompletion;
	}
	function isProfileGoodToGo($agent_id){
		GLOBAL $con;
		$result = $con->query("SELECT * FROM real_users WHERE id = '$agent_id'");
		$row = $result->fetch_assoc();
		//Instantiate fact
		$fact = true;
		if ($row['firstname'] == '') {
			$fact = false;
		}
		if ($row['lastname'] == '') {
			$fact = false;
		}
		if ($row['phoneNo'] == '') {
			$fact = false;
		}
		if ($row['address'] == '') {
			$fact = false;
		}
		if ($row['bio'] == '') {
			$fact = false;
		}
		return $fact;
	}
	function newVeriPin(){
		GLOBAL $con;
		//GENERATE NEW VERI. PIN CONTAINING 12 DIGITS
		$n1 = rand(10,99); //GENERATE 2 DIGITS
		$n2 = rand(0,9);  //GENERATE 1 DIGITS
		$n3 = rand(0,9); //GENERATE 1 DIGITS
		$n4 = rand(100,999); //GENERATE 3 DIGITS
		$n5 = rand(10,99); //GENERATE 2 DIGITS
		$n6 = rand(0,9); //GENERATE 1 DIGITS
		$n7 = rand(0,9); //GENERATE 1 DIGITS
		$n8 = rand(0,9); //GENERATE 1 DIGITS
		
		$veri_pin = $n1.$n2.$n3.$n4.$n5.$n6.$n7.$n8; // 12 digits veri pin
		
		//CHECK DRUG PINS IN DATABASE IF PIN IS ALREADY GENERATED
		$result = mysqli_query($con, "SELECT * FROM drugs WHERE veri_pin = '$veri_pin'");
		if ($result->num_rows>0) {
			//VERI PIN EXISTS
			//RECURSE
			$this->newVeriPin();
			
		}else{
			//VERI PIN DOES NOT EXIST
			return $veri_pin;
		}
	}
	function errorLog($e){
		$filePrevCont = file_get_contents("errorLog.txt");
		file_put_contents("errorLog.txt", $filePrevCont."\n".$e."		-".date("Y-m-d h:m:s"));
	}
	function getHighestRank($recurse){
		GLOBAL $con;
		$myId = $_SESSION['user'];
		GLOBAL $mssg;
		if (strlen($recurse) > 0) {
			$recurse++;
		}else{
			$recurse = 0;
		}
		$q5 = $con->query("SELECT MAX(rank) AS highRank FROM our_pref_rank WHERE myId = '$myId' AND status != 'engaged' ORDER BY id DESC LIMIT 1") or die(mysqli_error($con));
		if ($q5->num_rows == 0) {
			$mssg = "<div class='alert alert-warning'>There are no Users with any preference similar to yours.</div>";
			
		}else{
			
			$row4 = $q5->fetch_assoc();
			$pref_rank = $row4['highRank'];
			$qq1 = $con->query("SELECT userId FROM our_pref_rank WHERE rank = '$pref_rank' AND status != 'engaged'")  or die(mysqli_error($con));
			$rro = $qq1->fetch_assoc();
			$pref_user = $rro['userId'];
			if ($qq1->num_rows==0) {
				//Clear our_pref_rank
				$con->query("DELETE FROM our_pref_rank WHERE myId = '$myId'")  or die(mysqli_error($con));
				$mssg = "<div class='alert alert-warning'>There is no free user with similar preferences as yours.</div>";
			}else{
				//Highest Rank Obtained
				//Check if pref_user is free.
				$q6 = $con->query("SELECT * FROM real_users WHERE id = '$pref_user'") or die(mysqli_error($con));
				$row5 = $q6->fetch_assoc();
				if ($row5['m_status'] == "free") { //pref user is FREE!!!
					//Engage pref_user
					$q7 = $con->query("UPDATE real_users SET m_status = 'engaged', pref_by = '$myId', pref_rank = '$pref_rank' WHERE id ='$pref_user'") or die(mysqli_error($con));
					//Update Self as engaged
					$q7 = $con->query("UPDATE real_users SET m_status = 'engaged', pref_to = '$pref_user', pref_rank = '$pref_rank' WHERE id ='$myId'") or die(mysqli_error($con));
					//this->showEngagement($myId, $pref_user);
					//Clear our_pref_rank
					$con->query("DELETE FROM our_pref_rank WHERE myId = '$myId'")  or die(mysqli_error($con));
				}elseif ($row5['m_status'] == 'engaged') {
					//Compare pref_rank with real_users current pref_rank
					if ($row5['pref_rank'] < $pref_rank) {
						//I rank higher than real_users current pref
						//Disengage user and engage user.
						//Diengage All Who ranked my pref user
						if ($con->query("DELETE our_pref_rank WHERE userId = '$pref_user' AND myId != '$myId'") == true) {
						}else{
						}
						$e12 = $con->query("UPDATE real_users SET m_status = 'free', pref_to = '' WHERE pref_to = '$pref_user' AND id != '$myId'") or die(mysqli_error($con));
						$qq = $con->query("UPDATE real_users SET m_status = 'engaged', pref_by = '$myId', pref_rank = '$pref_rank', pref_user = '$pref_user' WHERE id = '$pref_user'") or die(mysqli_error($con));
						//Update Self as engaged
						$q7 = $con->query("UPDATE real_users SET m_status = 'engaged', pref_to = '$pref_user', pref_rank = '$pref_rank' WHERE id ='$myId'") or die(mysqli_error($con));
						//Clear our_pref_rank
						$e13 = $con->query("DELETE FROM our_pref_rank WHERE myId = '$myId' and userId = '$pref_user'")  or die(mysqli_error($con));
						$con->query("DELETE FROM our_pref_rank WHERE myId = '$pref_user' and userId = '$myId'")  or die(mysqli_error($con));
						//this->showEngagement($myId, $pref_user);
					}elseif ($row5['pref_rank'] > $pref_rank) {
						//I rank lower tha real_users current pref
						//I cannot disengage this engaged user
						//Set real_users status as engaged.
						$con->query("UPDATE our_pref_rank SET status = 'engaged' WHERE myId = '$myId' AND userId = '$pref_user'") or die(mysqli_error($con));
						//Recurse 5 times
						if ($recurse <= 5) {
							$this->getHighestRank(0);	
						}else{
							$con->query("DELETE FROM our_pref_rank WHERE myId = '$myId' and userId = '$pref_user'")  or die(mysqli_error($con));
							$con->query("DELETE FROM our_pref_rank WHERE myId = '$pref_user' and userId = '$myId'")  or die(mysqli_error($con));
							$mssg = "<div class='alert alert-warning'>There is no free user with similar preferences as yours.</div>";
						}
					}
				}
		}
	}
	return $mssg;
}
function runFreeTenant(){
		/*Problem description
		 *  Given an equal number of men and women to be paired for marriage, each man ranks all the women in order of his preference and each women ranks all the men in order of her preference.
		 *  A stable set of engagements for marriage is one where no man prefers a women over the one he is engaged to, where that other woman also prefers that man over the one she is engaged to. I.e. with consulting marriages, there would be no reason for the engagements between the people to change.
		 *  Gale and Shapley proved that there is a stable set of engagements for any set of preferences and the first link above gives their algorithm for finding a set of stable engagements.*/
		GLOBAL $con;
		GLOBAL $mssg;
		$myId = $_SESSION['user'];
		$q1 = $con->query("SELECT * FROM real_users WHERE id != '$myId' AND m_status != 'married' AND pair = 'yes'") or die(mysqli_error($con));
		if ($q1->num_rows == 0) {
			return "<div class='alert alert-warning'>No Free Tenant</div>";
		}else{
			$eligibleTenant = 0;
			while ($row1 = $q1->fetch_assoc()) {
				//Jump All who i PERMANENTLY DISAPPROVED 
				if ($this->getUserDisapprovalStatus($row1['id'],'i') != "Permanent" AND $this->getUserDisapprovalStatus($row1['id'],'they') != "Permanent") {
					
					$eligibleTenant++;

					$tyfe = $this->getAgentDetailsById($row1['id']);
					//Fetch Free And Engaged
					$userId = $row1['id'];
					//Loop throught my Preferences
					$q2 = $con->query("SELECT * FROM preferences WHERE user_id = '$myId'") or die(mysqli_error($con));
					while ($row2 = $q2->fetch_assoc()) {
						//Fetch my Preferences
						$my_preference = $row2['preference'];
						//Chech if userId has this my preference
						$q3 = $con->query("SELECT * FROM preferences WHERE user_id = '$userId' AND preference = '$my_preference'") or die(mysqli_error($con));
						if ($q3->num_rows>0) {
							$row3 = $q3->fetch_assoc();
							//Fetch user preference corresponding to mine
							$user_pref_perc = $row3['perc'];
							//Update our_pref_rank
							$q4 = $con->query("SELECT * FROM our_pref_rank WHERE myId = '$myId' AND userId = '$userId'") or die(mysqli_error($con));
							if ($q4->num_rows>0) { // our_pref_perc exist. UPDATE
								//Get previous Rank Value
								$r1 = $q4->fetch_assoc();
								$old_rank = $r1['rank'];
								$new_rank = $old_rank + $user_pref_perc;
								//Update Rank
								$ig = $con->query("SELECT * FROM real_users WHERE id = '$myId' AND pref_to = '$userId'")  or die(mysqli_error($con));
								if ($ig->num_rows == 0) {
									$con->query("UPDATE our_pref_rank SET rank = '$new_rank' WHERE myId = '$myId' AND userId = '$userId'") or die(mysqli_error($con));
								}
							}else{ // our_pref_rank does not exist. INSERT NEW
								$ist = $con->query("INSERT INTO our_pref_rank(myId,userId,rank) VALUES('$myId', '$userId', '$user_pref_perc')") or die(mysqli_error($con));
								if ($ist == true) {
								}else{
								}
							}
						}
					}  // No more my Preferences to fetch
					//Obtain the User with the Highest Rank Where myId = myId
				}
				
			}
			if ($eligibleTenant == 0) {
				return '<div>No Free and eligible tenant found.</div>';
			}else{
				return $this->getHighestRank('');
			}
		}
		
	}//END OF FUNCTION runFreeTenant
	function final_return(){
		return "<div class='alert alert-warning'>No Free Tenant</div>";
	}
	function testReturn(){
		return $this->final_return();
	}
}

?>
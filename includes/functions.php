<?php
if($_SESSION['lng']==""){
	$_SESSION['lng']='en';
}
if($_GET['lng']){
	$_SESSION['lng']=$_GET['lng'];
}
$lng = $_SESSION['lng'];

// ---------- Cookie Info ---------- //
$cookie_name = 'maxim';
$cookie_time = (3600 * 24 * 30); // 30 days

//------------- AUTO LOGIN ----------------//

if(isSet($cookie_name)){
// Check if the cookie exists
	if(isSet($_COOKIE[$cookie_name])){
		parse_str($_COOKIE[$cookie_name]);

		$_SESSION['email']		= $email;
		$_SESSION['uname'] 		= $uname;
		$_SESSION['user_id']	= $user_id;
		
		//header("location:$fullurl");
		//exit;
	}
}

function word_limiter($str, $limit = 100, $end_char = '&#8230;') {
    if (trim($str) == '') {
        return $str;
    }
    preg_match('/^\s*+(?:\S++\s*+){1,' . (int) $limit . '}/', trim(strip_tags($str)), $matches);
    if (strlen($str) == strlen($matches[0])) {
        $end_char = '';
	}
    return rtrim($matches[0]) . $end_char;
}

function removeSpchar($str) {
    $str = str_replace("%", "-", $str);
    $str = str_replace("#", "-", $str);
    $str = str_replace("!", "-", $str);
    $str = str_replace("@", "-", $str);
    $str = str_replace("^", "-", $str);
    $str = str_replace("*", "-", $str);
    $str = preg_replace('/\s\&+/', '-', $str);
    $str = preg_replace("/\s/", "-", $str);
    $str = preg_replace('/\-\-+/', '-', $str);
    $str = str_replace("(", "-", $str);
    $str = str_replace(")", "-", $str);
    $str = str_replace("(", "-", $str);
    $str = str_replace(")", "_", $str);
    $str = str_replace("_", "-", $str);
    $str = str_replace("&", "-", $str);
    $str = str_replace("'", "-", $str);
    $str = preg_replace('/\-\-+/', '-', $str);
    $str = rtrim($str, '-');
    return $str;
}

function addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

function short_str5($str, $len, $cut = true) {
    if (strlen($str) <= $len)
        return $str;
    return ( $cut ? substr($str, 0, $len) : substr($str, 0, strrpos(substr($str, 0, $len), ' ')) ) . '...';
}

function getLnt($zip){
	$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
	".urlencode($zip)."&sensor=false";
	$result_string = file_get_contents($url);
	$result = json_decode($result_string, true);
	$result1[]=$result['results'][0];
	$result2[]=$result1[0]['geometry'];
	$result3[]=$result2[0]['location'];
	return $result3[0];
}

function priceChange($val){
	$price =  number_format($val, 2, '.', ',');
	return $price;
}

function timeAgo($time_ago){
$cur_time 	= time();
$time_elapsed 	= $cur_time - $time_ago;
$seconds 	= $time_elapsed ;
$minutes 	= round($time_elapsed / 60 );
$hours 		= round($time_elapsed / 3600);
$days 		= round($time_elapsed / 86400 );
$weeks 		= round($time_elapsed / 604800);
$months 	= round($time_elapsed / 2600640 );
$years 		= round($time_elapsed / 31207680 );
// Seconds
if($seconds <= 60){
	$tm= "$seconds seconds ago";
}
//Minutes
else if($minutes <=60){
	if($minutes==1){
		$tm= "one minute ago";
	}
	else{
		$tm= "$minutes minutes ago";
	}
}
//Hours
else if($hours <=24){
	if($hours==1){
		$tm=  "an hour ago";
	}else{
		$tm= "$hours hours ago";
	}
}
//Days
else if($days <= 7){
	if($days==1){
		$tm= "yesterday";
	}else{
		$tm= "$days days ago";
	}
}
//Weeks
else if($weeks <= 4.3){
	if($weeks==1){
		$tm= "a week ago";
	}else{
		$tm= "$weeks weeks ago";
	}
}
//Months
else if($months <=12){
	if($months==1){
		$tm= "a month ago";
	}else{
		$tm= "$months months ago";
	}
}
//Years
else{
	if($years==1){
		$tm= "one year ago";
	}else{
		$tm= "$years years ago";
	}
}

return $tm;
}


function formatSizeUnits($bytes){
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 0) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 0) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 0) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}

function myfilsSize($file, $type){
	$filesize = filesize($file);
	$fs = formatSizeUnits($filesize);
	return $fs;
}



function filter_inputs($data){
	$filter = trim(strip_tags($data));
	return $filter;
}

function commentCount($id){
	$sql = db_query("select id from comment where status='1' and news_id=".$id);
	$row = mysqli_num_rows($sql);
	return $row;
}

if (!isset($_SESSION['token'])) {
    $token = md5(uniqid(rand(), TRUE));
    $_SESSION['token'] = $token;
    $_SESSION['token_time'] = time();
}
else
{
    $token = $_SESSION['token'];
}

function encryptIt($q){
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
    $qEncoded = base64_encode(openssl_encrypt($q, $encrypt_method, $key, 0, $iv));
    return($qEncoded);
}

function decryptIt($q){
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	$qDecoded = openssl_decrypt(base64_decode($q),$encrypt_method, $key, 0, $iv);
    return($qDecoded);
}


function url_get_contents ($Url) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function chageHashTag($str) {
    $str = str_replace("%", "", $str);
    $str = str_replace("#", "", $str);
    $str = str_replace("!", "", $str);
    $str = str_replace("@", "", $str);
    $str = str_replace("^", "", $str);
    $str = str_replace("*", "", $str);
    $str = preg_replace('/\s\&+/', '', $str);
    $str = preg_replace("/\s/", "", $str);
    $str = preg_replace('/\-\-+/', '', $str);
    $str = str_replace("(", "", $str);
    $str = str_replace(")", "", $str);
    $str = str_replace("(", "", $str);
    $str = str_replace(")", "", $str);
    $str = str_replace("_", "", $str);
    $str = str_replace("&", "", $str);
    $str = str_replace("'", "", $str);
    $str = preg_replace('/\-\-+/', '', $str);
    $str = rtrim(strtolower($str), '');
    return $str;
}


/* Category Name from ID */
function getCatname($catid){
	$fieldnm = "category_".$_SESSION['lng'];
	$sql = db_query("select * from mng_category where id='".$catid."'");
	$row = mysqli_fetch_array($sql);
	$catname = $row[$fieldnm];
	if($catnam==""){
		$catname = $row['category_en'];
	}
	return $catname;
}

/* Total Views from ID */
function getTotalViews($videoid){
	$sql = db_query("select total_view from user_videos where id='".$videoid."'");
	$row = mysqli_fetch_array($sql);
	$totalview = $row['total_view'];
	if($totalview==""){
		$totalview = 0;
	}
	
	return '<i class="fa fa-eye" aria-hidden="true"></i> '.$totalview.' Views ';
}
/* Total Views from ID For API */
function getTotalViewsApi($videoid){
	$sql = db_query("select total_view from user_videos where id='".$videoid."'");
	$row = mysqli_fetch_array($sql);
	$totalview = $row['total_view'];
	if($totalview==""){
		$totalview = 0;
	}
	
	return $totalview;
}

/* Total Comments from ID */
function getTotalComments($videoid){
	$sql = db_query("select total_comments from user_videos where id='".$videoid."'");
	$row = mysqli_fetch_array($sql);
	$totalcomment = $row['total_comments'];
	if($totalcomment==""){
		$totalcomment = 0;
	}
	return '<i class="fa fa-comment-o" aria-hidden="true"></i> '.$totalcomment.' Comments ';
}

/* Total Comments from ID For API */
function getTotalCommentsApi($videoid){
	$sql = db_query("select total_comments from user_videos where id='".$videoid."'");
	$row = mysqli_fetch_array($sql);
	$totalcomment = $row['total_comments'];
	if($totalcomment==""){
		$totalcomment = 0;
	}
	return $totalcomment;
}

/* Get USER info from ID */
function getUserInfo($uid){
	$sql = db_query("select * from mng_members where id='".$uid."'");
	
	$row 	= mysqli_fetch_array($sql);
	$name 	= $row['name'];
	$uname 	= $row['uname'];
	$email 	= $row['email'];
	$bio 	= $row['bio'];
	$profilepic = $row['profilepic'];
	$address = $row['address'];
	$country = $row['country'];
	$city = $row['city'];
	$postal_code = $row['postal_code'];
	$phone = $row['phone'];
	$lang = $row['lang'];
	$status = $row['user_status'];
	$profile = $row['profile'];
	
	if($profilepic!=""){
		$profilepath = SITEURL."profilepic/".$profilepic;
	}else{
		$profilepath = SITEURL."images/profileimg.png";
	}
	
	/* GET USER Followers */
	$sql1 = db_query("select id from user_follow where followto= '".$uid."'");
	$numrow1 = mysqli_num_rows($sql1);
	$followers = $numrow1;
	
	/* GET USER Following */
	$sql2 = db_query("select id from user_follow where userid= '".$uid."'");
	$numrow2 = mysqli_num_rows($sql2);
	$following = $numrow2;
	
	/* GET USER Subscribe */
	$sql3 = db_query("select id from user_subscribe where subscribeto = '".$uid."'");
	$numrow3 = mysqli_num_rows($sql3);
	$subscribe = $numrow3;	
	
	/* GET USER Posts */
	$sql4 = db_query("select id from user_videos where userid = '".$uid."' and status='1'");
	$numrow4 = mysqli_num_rows($sql4);
	$totalpost = $numrow4;	
	
	
	//if($status==1){
		$object = new stdClass();
		$object->name = $name;
		$object->uname = $uname;
		$object->email = $email;
		$object->profilepic = $profilepath;
		$object->bio = $bio;
		$object->address = $address;
		$object->country = $country;
		$object->city = $city;
		$object->postal_code = $postal_code;
		$object->phone = $phone;
		$object->lang = $lang;
		$object->followers = $followers;
		$object->following = $following;
		$object->subscribe = $subscribe;
		$object->totalpost = $totalpost;
		$object->profile = $profile;
		$object->status = $status;
		return $object;
	//}
}

function videoInfo($vid){
	$sql = db_query("select * from user_videos where id='".$vid."'");
	$row = mysqli_fetch_array($sql);
	
	$userid				= $row['userid'];
	$videoname			= $row['videoname'];
	$thumbimg 			= $row['thumbimg'];
	if($thumbimg){
		$thumbpath 		= SITEURL."uservideos/thumb/".$thumbimg;
	}else{
		$thumbpath 		= "images/viddeo_bg.jpg";
	}
	$catids 			= explode(",",$row['video_category']);
	$price 				= $row['price'];
	$video_title 		= $row['video_title'];
	$video_description 	= $row['video_description'];
	$video_duration 	= $row['video_duration'];
	$video_hastag 		= $row['video_hastag'];
	$video_category 	= $row['video_category'];
	$uploaded_date 		= $row['uploaded_date'];
	$can_download 		= $row['can_download'];
	$total_view 		= $row['total_view'];
	$total_comments 	= $row['total_comments'];
	$total_sales 		= $row['total_sales'];
	$status 			= $row['status'];
	
	$object = new stdClass();
	$object->userid 			= $userid;
	$object->videoname 			= $videoname;
	$object->thumbpath 			= $thumbpath;
	$object->catids 			= $catids;
	$object->price 				= $price;
	$object->video_title 		= $video_title;
	$object->video_description 	= $video_description;
	$object->video_duration		= $video_duration;
	$object->video_hastag  		= $video_hastag;
	$object->video_category		= $video_category;
	$object->uploaded_date 		= $uploaded_date;
	$object->can_download  		= $can_download;
	$object->total_view  		= $total_view;
	$object->total_comments  	= $total_comments;
	$object->total_sales  		= $total_sales;
	$object->status  			= $status;

	return $object;
}
/* GET USER NOTIFICATION */

function getNotice(){
	$sql = db_query("select * from notification_text");
	$row = mysqli_fetch_array($sql);
	
	$object = new stdClass();
	$object->reportvideo 	= $row['reportvideo'];
	$object->inactivevideo 	= $row['inactivevideo'];
	$object->activevideo 	= $row['activevideo'];
	$object->deletevideo 	= $row['deletevideo'];
	$object->sellvideo 		= $row['sellvideo'];
	$object->commentvideo 	= $row['commentvideo'];
	$object->follow 		= $row['follow'];
	$object->unfollow 		= $row['unfollow'];
	$object->subscribe 		= $row['subscribe'];
	$object->unsubscribe 	= $row['unsubscribe'];
	$object->blocked 		= $row['blocked'];

	return $object;
	
}


/* GET User's Renew Info */

function renewInfo($uid){
	$sql = db_query("select * from user_subscribe where userid='".$uid."'");
	$row = mysqli_fetch_array($sql);
	$subscribeto 		= $row['subscribeto'];
	$subscribedate 		= $row['subscribedate'];
	$renewdate 			= $row['renewdate'];
	$renewon 			= $row['renewon'];
	$count_subscribe	= $row['count_subscribe'];
	$subname 			= getUserInfo($subscribeto)->name;
	
	$object = new stdClass();
	$object->subscribeto		= $subscribeto;
	$object->subname			= $subname;
	$object->subscribedate		= $subscribedate;
	$object->renewdate			= $renewdate;
	$object->renewon			= $renewon;
	$object->count_subscribe	= $count_subscribe;
	return $object;
}

/* GET USER SUBSCRIBE STATUS */
function subscribestatus($userid, $subtoid){
	$sql = db_query("select * from user_subscribe where userid='".$userid."' and subscribeto ='".$subtoid."' and renewdate >= CURDATE()");
	$numrow = mysqli_num_rows($sql);
	if($userid==$subtoid){
		$numrow = 1;
	}
	return $numrow;
}


/* Language */
function langFromId($lid){
	if($lid!="" or $lid!=0){
		$sql = db_query("select * from mng_language where id='".$lid."'");
		$row = mysqli_fetch_array($sql);
		return $row['language'];
	}else{
		return "English";
	}
}

/* GET User Follow Status */
function getUserFollow($uid){
	$userid= $_SESSION['user_id'];
	if($userid!=$uid){
		if($userid){
			$sql = db_query("select * from user_follow where userid ='".$userid."' and followto ='".$uid."'");
			$numrow = mysqli_num_rows($sql);
			if($numrow > 0){
				$val = '<a href="javascript:void(0)" onclick="unfollowUser('.$uid.')">'.changeLngF("Following", $_SESSION['lng']).'</a>';
			}else{
				$val = '<a href="javascript:void(0)" onclick="followUser('.$uid.')">'.changeLngF("Follow", $_SESSION["lng"]).'</a>';
			}
		}else{
			//$val = '<a href="javascript:void(0)" title="Please login to follow" onclick="alert(\'Please Login to Follow this User!\')">'.changeLngF("Follow", $_SESSION["lng"]).'</a>';
			
			$val = '<a href="javascript:void(0)" title="Please login to follow" style="cursor: auto;">'.changeLngF("Follow", $_SESSION["lng"]).'</a>';
		}
	}
	return $val;
}

function getUserFollowBtn($uid){
	$userid= $_SESSION['user_id'];
	if($userid!=$uid){
		if($userid){
			$sql = db_query("select * from user_follow where userid ='".$userid."' and followto ='".$uid."'");
			$numrow = mysqli_num_rows($sql);
			if($numrow > 0){
				$val = '<button class="btn btn_gradisnt btn_follow" onclick="unfollowUser('.$uid.')>Following</button>';
			}else{
				$val = '<button class="btn btn_gradisnt btn_follow" onclick="followUser('.$uid.')">'.changeLngF("Follow", $_SESSION["lng"]).'</button>';
			}
		}else{
			//$val = '<button class="btn btn_gradisnt btn_follow" onclick="alert(\'Please Login to Follow this User!\')">'.changeLngF("Follow", $_SESSION["lng"]).'</button>';
			
			$val = '<button class="btn btn_gradisnt btn_follow" title="Please Login to Follow this User!" style="cursor: auto;">'.changeLngF("Follow", $_SESSION["lng"]).'</button>';
		}
	}
	return $val;
}

/* Share Video */
function shareVideo($vid){
	$userid= $_SESSION['user_id'];
	$val = '<a class="dropdown-item" onclick="shareVideo('.$vid.')" href="javascript:void(0)">'.changeLngF("Share", $_SESSION["lng"]).'</a>';
	return $val;
}

/* Save Video */
function saveVideo($vid){
	$userid= $_SESSION['user_id'];
	if($userid){
		$sql = db_query("select * from user_savedvideos where userid ='".$userid."' and video_id ='".$vid."'");
		$numrow = mysqli_num_rows($sql);
		if($numrow > 0){
			$val = '<a class="dropdown-item">'.changeLngF("Saved", $_SESSION["lng"]).'</a>';
		}else{
			$val = '<a class="dropdown-item" href="javascript:void(0)" onclick="saveVideo('.$vid.')" id="save-'.$vid.'">'.changeLngF("Save", $_SESSION["lng"]).'</a>';
		}
	}else{
		//$val = '<a class="dropdown-item" href="javascript:void(0)" onclick="alert(\'Please Login to save video!\')">'.changeLngF("Save", $_SESSION["lng"]).'</a>';
		$val = '<a class="dropdown-item" href="javascript:void(0)" title="Please Login to save video!" style="cursor: auto;">'.changeLngF("Save", $_SESSION["lng"]).'</a>';
	}
	return $val;
}


/* Block User */
function blockUser($uid){
	$userid= $_SESSION['user_id'];
	if($userid){
		$sql = db_query("select * from user_blocked where blockby ='".$userid."' and blockto ='".$uid."'");
		$numrow = mysqli_num_rows($sql);
		if($numrow > 0){
			$val = '<a class="dropdown-item">'.changeLngF("Blocked", $_SESSION["lng"]).'</a>';
		}else{
			$val = '<a class="dropdown-item" href="javascript:void(0)" onclick="blockUser('.$uid.')">'.changeLngF("Block User", $_SESSION["lng"]).'</a>';
		}
	}else{
		//$val = '<a class="dropdown-item" href="javascript:void(0)" onclick="alert(\'Please Login to block user!\')">'.changeLngF("Block User", $_SESSION["lng"]).'</a>';
		$val = '<a class="dropdown-item" href="javascript:void(0)" title="Please Login to block user!" style="cursor: auto;">'.changeLngF("Block User", $_SESSION["lng"]).'</a>';
	}
	return $val;
}


/* Report Video */
function reportFlag($vid){
	$userid= $_SESSION['user_id'];
	if($userid){
		$sql = db_query("select * from user_report where reportby ='".$userid."' and video_id ='".$vid."'");
		
		$numrow = mysqli_num_rows($sql);
		if($numrow > 0){
			$val = '<a class="dropdown-item">'.changeLngF("Reported", $_SESSION["lng"]).'</a>';
		}else{
			$val = '<a class="dropdown-item" href="javascript:void(0)" onclick="reportFlag('.$vid.')" id="report-'.$vid.'">'.changeLngF("Report/Flag", $_SESSION["lng"]).'</a>';
		}
	}else{
		//$val = '<a class="dropdown-item" href="javascript:void(0)" onclick="alert(\'Please Login to report video!\')">'.changeLngF("Report/Flag", $_SESSION["lng"]).'</a>';
		
		$val = '<a class="dropdown-item" href="javascript:void(0)" style="cursor: auto;" title="Please Login to report video!">'.changeLngF("Report/Flag", $_SESSION["lng"]).'</a>';
	}
	return $val;
}

/* GET Category From ID */
function getCategory($catid){
	$fieldnm = "category_".$_SESSION['lng'];
	$sql = db_query("select * from `mng_category` where id='".$catid."'");
	$row = mysqli_fetch_array($sql);
	$category = $row[$fieldnm];
	if($category==""){
		$category = $row['category_en'];
	}
	return $category;
}

/* GET Subscribe Info */
function getSubscribeInfo(){
	$sql = db_query("select followfee ,followduration  from mng_cost_breakdown");
	$row = mysqli_fetch_array($sql);
	$followfee	 = $row['followfee'];
	$followduration	 = $row['followduration'];
	
	$object = new stdClass();
	$object->followfee = priceChange($followfee);
	$object->followduration = $followduration;
	return $object;
}

function getCostBreakup(){
	$sql = db_query("select *  from mng_cost_breakdown");
	$row = mysqli_fetch_array($sql);
	
	$object = new stdClass();
	$object->jarnazifee 	= $row['jarnazifee'];
	$object->processingfee 	= $row['processingfee'];
	$object->vat 			= $row['vat'];
	$object->followfee 		= $row['followfee'];
	$object->followduration = $row['followduration'];
	$object->userfollowfee 	= $row['userfollowfee'];
	$object->clearday 		= $row['clearday'];
	$object->clearday_cheque= $row['clearday_cheque'];
	$object->withdrawamt 	= $row['withdrawamt'];
	$object->videolength 	= $row['videolength'];
	$object->mduration 		= $row['mduration'];
	$object->membershipfee 	= $row['membershipfee'];
	return $object;
}

/* Check Account Status */
function checkAccount($uid){
	$today 	 = date("Y-m-d H:i:s");
	$sql = db_query("select account_type, renew_dt, upgrade_dt from mng_members where id='".$uid."'");
	$row = mysqli_fetch_array($sql);
	$actype = $row['account_type'];
	if($actype=='Premium'){
		if($row['renew_dt'] < $today){
			$actype = 'Free';
		}
	}
	return $actype;
}


/* Display Video Comments */
function displayComment($vid){
	$sql = db_query("select * from `video_comments` where video_id='".$vid."' order by comment_date desc limit 0,5");
	while($row = mysqli_fetch_array($sql)){
		print '<div class="comment">
				<span class="profile_img"><img src="'.getUserInfo($row['userid'])->profilepic.'"></span>
				<p><a href="javascript:void(0)">'.getUserInfo($row['userid'])->name.'</a> '.$row['comment'].'</p>
				<div class="clearfix"></div>
			</div>';
	}
}

/* Get Language Translate */

function googleTranslatetext($string,$from,$to){

    $apiKey = 'AIzaSyBT5KNaIV7pLoXYn_g7tLG_en5tiuUALGQ';
    $url = 'https://www.googleapis.com/language/translate/v2?key='.$apiKey.'&q='. rawurlencode($string).'&source='.$from.'&target='.$to;

    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($handle);                 
    $responseDecoded = json_decode($response, true);
    curl_close($handle);

    return $responseDecoded['data']['translations'][0]['translatedText'];
}



function changeLng($value, $lng){
	if($lng=='en'){
		$myword =  $value;		
	}else{
		$str = file_get_contents('words.json');
		$json = json_decode($str, true);
		
		foreach ($json['words'] as $word) {
			if (strtolower($word['en']) == strtolower($value)) {
				$myword =  $word[$lng];
			}
		}
	}
	if($myword==""){ $myword =  googleTranslatetext($value,'en',$lng); }
	print $myword;
}

function changeLngF($value, $lng){
	if($lng=='en'){
		$myword =  $value;		
	}else{
		$str = file_get_contents('words.json');
		$json = json_decode($str, true);
		
		foreach ($json['words'] as $word) {
			if (strtolower($word['en']) == strtolower($value)) {
				$myword =  $word[$lng];
			}
		}
	}
	if($myword==""){ $myword =  googleTranslatetext($value,'en',$lng); }
return $myword;
}

function chageURL($str) {
    $str = str_replace("%", "-", $str);
    $str = str_replace("#", "-", $str);
    $str = str_replace("!", "-", $str);
    $str = str_replace("@", "-", $str);
    $str = str_replace("^", "-", $str);
    $str = str_replace("*", "-", $str);
    $str = preg_replace('/\s\&+/', '-', $str);
    $str = preg_replace("/\s/", "-", $str);
    $str = preg_replace('/\-\-+/', '-', $str);
    $str = str_replace("(", "-", $str);
    $str = str_replace(")", "-", $str);
    $str = str_replace("(", "-", $str);
    $str = str_replace(")", "_", $str);
    $str = str_replace("_", "-", $str);
    $str = str_replace("&", "-", $str);
    $str = str_replace("'", "-", $str);
    $str = preg_replace('/\-\-+/', '-', $str);
    $str = rtrim(strtolower($str), '');
    return $str;
}

function pageurl(){
	$sql = db_query("select page_url from about_me"); 
	$row = mysqli_fetch_array($sql);
	$aboutme  = $row['page_url'];
	
	$sql2 = db_query("select page_url from contact_us"); 
	$row2 = mysqli_fetch_array($sql2);
	$contactme  = $row2['page_url'];
		
	$sql2 = db_query("select page_url from seo"); 
	$row2 = mysqli_fetch_array($sql2);
	$home  = $row2['page_url'];
	
	$object = new stdClass();
	$object->aboutme = $aboutme;
	$object->contactme 	= $contactme;
	$object->home 	= $home;
	
	
	return $object;
}


function linkname(){
	$lng = $_SESSION['lng'];
	$sql = db_query("select linkname,pageurl from mng_howitworks where language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname,pageurl from mng_howitworks where language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$howitworks  = $row['linkname'];
	
	
	$sql = db_query("select linkname,pageurl from mng_aboutus where language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname,pageurl from mng_aboutus where language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$aboutus  = $row['linkname'];	
	
	$sql = db_query("select linkname,pageurl from mng_premiummember where language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname,pageurl from mng_premiummember where language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$premiummember  = $row['linkname'];
	
	$sql = db_query("select linkname,pageurl from mng_contactus where language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname,pageurl from mng_contactus where language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$contactus  = $row['linkname'];
	
	$sql = db_query("select linkname,pageurl from mng_privacy where language='".$lng."'");

	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname,pageurl from mng_privacy where language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$privacy  = $row['linkname'];
	
	$sql = db_query("select linkname,pageurl from mng_terms where language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname,pageurl from mng_terms where language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$terms  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='categories' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='categories' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$categories  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='myprofile' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='myprofile' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$myprofile  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='myaccount' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='myaccount' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$myaccount  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='myposts' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='myposts' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$myposts  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='myscheduled' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='myscheduled' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$myscheduled  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='mysaved' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='mysaved' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$mysaved  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='mypurchases' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='mypurchases' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$mypurchases  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='mysales' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='mysales' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$mysales  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='cp' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='cp' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$cp  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='fp' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='fp' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$fp  = $row['linkname'];

	$sql = db_query("select linkname  from mng_seo where cpage='cart' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='cart' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$cart  = $row['linkname'];	
	
	$sql = db_query("select linkname  from mng_seo where cpage='upgradeaccount' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='upgradeaccount' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$upgradeaccount  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='notifications' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='notifications' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$notifications  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='uploadvideo' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='uploadvideo' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$uploadvideo  = $row['linkname'];
	
	$sql = db_query("select linkname  from mng_seo where cpage='playvideo' and language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select linkname  from mng_seo where cpage='playvideo' and language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$playvideo  = $row['linkname'];
	
	
	
	$object = new stdClass();
	$object->howitworks = $howitworks;
	$object->aboutus 	= $aboutus;
	$object->mng_premiummember 	= $mng_premiummember;
	$object->contactus 	= $contactus;
	$object->privacy 	= $privacy;
	$object->terms 		= $terms;
	$object->categories = $categories;
	$object->myprofile 	= $myprofile;
	$object->myaccount 	= $myaccount;
	$object->myposts 	= $myposts;
	$object->myscheduled= $myscheduled;
	$object->mysaved 	= $mysaved;
	$object->mypurchases= $mypurchases;
	$object->mysales	= $mysales;
	$object->cp			= $cp;
	$object->fp			= $fp;
	$object->cart		= $cart;
	$object->upgradeaccount		= $upgradeaccount;
	$object->notifications		= $notifications;
	$object->uploadvideo		= $uploadvideo;
	$object->playvideo	= $playvideo;
	
	return $object;
}

function footerText(){
	$lng = $_SESSION['lng'];
	$sql = db_query("select * from mng_footer_text where language='".$lng."'");
	$numrow = mysqli_num_rows($sql);
	if($numrow==0){
	$sql = db_query("select * from mng_footer_text where language='en'");
	}
	$row = mysqli_fetch_array($sql);
	$logotext  	= $row['logotext'];
	$copyright  = $row['copyright'];
	
	$object = new stdClass();
	$object->logotext = $logotext;
	$object->copyright= $copyright;

	return $object;
}

/* SEO Tags */

function pageSEO($page,$lng){
$sql = db_query("select * from mng_seo where language='".$lng."' and cpage='".$page."'");
if(mysqli_num_rows($sql)==0){
$sql = db_query("select * from mng_seo where language='en' and cpage='".$page."'");	
}
$row = mysqli_fetch_array($sql);
	$object = new stdClass();
	$object->metatitle 		= $row['metatitle'];
	$object->metadescription= $row['metadescription'];
	$object->metakeywords	= $row['metakeywords'];
	$object->moretags		= $row['moretags'];

	return $object;
}


function checkPaypal(){
	$sql = db_query("select status from mng_paypal");
	$row = mysqli_fetch_array($sql);
	$status = $row['status'];
	
	$sql2 = db_query("select * from `mng_paypal` where paymentmode='".$status."'"); 
	$row2 = mysqli_fetch_array($sql2);
	
	$object = new stdClass();
	$object->paymentmode = $row2['paymentmode'];
	$object->accountname = $row2['accountname'];
	$object->apiusername = $row2['apiusername'];
	$object->apipassword = $row2['apipassword'];
	$object->signature 	= $row2['signature'];
	$object->clientid 	= $row2['clientid'];
	$object->secretkey 	= $row2['secretkey'];

	return $object;
	
}

function showhide(){
	$sql = db_query("select * from showhide");
	$row = mysqli_fetch_array($sql);
	$cashoutcheque = $row['cashoutcheque'];

	$object = new stdClass();
	$object->cashoutcheque = $row['cashoutcheque'];

	return $object;
	
}

function totalMembers(){
	$sql = db_query("select id from `mng_members` where user_status='1'");
	$numrows = mysqli_num_rows($sql);
	return $numrows;
}

function totalSubscribe(){
	$sql = db_query("select id from `user_subscribe` where status='1'");
	$numrows = mysqli_num_rows($sql);
	return $numrows;
}

function totalVideos(){
	$sql = db_query("select id from `user_videos` where status='1'");
	$numrows = mysqli_num_rows($sql);
	return $numrows;
}

function videoSales(){
	$sql = db_query("select SUM(`price`) from `orderdetails` where video_id !='0'");
	$row = mysqli_fetch_array($sql);
	return $row[0];
}

function videoSubscribe(){
	$sql = db_query("select SUM(`price`) from `orderdetails` where video_id ='0'");
	$row = mysqli_fetch_array($sql);
	return $row[0];
}

function totalRevenue(){
	$sql = db_query("select SUM(`price`) from `orderdetails`");
	$row = mysqli_fetch_array($sql);
	return $row[0];
}


/* pagination function */
function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
{
    $pagination = '';
    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
		$pagination .= '<ul class="totpage"><li><span>Page 1 of  '.$total_pages.'</span></li></ul>';
        $pagination .= '<ul class="pagination">';
        
        $right_links    = $current_page + 3; 
        $previous       = $current_page - 3; //previous link 
        $next           = $current_page + 1; //next link
        $first_link     = true; //boolean var to decide our first link
        
        if($current_page > 1){
			$previous_link = ($previous==0 or $previous<0)? 1: $previous;
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page="1" title="First">&laquo;</a></li>'; //first link
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
                    if($i > 0){
                        $pagination .= '<li><a class="page-link" href="javascript:void(0)" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
                    }
                }   
            $first_link = false; //set first link to false
        }
        
        if($first_link){ //if current active page is first link
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" style="color:#000;">'.$current_page.'</a></li>';
        }elseif($current_page == $total_pages){ //if it's the last active link
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" style="color:#000;">'.$current_page.'</a></li>';
        }else{ //regular current link
            $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0);" style="color:#000;">'.$current_page.'</a></li>';
        }
                
        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
            if($i<=$total_pages){
                $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
            }
        }
        if($current_page < $total_pages){ 
				$next_link = ($i > $total_pages) ? $total_pages : $i;
                $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
                $pagination .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
        }
        
        $pagination .= '</ul>'; 
    }
    return $pagination; //return pagination links
}

/* Admin Module Check */

function adminAccess($adminid, $admintype, $module){
	$access = 1;
	/*if($admintype=='admin'){
		$access = 1;
	}else{
		$sql = db_query("select * from `user_to_modules` where user_id='".$adminid."' and module_id ='".$module."' and view='1'");
		//print "select * from `user_to_modules` where user_id='".$adminid."' and module_id ='".$module."' and view='1'";
		$numrow = mysqli_num_rows($sql);
		if($numrow >0){
			$access = 1;	
		}
	}*/
	return $access;
}

$Banners 		= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '17');
$CMSPages 		= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '18');
$SEO 			= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '19');
$Category 		= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '20');
$Members 		= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '21');
$Language 		= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '22');
$Notification 	= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '23');
$PayPal 		= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '24');
$CostBreakdown 	= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '25');
$EmailContent 	= adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '26');
$ShowHideSection = adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '27');
$Newsletter	 = adminAccess($_SESSION['admin_id'], $_SESSION['admin_type'], '28');



//$secretKey 	 = "6Le1iMQZAAAAACiGyABDDnSI8NokrV9wXPIOKAfK"; //"6Lf3wvMUAAAAAFC6f9F3wI3sjj0Xst1ALiA9WxhB";//; //* "6LeKEu4UAAAAAADCJzxHWUjE2OnBws1yaQkD0jJl"; *//
//$sitekey	 = "6Le1iMQZAAAAAHdtXEPbHJI387Y1Oi3PFnGW7c-y";// "6Lf3wvMUAAAAAPUQ1_MFcGpww3FLoHG5fQeQQ2H-"; // //* "6LeKEu4UAAAAAJwv78nhWbrCs9pqLm75mf1BTspv"; *//

$secretKey 	 = "6LdgT8EaAAAAAAANAtf9CQwXeS09jXdSKARxwrE8";//; //* "6LeKEu4UAAAAAADCJzxHWUjE2OnBws1yaQkD0jJl"; *//
$sitekey	 = "6LdgT8EaAAAAAD_Wvav7FjjzctCJOTafy-pi8rnh"; // //*

?>
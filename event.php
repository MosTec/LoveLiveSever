<?php  

$currentEventId = htmlspecialchars($_GET["eventId"]);

//发送地址
$url = "https://api.leancloud.cn/1.1/classes/event/".$currentEventId;

$avosId = "m3pwKv6vfV9BqdId6oV9Jd2d-gzGzoHsz";
$avosKey = "vKMRTFHtdIFckoiE6PxiMYEp";
$avosMaster = "cpwHOPgah8BeYR0T2BIOVHXh,master";
//请求头内容
$headers = array(
    'X-LC-Id: '.$avosId,
    'X-LC-Key: '.$avosKey,
);
//使用curl发送
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
$output_arr = json_decode($result,true);
curl_close($ch);

$eventCover = $output_arr['coverUrl'];
$eventTitle = $output_arr['eventTitle'];
$eventDescripiton = $output_arr['eventDescription'];

$eventTime = $output_arr['startTime']['iso'];
$eventLocation = $output_arr['eventLocation'];
$eventPrice = $output_arr['price'];

// HTML start

echo "<!DOCTYPE html>
<html>";

// HTML header

echo "<head>
		<meta charset=\"UTF-8\">
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0,minimum-scale=1.0,user-scalable=no\"/>
		<title>$eventTitle</title>
	</head>";

// HTML body

echo "<body>";

// bannerImg

echo "<div class=\"imgArea\"><img class=\"coverImage\" src=$eventCover></div>";

// eventTitle

echo "<div class=\"eventTitle\">$eventTitle</div>";

// eventDescription

echo "<div class=\"descriptionArea\">
			<div class=\"content_header_abstract\">
               <span id=\"Js_abstract\" class=\"content_header_text\">
                  $eventDescripiton
               </span>
               <img class=\"content_header_text_l\" src=\"http://school.5lovelive.com/static/wap/img/sign_left_black@3x.png\" />
               <img class=\"content_header_text_r\" src=\"http://school.5lovelive.com/static/wap/img/sign_right_black@3x.png\" />
            </div>
      </div>";

// seperator

echo "<div class=\"seperator\"></div>";

// eventDetail

echo "<div class = \"eventDetail\">
	<div class = \"eventInfo\">
		<img class=\"eventInfoIco\" src=\"../images/pro_time@3x.png\">
		<span class=\"eventInfoText\">$eventTime</span>
	</div>
	<div class = \"eventInfo\">
		<img class=\"eventInfoIco\" src=\"../images/pro_address@3x.png\">
		<span class=\"eventInfoText\">$eventLocation</span>
	</div>
	<div class = \"eventInfo\">
		<img class=\"eventInfoIco\" src=\"../images/pro_price@3x.png\">
		<span class=\"eventInfoText\">$eventPrice</span>
	</div>
	<span class=\"eventInfoHint\">温馨提示：演出票劵为特殊商品，一经卖出赎不退换。</span>
</div>";

// seperator

echo "<div class=\"seperator\"></div>";


//发送地址
$hotEventUrl = "https://api.leancloud.cn/1.1/scan/classes/hotevent?include=linkEvent";

//使用curl发送
$chHot = curl_init($hotEventUrl);
curl_setopt($chHot, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chHot, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($chHot, CURLOPT_SSL_VERIFYHOST, false);
$mheaders = array(
    'X-LC-Id: '.$avosId,
    'X-LC-Key: '.$avosMaster,
);
curl_setopt($chHot, CURLOPT_HTTPHEADER, $mheaders);
$hotResults = curl_exec($chHot);
$hotResultsArr = json_decode($hotResults,true);
curl_close($chHot);

$hotEvents = $hotResultsArr['results'];

for ($i=0; $i < count($hotEvents); $i++) { 
	# code...
	$subEventDic = $hotEvents[$i]['linkEvent'];
	// events

	$subEvent_title = $subEventDic['eventTitle'];
	$subEvent_cover = $subEventDic['coverUrl'];
	$subEvent_time = $subEventDic['startTime']['iso'];
	$subEvent_location = $subEventDic['eventLocation'];
	$subEvent_price = $subEventDic['price'];
	$subEvent_tag = $subEventDic['tag'];
	$subEvent_id = $subEventDic['objectId'];

	echo "<a href=\"http://mos-tec-5lovelive.daoapp.io/event.php?eventId=$subEvent_id\"><div class=\"eventCell\">
		<img class=\"eventCover\" src=$subEvent_cover>
		<div class=\"info\">
			<span class=\"eventTitle\">$subEvent_title</span> <br></br>
			<span class=\"eventTime\">时间：$subEvent_time</span> <br></br>
			<span class=\"eventLocation\">地点：$subEvent_location</span> <br></br>
			<div class=\"tagBorder\">
				<span class=\"eventTag\">$subEvent_tag</span> 
			</div> <br></br>
		</div>
		<div class=\"eventPriceBorder\">
				<span class=\"eventPrice\">$subEvent_price</span> 
			</div>
		<div class=\"eventLine\"></div>
	</div></a>";
}

// bottomLink

echo "<a href=\"lovelive://event_$subEvent_id\">
		<div class=\"node_footer_bar\">		
         <img src=\"../images/bottom.png\" />
         <div class=\"open_button\" >打开</div>
      </div></a>";

// HTML bodyEnding
echo "</body>";

// HTML ending

echo "</html>";
?>

<style type="text/css">

html{
	 width:100%;
	 height:100%;
	 margin:0;
	 padding:0;
}
html body{
    width: 100%;
    height: 100%;
    font-family: '微软雅黑',sans-serif;
    font-size: 15px;
    color: #5f5f5f;
    line-height: 100%;
    margin: 0;
    padding: 0;
}

.imgArea{
	width: 100%;
	height: 200px;
	overflow: hidden;
}

.imgArea .coverImage{
	width: 100%;
}

.eventTitle{
	float: left;
    width: 100%;
    text-align: center;
    font-size: 18px;
    color: #3C3C3C;
    line-height: 25px;
    margin-top: 10px;
    margin-bottom: 20px;
}

.descriptionArea{
	float: left;
    width: 100%;
    margin-bottom: 10px;
}

.descriptionArea .content_header_text_l {
	position: absolute;
	top: -8px;
	left: -10px;
	width: 6px;
	height:15px;
}

.descriptionArea .content_header_text_r {
	position: absolute;
	bottom: -8px;
	right: -10px;
	width: 6px;
	height:15px;
}

.descriptionArea .content_header_abstract {
 	float: left;
 	word-wrap: break-word;
 	margin-left: 25px;
 	margin-right: 25px;
 	margin-bottom: 15px;
 	position: relative;
 }

.descriptionArea .content_header_abstract .content_header_text {
	width: 100%;
	word-wrap: break-word;
	display: block;
	font-size: 14px;
	line-height: 22px;
}

.seperator{
	width: 100%;
	height: 10px;
	float: left;
    width: 100%;
	background-color: #F6F6F6;
}

.eventDetail{
    float: left;
 	word-wrap: break-word;
 	margin-left: 15px;
 	margin-right: 15px;
 	margin-bottom: 15px;
}

.eventDetail .eventInfo{
	width: 100%;
	height: 20px;
	margin-top: 10px;
	margin-bottom: 10px;
}

.eventDetail .eventInfo .eventInfoIco{
	float: left;
	width: 20px;
	height:20px;
}

.eventDetail .eventInfo .eventInfoText{
	float: left;
	margin-left: 15px;
	font-size: 14px;
	line-height: 20px;
}

.eventDetail .eventInfoHint{
	word-wrap: break-word;
	display: block;
	font-size: 10px;
	color: #7B7B7B;
	line-height: 15px;
}

.eventCell{
	float: left;
	width: 100%;
	height: 150px;
	margin-top: 15px;
}

.eventCell .eventCover{
	float: left;
	margin-left: 15px;
	width: 88px;
	height: 116px;
}

.eventCell .info{
	position: absolute;
	margin-top: 0px;
	margin-left: 115px;
	float: right;
	height: 116px;
}

.eventCell .info .eventTitle{
	float: left;
	margin-left: 0px;
	margin-top: 0px;
	text-align: left;
	font-size: 12px;
	font-weight: bold;
	line-height: 20px;
}

.eventCell .info .eventTime{
	float: left;
	text-align: left;
	margin-left: 0px;
	margin-top: 0px;
	font-size: 12px;
	color: #7B7B7B;
	line-height: 20px;
}

.eventCell .info .eventLocation{
	float: left;
	text-align: left;
	margin-left: 0px;
	margin-top: 0px;
	font-size: 12px;
	color: #7B7B7B;
	line-height: 20px;
}

.eventCell .eventPriceBorder{
	float: right;
	margin-top: 86px;
	margin-right: 0px;
	padding-left: 10px;
	padding-right: 10px;
	height: 25px;
	background-color: black;
	border-bottom-left-radius: 12.5px;
	border-top-left-radius: 12.5px;
	border-width: 1px;
	border-color: black;
}
.eventCell .eventPriceBorder .eventPrice{
	float: right;
	text-align: right;
	color: white;
	font-size: 15px;
	line-height: 25px;
}

.eventCell .info .tagBorder{
	float: left;
	margin-left: 0px;
	margin-top: 0px;
	padding-left: 5px;
	padding-right: 5px;
	border-width: 2px;
	border-color: #7B7B7B;
	border-radius: 4px;
	background-color: black;
	height: 15px;
}
.eventCell .info .tagBorder .eventTag{
	float: left;
	text-align: left;
	color: white;
	font-size: 10px;
	line-height: 15px;
}

.eventCell .eventLine{
	margin-top: 140px;
	margin-left: 15px;
	height: 1px;
	background-color: #F6F6F6;
}


/*主界面 底部菜单 start*/
.node_footer_bar {position:fixed;height: 44px;width: 100%;background: #3F3F3F;opacity: 0.95;bottom: 0px;}
.node_footer_bar img {float: left;margin-left: 0px;margin-top: 0px;width: 167px;height: 44px;opacity:1!important;}
.node_footer_bar .footer_bar_text {float: left; margin-top: 7px; margin-left: 6px; margin-right: 0px; width: 140px;height: 50px;
	color: #fff;opacity:1!important;font-size: 14px;line-height: 19px;}
.node_footer_bar .footer_bar_text .footer_bar_text_button {font-size: 12px;opacity:1!important;}
.node_footer_bar .open_button {float: right;width: 80px;height: 30px;margin-top: 7px;margin-right: 14px;background: #E93956;border-radius: 4px;
	text-align: center;line-height: 30px;color: #fff;opacity:1!important;}


</style>
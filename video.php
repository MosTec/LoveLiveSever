<?php  

$currentEventId = htmlspecialchars($_GET["eventId"]);

//发送地址
$url = "http://mos-tec-5lovelive.daoapp.io/QiniuTokenImage.php";
//请求头内容
// $headers = array(
//     'Authorization: '.$basic,
//     'suibianzhi: '.$basic,
// );
//使用curl发送
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
$output_arr = json_decode($result,true);
curl_close($ch);
// echo $output_arr['uploadToken'];

$eventTitle = $currentEventId;
$eventDescripiton = "eventDescripiton";

$eventTime = "sdfsdfs";
$eventLocation = "sdjfksdjfsdkfsdf";
$eventPrice = "sdfsdfsdfsdfsdfsfdsdf";

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

echo "<img class=\"coverImage\" src=\"https://tse2-mm.cn.bing.net/th?id=OIP.M4368e18bcf9c002eaccfd483b5cb256do0&pid=15.1\">";

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
		<img class=\"eventInfoIco\" src=\"../LoveLiveSever/images/pro_time@3x.png\">
		<span class=\"eventInfoText\">$eventTime</span>
	</div>
	<div class = \"eventInfo\">
		<img class=\"eventInfoIco\" src=\"../LoveLiveSever/images/pro_address@3x.png\">
		<span class=\"eventInfoText\">$eventLocation</span>
	</div>
	<div class = \"eventInfo\">
		<img class=\"eventInfoIco\" src=\"../LoveLiveSever/images/pro_price@3x.png\">
		<span class=\"eventInfoText\">$eventPrice</span>
	</div>
	<span class=\"eventInfoHint\">温馨提示：演出票劵为特殊商品，一经卖出赎不退换。</span>
</div>";

// seperator

echo "<div class=\"seperator\"></div>";

// events

$subEvent_title = "eventtitle";
$subEvent_cover = "http://7xs856.com1.z0.glb.clouddn.com/activity16.jpg?imageView2/1/w/166/h/238/q/50/format/jpg";
$subEvent_time = "eventTime";
$subEvent_location = "eventLocation";
$subEvent_price = "eventPrice";
$subEvent_tag = "eventTag";
$subEvent_id = "";

echo "<a href=\"http://localhost/LoveliveSever/video.php\"><div class=\"event\">
	<img class=\"eventCover\" src=$subEvent_cover>
	<span class=\"eventTitle\">$subEvent_title</span> 
	<span class=\"eventTime\">$subEvent_time</span> 
	<span class=\"eventLocation\">$subEvent_location</span> 
	<div class=\"eventPriceBorder\">
	<span class=\"eventPrice\">$subEvent_price</span> 
	</div>
	<div class=\"tagBorder\">
	<span class=\"eventTag\">$subEvent_tag</span> 
	</div>
	<div class=\"eventLine\"></div>
</div></a>";

// bottomLink

echo "<a href=\"lovelive://event_$subEvent_id\">
		<div class=\"node_footer_bar\">		
         <img src=\"../LoveLiveSever/images/bottom.png\" />
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
	 width:100%;
	 height:100%;
	 font-family:'微软雅黑',sans-serif;font-size:15px;
	 color:#5f5f5f;
	 line-height:100%;margin:0;
	 padding:0;
	 -webkit-text-size-adjust:none;
	 -o-text-size-adjust:none;
}
.coverImage{
	width: 100%;
	height: 200px;
	overflow: hidden;
}

.eventTitle{
	float: left;
    width: 100%;
    height: 25px;
    text-align: center;
    font-size: 18px;
    color: #3C3C3C;
    line-height: 25px;
    margin-top: 10px;
    margin-bottom: 10px;
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
 	position: relative;
}

.eventDetail .eventInfo{
	width: 100%;
	height: 20px;
	margin-top: 10px;
	margin-bottom: 10px;
}

.eventDetail .eventInfo .eventInfoIco{
	margin-left: 0px;
	margin-top: 0px;
	width: 20px;
	height:20px;
}

.eventDetail .eventInfo .eventInfoText{
	position: absolute;
	margin-left: 5px;
	margin-top: 2.5px;
	font-size: 15px;
	height: 15px;
}

.eventDetail .eventInfoHint{
	word-wrap: break-word;
	display: block;
	font-size: 10px;
	color: #7B7B7B;
	line-height: 15px;
}

.event{
	float:left; 
	width: 100%;
	height: 146px;
	margin-top: 0px;
}

.event .eventCover{
	width: 88px;
	height: 116px;
	margin-top: 15px;
	margin-left: 15px;
	border-radius: 4;
	overflow: hidden; 
}

.event .eventTitle{
	position: absolute;
	text-align: left;
	margin-left: 15px;
	margin-top: 15px;
	font-size: 12px;
	font-weight: bold;
	line-height: 34px;
}

.event .eventTime{
	position: absolute;
	text-align: left;
	margin-left: 15px;
	margin-top: 57px;
	font-size: 12px;
	color: #7B7B7B;
	line-height: 16px;
}

.event .eventLocation{
	position: absolute;
	text-align: left;
	margin-left: 15px;
	margin-top: 72px;
	font-size: 12px;
	color: #7B7B7B;
	line-height: 34px;
}

.event .eventPriceBorder{
	float: right;
	margin-top: 106px;
	margin-right: -10px;
	padding-left: 10px;
	padding-right: 20px;
	padding-top: 5px;
	height: 25px;
	background-color: black;
	border-radius: 12.5px;
	border-width: 1px;
	border-color: black;
}
.event .eventPriceBorder .eventPrice{
	float: right;
	text-align: right;
	color: white;
	font-size: 15px;
	line-height: 15px;
}

.event .tagBorder{
	float: left;
	position: absolute;
	margin-left: 115px;
	margin-top: -20px;
	padding-left: 5px;
	padding-right: 5px;
	padding-top: 5px;
	border-width: 2px;
	border-color: #7B7B7B;
	border-radius: 4px;
	background-color: black;
	height: 15px;
}
.event .tagBorder .eventTag{
	float: left;
	text-align: left;
	color: white;
	font-size: 10px;
	line-height: 10px;
}

.event .eventLine{
	position: absolute;
	margin-top: 15px;
	margin-left: 15px;
	width: 100%;
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
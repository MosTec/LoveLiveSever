<?php
/* *
 * Ping++ Server SDK
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可根据自己网站需求按照技术文档编写, 并非一定要使用该代码。
 * 接入 webhooks 流程参考开发者中心：https://www.pingxx.com/docs/webhooks/webhooks
 * 该代码仅供学习和研究 Ping++ SDK 使用，仅供参考。
 */

require 'vendor/autoload.php';

/* *
 * 验证 webhooks 签名方法：
 * raw_data：Ping++ 请求 body 的原始数据即 event ，不能格式化；
 * signature：Ping++ 请求 header 中的 x-pingplusplus-signature 对应的 value 值；
 * pub_key_path：读取你保存的 Ping++ 公钥的路径；
 * pub_key_contents：Ping++ 公钥，获取路径：登录 [Dashboard](https://dashboard.pingxx.com)->点击管理平台右上角公司名称->开发信息-> Ping++ 公钥
 */
function verify_signature($raw_data, $signature, $pub_key_path) {
    $pub_key_contents = file_get_contents($pub_key_path);
    // php 5.4.8 以上，第四个参数可用常量 OPENSSL_ALGO_SHA256
    return openssl_verify($raw_data, base64_decode($signature), $pub_key_contents, 'sha256');
}

$raw_data = file_get_contents('php://input');
// 示例
// $raw_data = '{"id":"evt_eYa58Wd44Glerl8AgfYfd1sL","created":1434368075,"livemode":true,"type":"charge.succeeded","data":{"object":{"id":"ch_bq9IHKnn6GnLzsS0swOujr4x","object":"charge","created":1434368069,"livemode":true,"paid":true,"refunded":false,"app":"app_vcPcqDeS88ixrPlu","channel":"wx","order_no":"2015d019f7cf6c0d","client_ip":"140.227.22.72","amount":100,"amount_settle":0,"currency":"cny","subject":"An Apple","body":"A Big Red Apple","extra":{},"time_paid":1434368074,"time_expire":1434455469,"time_settle":null,"transaction_no":"1014400031201506150354653857","refunds":{"object":"list","url":"/v1/charges/ch_bq9IHKnn6GnLzsS0swOujr4x/refunds","has_more":false,"data":[]},"amount_refunded":0,"failure_code":null,"failure_msg":null,"metadata":{},"credential":{},"description":null}},"object":"event","pending_webhooks":0,"request":"iar_Xc2SGjrbdmT0eeKWeCsvLhbL"}';

$headers = \Pingpp\Util\Util::getRequestHeaders();
// 签名在头部信息的 x-pingplusplus-signature 字段
$signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;
// 示例
// $signature = 'BX5sToHUzPSJvAfXqhtJicsuPjt3yvq804PguzLnMruCSvZ4C7xYS4trdg1blJPh26eeK/P2QfCCHpWKedsRS3bPKkjAvugnMKs+3Zs1k+PshAiZsET4sWPGNnf1E89Kh7/2XMa1mgbXtHt7zPNC4kamTqUL/QmEVI8LJNq7C9P3LR03kK2szJDhPzkWPgRyY2YpD2eq1aCJm0bkX9mBWTZdSYFhKt3vuM1Qjp5PWXk0tN5h9dNFqpisihK7XboB81poER2SmnZ8PIslzWu2iULM7VWxmEDA70JKBJFweqLCFBHRszA8Nt3AXF0z5qe61oH1oSUmtPwNhdQQ2G5X3g==';

// Ping++ 公钥，获取路径：登录 [Dashboard](https://dashboard.pingxx.com)->点击管理平台右上角公司名称->开发信息-> Ping++ 公钥
$pub_key_path = __DIR__ . "/pingpp_rsa_public_key.pem";

$result = verify_signature($raw_data, $signature, $pub_key_path);
if ($result === 1) {
    // 验证通过
} elseif ($result === 0) {
    http_response_code(400);
    echo 'verification failed';
    exit;
} else {
    http_response_code(400);
    echo 'verification error';
    exit;
}

$event = json_decode($raw_data, true);
if ($event['type'] == 'charge.succeeded') {
    $charge = $event['data']['object'];
    $orderId = $event['data']['object']['order_no'];

    // ...
    // updateOrderInfo

    $url = "https://api.leancloud.cn/1.1/classes/order/".$orderId;

    $avosId = "m3pwKv6vfV9BqdId6oV9Jd2d-gzGzoHsz";
    $avosKey = "vKMRTFHtdIFckoiE6PxiMYEp";
    $avosMaster = "cpwHOPgah8BeYR0T2BIOVHXh,master";
    //请求头内容
    $headers = array(
        'X-LC-Id: '.$avosId,
        'X-LC-Key: '.$avosKey,
        "Content-type:application/json"
    );

    $parameters = json_encode(array('paymentStatus' => 1));

    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); //定义请求地址
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); //定义请求类型，当然那个提交类型那一句就不需要了
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);//定义header
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters); //定义提交的数据
    $res = curl_exec($ch);
    curl_close($ch);//关闭

    echo $res;

    ////// send message //////

    $url1 = "https://api.leancloud.cn/1.1/classes/order/".$orderId."?include=linkEvent,linkTicket,linkStage";

    $avosId1 = "m3pwKv6vfV9BqdId6oV9Jd2d-gzGzoHsz";
    $avosKey1 = "vKMRTFHtdIFckoiE6PxiMYEp";
    $avosMaster1 = "cpwHOPgah8BeYR0T2BIOVHXh,master";
    //请求头内容
    $headers1 = array(
        'X-LC-Id: '.$avosId1,
        'X-LC-Key: '.$avosKey1,
    );

    //使用curl发送s
    $ch1 = curl_init($url1);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch1, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);
    $result1 = curl_exec($ch1);
    $output_arr1 = json_decode($result1,true);
    curl_close($ch1);

echo $result1;

    $phoneNumber = $output_arr1['contactPhone'];
    $eventTitle = $output_arr1['linkEvent']['eventTitle'];
    $eventLocation = $output_arr1['linkEvent']['eventLocation'];
    $ticketName = $output_arr1['linkTicket']['ticketName'];
    $stageName = $output_arr1['linkStage']['stageTitle'];
    $count = $output_arr1['count'];

    /////////////////// 发送短信 /////////////////
    $urlsend="http://120.55.197.77:1210/Services/MsgSend.asmx/SendMsg";

    $msg = "亲爱的爱现场用户，您成功购买".$eventTitle."活动".$stageName."场".$count."张".$ticketName."，请准时前往".$eventLocation."参与活动。详细信息请下载爱现场APP。【爱现场】";

    $token=array("userCode"=>"axc","userPass"=>"axc123","DesNo"=>$phoneNumber,"Msg"=>$msg,"Channel"=>"0");

    function http($url,$param,$action="GET"){
        $ch=curl_init();
        $config=array(CURLOPT_RETURNTRANSFER=>true,CURLOPT_URL=>$url);  
        if($action=="POST"){
            $config[CURLOPT_POST]=true;     
        }
        $config[CURLOPT_POSTFIELDS]=http_build_query($param);
        curl_setopt_array($ch,$config); 
        $result=curl_exec($ch); 
        curl_close($ch);
        return $result;
    }
    echo http($urlsend,$token,"GET"); //get请求



    http_response_code(200); // PHP 5.4 or greater
} elseif ($event['type'] == 'refund.succeeded') {
    $refund = $event['data']['object'];
    // ...
    http_response_code(200); // PHP 5.4 or greater
} else {
    /**
     * 其它类型 ...
     * - summary.daily.available
     * - summary.weekly.available
     * - summary.monthly.available
     * - transfer.succeeded
     * - red_envelope.sent
     * - red_envelope.received
     * ...
     */
    http_response_code(200);

    // 异常时返回非 2xx 的返回码
    // http_response_code(400);
}

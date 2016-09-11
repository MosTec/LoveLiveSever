<?php
require 'vendor/autoload.php';

use Qiniu\Auth;

$accessKey = '15N9SEyTMq02s5Pc6aiGw88CVt0hHiWyJwni-h8w';
$secretKey = '3N16T8zKi4vwlvFcYrt4UkpgL4ZdIsQcbA_w5bsV';
$auth = new Auth($accessKey, $secretKey);

$bucket = 'll-video-ing';

$pfop = "avthumb/m3u8";

//转码完成后通知到你的业务服务器。（公网可以访问，并相应200 OK）
$notifyUrl = 'http://notify.fake.com';

//独立的转码队列：https://portal.qiniu.com/mps/pipeline
$pipeline = 'll-video-ing-task';

$policy = array(
    'persistentOps' => $pfop,
    'persistentNotifyUrl' => $notifyUrl,
    'persistentPipeline' => $pipeline
);
$token = $auth->uploadToken($bucket, null, 3600, $policy);

$result = array('uploadToken' => $token);

echo json_encode($result);

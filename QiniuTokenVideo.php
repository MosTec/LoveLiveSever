<?php
require 'vendor/autoload.php';

use Qiniu\Auth;

$accessKey = 'Access_Key';
$secretKey = 'Secret_Key';
$auth = new Auth($accessKey, $secretKey);

$bucket = 'Bucket_Name';

$pfop = "avthumb/m3u8";

//转码完成后通知到你的业务服务器。（公网可以访问，并相应200 OK）
$notifyUrl = 'http://notify.fake.com';

//独立的转码队列：https://portal.qiniu.com/mps/pipeline
$pipeline = 'pipeline_name';

$policy = array(
    'persistentOps' => $pfop,
    'persistentNotifyUrl' => $notifyUrl,
    'persistentPipeline' => $pipeline
);
$token = $auth->uploadToken($bucket, null, 3600, $policy);

$result = array('uploadToken' => $token);

echo json_encode($result);

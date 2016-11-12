<?php
require 'vendor/autoload.php';

use Qiniu\Auth;

header('Access-Control-Allow-Origin:*');

$accessKey = '15N9SEyTMq02s5Pc6aiGw88CVt0hHiWyJwni-h8w';
$secretKey = '3N16T8zKi4vwlvFcYrt4UkpgL4ZdIsQcbA_w5bsV';
$auth = new Auth($accessKey, $secretKey);

$bucket = 'llhead';
$upToken = $auth->uploadToken($bucket);

$result = array('uploadToken' => $upToken);

echo json_encode($result);

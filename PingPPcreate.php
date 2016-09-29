<?php
require 'vendor/autoload.php';
/**
 * Ping++ Server SDK
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可根据自己网站需求按照技术文档编写, 并非一定要使用该代码。
 * 接入支付流程参考开发者中心：https://www.pingxx.com/docs/server/charge ，文档可筛选后端语言和接入渠道。
 * 该代码仅供学习和研究 Ping++ SDK 使用，仅供参考。
 */

// api_key 获取方式：登录 [Dashboard](https://dashboard.pingxx.com)->点击管理平台右上角公司名称->开发信息-> Secret Key
$api_key = 'sk_test_9uDyX5T8mzr1aPCuXPbnvv5K';
// app_id 获取方式：登录 [Dashboard](https://dashboard.pingxx.com)->点击你创建的应用->应用首页->应用 ID(App ID)
$app_id = 'app_4SCuf5L4CqzHWHan';

// 此处为 Content-Type 是 application/json 时获取 POST 参数的示例
$input_data = json_decode(file_get_contents('php://input'), true);
if (empty($input_data['channel']) || empty($input_data['amount'])) {
    echo 'channel or amount is empty';
    exit();
}
$channel = strtolower($input_data['channel']);
$amount = $input_data['amount'];
$orderNo = $input_data['orderNo'];
$client_ip = $input_data['client_ip'];
$subject = $input_data['subject'];
$body = $input_data['body'];


/**
 * 设置请求签名密钥，密钥对需要你自己用 openssl 工具生成，如何生成可以参考帮助中心：https://help.pingxx.com/article/123161；
 * 生成密钥后，需要在代码中设置请求签名的私钥(rsa_private_key.pem)；
 * 然后登录 [Dashboard](https://dashboard.pingxx.com)->点击右上角公司名称->开发信息->商户公钥（用于商户身份验证）
 * 将你的公钥复制粘贴进去并且保存->先启用 Test 模式进行测试->测试通过后启用 Live 模式
 */

// 设置私钥内容
// \Pingpp\Pingpp::setPrivateKeyPath(__DIR__ . '/your_rsa_private_key.pem');

/**
 * $extra 在使用某些渠道的时候，需要填入相应的参数，其它渠道则是 array()。
 * 以下 channel 仅为部分示例，未列出的 channel 请查看文档 https://pingxx.com/document/api#api-c-new；
 * 或直接查看开发者中心：https://www.pingxx.com/docs/server/charge；包含了所有渠道的 extra 参数的示例；
 */
$extra = array();

\Pingpp\Pingpp::setApiKey($api_key);// 设置 API Key
try {
    $ch = \Pingpp\Charge::create(
        array(
            //请求参数字段规则，请参考 API 文档：https://www.pingxx.com/api#api-c-new
            'subject'   => $subject,
            'body'      => $body,
            'amount'    => $amount,//订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
            'order_no'  => $orderNo,// 推荐使用 8-20 位，要求数字或字母，不允许其他字符
            'currency'  => 'cny',
            'extra'     => $extra,
            'channel'   => $channel,// 支付使用的第三方支付渠道取值，请参考：https://www.pingxx.com/api#api-c-new
            'client_ip' => $client_ip,// 发起支付请求客户端的 IP 地址，格式为 IPV4，如: 127.0.0.1
            'app'       => array('id' => $app_id)
        )
    );
	$result = array('charge' => $ch);
	echo json_encode($result);
} catch (\Pingpp\Error\Base $e) {
    // 捕获报错信息
    $result = array('error' => $e->getMessage());
	echo json_encode($result);
}

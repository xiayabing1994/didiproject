<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/20
 * Time: 9:49
 */
namespace tybservice;
use think\Log;
use think\Config;
class TybAliPay
{
    public static function alipay($orderid,$order_no,$money)
    {
        //振航通用航空正式环境公钥
        $pubSecret = '';
        //振航通用航空正式环境私钥
        $priSecret ='';
        vendor('alipay.AopSdk');
        $aop = new \AopClient;
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";//正式环境
        //振航通用航空正式环境
        $aop->appId = "";
        $aop->rsaPrivateKey = $priSecret;
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey = $pubSecret;
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizcontent = "{\"body\":\"振航订单支付\","
            . "\"subject\": \"振航通用航空订单支付\","
            . "\"out_trade_no\": \"$order_no\","
            . "\"timeout_express\": \"1m\","
            . "\"total_amount\": \"$money\","
            . "\"product_code\":\"QUICK_MSECURITY_PAY\","
            . "\"passback_params\":\"$orderid\""
            . "}";
        $request->setNotifyUrl(Config::get('HOST_SERVER')."/index.php/pay/Alipay/BackReceive");
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        //return htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
        return $response;
    }

    public static function checkSign($sign){
        vendor('alipay.AopSdk');
        //振航正式环境
        $pubSecret = '';
        $aop = new \AopClient;
        $aop->alipayrsaPublicKey = $pubSecret;
        $flag = $aop->rsaCheckV1($sign, NULL, "RSA2");
        return $flag;
    }
}
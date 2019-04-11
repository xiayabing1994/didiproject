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

    private $ali_config;
    public function __construct(){
        $this->ali_config=load_config('alipay');
    }
    public  function alipay($orderinfo)
    {
        //振航通用航空正式环境公钥
        $pubSecret = $this->ali_config['ali_public_key'];
        //振航通用航空正式环境私钥
        $priSecret =$this->ali_config['ali_private_key'];
        vendor('alipay.AopSdk');
        $aop = new \AopClient;
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";//正式环境
        //振航通用航空正式环境
        $aop->appId = $this->ali_config['ali_appid'];
        $aop->rsaPrivateKey = $priSecret;
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey = $pubSecret;
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizcontent = "{\"body\":\"{$orderinfo['body']}\","
            . "\"subject\": \"{$orderinfo['body']}\","
            . "\"out_trade_no\": \"{$orderinfo['order_no']}\","
            . "\"timeout_express\": \"1m\","
            . "\"total_amount\": \"{$orderinfo['money']}\","
            . "\"product_code\":\"QUICK_MSECURITY_PAY\","
            . "\"passback_params\":\"{$orderinfo['order_no']}\""
            . "}";
        $request->setNotifyUrl($orderinfo['notify_url']);
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        //return htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
        return $response;
    }

    public  function checkSign($post){
        vendor('alipay.AopSdk');
        //振航正式环境
        $pubSecret =$this->ali_config['ali_public_key'];
        $aop = new \AopClient;
        $aop->alipayrsaPublicKey = $pubSecret;
        $flag = $aop->rsaCheckV1($post, NULL, "RSA2");
        return $flag;
    }
}
<?php
namespace  app\wap\controller;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
/**
 * Class 支付相关处理类
 * @package app\wap\controller
 */
class Pay extends Base{
    private $app;
    public function __construct(){
        $wx_config=model('Config')->getConfig('weixin');
        $this->app = new Application($wx_config);
    }
    public function wxPay(){
        $payment = $this->app->payment;
        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => '1217752501201407033233368018',
            'total_fee'        => 5388, // 单位：分
            'notify_url'       => 'http://xxx.com/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];

        $order = new Order($attributes);
//        $result = $payment->pay($order);//刷卡支付
        $result = $payment->prepare($order);  //公众号支付、扫码支付、APP 支付
        return $result;

//        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
//            $prepayId = $result->prepay_id;
//        }
    }
    public function detail(){
        return view('merge_detail');
    }

    /**
     * 支付信息处理
     */
    public function pay(){
    }
}
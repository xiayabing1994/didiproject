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
    public function pay(){
        $data=input('param.');
        $order=new \logicmodel\Orderlogic();
        $orderinfo=$order->createOrders(22,$data['p_id'],'sub',$data['paytype']);
        if(!empty($orderinfo)){
            echo '创建'.$data['paytype'].'订单成功';
            if($data['paytype']=='weixin') $this->wxPay($orderinfo['orderdata']);
            if($data['paytype']=='alipay') $this->aliPay($orderinfo['orderdata']);
        }else{
            $this->error('创建支付订单失败');
        }
    }
    private function wxPay($data){
        $payment = $this->app->payment;
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP...
            'body'             => $data['describe'],
            'detail'           => $data['describe'],
            'out_trade_no'     => $data['order_no'],
            'total_fee'        => $data['money']*100, // 单位：分
            'notify_url'       => '/wap/pay/notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => '', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        $order = new Order($attributes);
//        $result = $payment->pay($order);//刷卡支付
        $result = $payment->prepare($order);  //公众号支付、扫码支付、APP 支付
        dump($result);
//        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
//            $prepayId = $result->prepay_id;
//        }
    }
    public function aliPay($data){
        $orderdata=[
            'body'=>$data['describe'],
            'order_no'=>$data['order_no'],
            'money'=>$data['money'],
            'notify_url'=> '/wap/pay/notify'
        ];
        $alipayModel=new \tybservice\TybAliPay();
        dump($alipayModel->alipay($orderdata));
    }
    /**
     * 支付信息处理
     */
     public function notify(){
         $data=input('param.');
         $verify=1;
         if($verify==1){
             if(model('\logicmodel\Orderlogic')->dealOrder($data)) return 'success';
             return 'failed';
         }else{

         }
     }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/7
 * Time: 9:54
 */
namespace app\api\controller;
use think\Request;
use EasyWeChat\Foundation\Application;
class Order
{
    private $_request;
    private $_orderlogic;
    private $app;
    public function __construct(Request $request,\logicmodel\Orderlogic $orderlogic)
    {
        $this->_request=$request;
        $this->_orderlogic = $orderlogic;

    }
    public function getPayList(){
        $res=$this->_orderlogic->getPaymentList();
        if(empty($res)) return json(['errcode'=>2,'msg'=>'暂无支付通道']);
        return json(['errcode'=>0,'msg'=>'获取支付通道成功','result'=>$res]);
    }
    public function pay(){
        $data=input('param.');
        if(empty($data['userid']) || empty($data['p_id']) ||empty($data['ordertype']) || empty($data['paytype']) ){
            return json(['errcode'=>2,'msg'=>'参数错误','data'=>$data]);
        }
        $orderinfo=$this->_orderlogic->createOrders($data['userid'],$data['p_id'],$data['ordertype'],$data['paytype']);
        if(!empty($orderinfo)){
            $payfunc=$data['paytype'].'Pay';
            $res= $this->$payfunc($orderinfo['orderdata']);
            return json(['errcode'=>0,'msg'=>'创建订单成功','result'=>$res]);
        }else{
            return json(['errcode'=>4,'msg'=>'创建订单失败']);
        }
    }

    private function weixinPay($data){
        $wx_config=model('app\wap\model\Weixin')->getWxConfig();
        $this->app = new Application($wx_config);
        $payment = $this->app->payment;
        $attributes = [
            'trade_type'       => 'APP', // JSAPI，NATIVE，APP...
            'body'             => $data['describe'],
            'detail'           => $data['describe'],
            'out_trade_no'     => $data['order_no'],
//            'total_fee'        => $data['money']*100, // 单位：分
            'total_fee'        => 1, // 单位：分
            'notify_url'       => request()->domain().'/api/order/weixin_notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
//            'openid'           => '111', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        $order = new \EasyWeChat\Payment\Order($attributes);
        //$result = $payment->pay($order);//刷卡支付
        $result = $payment->prepare($order);  //公众号支付、扫码支付、APP 支付
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            $prepayId = $result->prepay_id;
            return $config = $payment->configForAppPayment($prepayId);
//            ksort($config);
//            return $this->toSignString($config);
        }
    }
    private function alipayPay($data){
        $orderdata=[
            'body'=>$data['describe'],
            'order_no'=>$data['order_no'],
//            'money'=>$data['money'],
            'money'=>0.01,
            'notify_url'=> request()->domain().'/api/order/alipay_notify'
        ];
        $alipayModel=new \tybservice\TybAliPay();
        return $alipayModel->alipay($orderdata);
    }
    /**
     * 支付回调信息处理
     */
    public function alipay_notify(){
        $data=input('param.');
//        $data=json_decode('{"gmt_create":"2019-04-11 17:54:22","charset":"UTF-8","seller_email":"pay@chinafeifang.com","subject":"\u652f\u4ed8\u5c3e\u6b3e","sign":"cYLp4PIA1gX4sHXXY7gyA+0ir5O9O\/QZUNZe9APXZhFM3CMmFq5QvMZBuU2\/t1o8rHLbl9mHBtrZxarJsj8sclKiw5UcTSlGpXjgAbzIRFkoKV\/Fr6eWHTOcxYUCAY8QHyBpzJkcmoMR146QF+zear\/n5VKX46edrBns1GBtmq9bBUsblw7X2tYbtCpasj8LkGVCoFfbhujqqmOPKVl4giXNWFV5KyPP7JawuEf4LNNGdrTJGnAjm7Jko\/xdUZij+2eF8WyC7xVtKOR8UYjCD8029F\/0woduf\/JZSp+hj3gJ9+u1JDnD0syMsVY604Ga5gM4ticLF08CxZvtQTZMmA==","body":"\u652f\u4ed8\u5c3e\u6b3e","buyer_id":"2088612336985500","invoice_amount":"0.01","notify_id":"2019041100222175423085501012019584","fund_bill_list":"[{\"amount\":\"0.01\",\"fundChannel\":\"ALIPAYACCOUNT\"}]","notify_type":"trade_status_sync","trade_status":"TRADE_SUCCESS","receipt_amount":"0.01","app_id":"2019040163752270","buyer_pay_amount":"0.01","sign_type":"RSA2","seller_id":"2088431904301771","gmt_payment":"2019-04-11 17:54:23","notify_time":"2019-04-11 17:57:44","passback_params":"ali2019041117543089418","version":"1.0","out_trade_no":"ali2019041117543089418","total_amount":"0.01","trade_no":"2019041122001485501037525723","auth_app_id":"2019040163752270","buyer_logon_id":"155****1707","point_amount":"0.00"}',true);
        file_put_contents('./pay_log.txt',date('H:i:s').'支付宝:'.json_encode($data)."\r\n",FILE_APPEND);
        $alipayModel=new \tybservice\TybAliPay();
        $verify=$alipayModel->checkSign($data);
        if($verify){
            $orderinfo=[
                'out_no'=>$data['trade_no'],
                'paymoney'=>$data['total_amount'],
                'order_no'=>$data['out_trade_no'],
                'state'=>$data['trade_status']=='TRADE_SUCCESS' ? 1 : 4,
                'pay_account'=>$data['buyer_logon_id'],
            ];
            file_put_contents('./pay_log.txt',date('H:i:s').json_encode($orderinfo)."\r\n",FILE_APPEND);
            if($this->_orderlogic->dealOrder($orderinfo)) return 'success';
            return 'failed';
        }else{

        }
    }
    public function weixin_notify(){
        $wx_config=model('app\wap\model\Weixin')->getWxConfig();
        $this->app = new Application($wx_config);
        $response = $this->app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            file_put_contents('./pay_log.txt',date('H:i:s').'微信:'.json_encode($notify)."\r\n",FILE_APPEND);
            $orderinfo=[
                'out_no'=>$notify['transaction_id'],
                'paymoney'=>$notify['total_fee']/100,
                'order_no'=>$notify['out_trade_no'],
                'state'=>$notify['result_code']=='SUCCESS' ? 1 : 4,
                'pay_account'=>'',
            ];
            if($this->_orderlogic->dealOrder($orderinfo)) return 'success';
            return 'failed';
        });
        return $response;
    }
    private function toSignString($arr){
        $str='';
        foreach($arr as $key=>$val){
            $str.=$key.'='.$val.'&';
        }
        return $str;
    }


}
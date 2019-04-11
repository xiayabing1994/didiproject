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
        file_put_contents('./pay_log.txt',date('H:i:s').json_encode($data)."\r\n",FILE_APPEND);
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
        $data=input('param.');
        file_put_contents('./pay_log.txt',date('H:i:s').json_encode($data)."\r\n",FILE_APPEND);
        $response = $this->app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $orderinfo=[
                'out_no'=>$notify['trade_no'],
                'paymoney'=>$notify['total_fee'],
                'order_no'=>$notify['out_trade_no'],
                'state'=>$notify['result_code']=='SUCCESS' ? 1 : 4,
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
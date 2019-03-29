<?php
namespace paymodel;
use think\Exception;
use datamodel\Order;
class  Alipaymodel
{
    //根据订单号、订单时间、订单总价，创建订单
    public static function createAlipay($orderid)
    {
        try {

            $orderModel=new \logicmodel\Orderlogic();
            $where['id']=$orderid;
            $fields=['*'];
            $res=$orderModel->getOrderInfo($where,$fields);
            if($res['payfrom'==0])
            {
                if($res[0]['orderstate']==0){
                    throw  new Exception('该订单已经支付成功，请不要重复支付','15');
                }
                $orderno=$res['orderno'].mt_rand(10000,99999);
                $money=$res['money'];
                $res = \tybservice\TybAliPay::alipay($orderid,$orderno,$money);
                \think\Log::record('支付包返回数据'.$res);
                return ['errcode'=>0,'msg'=>'success','result'=>['paystr'=>$res]];
            }else
                {
                    if($res[0]['orderstate']==0){
                        throw  new Exception('该订单已经支付成功，请不要重复支付','15');
                    }
                    $orderno=$res['orderno'].mt_rand(10000,99999);
                    $money=$res['money'];
                    $summoney=$res['summoney'];
                    $remainmoney=bcsub($summoney,$money,2);
                    $res = \tybservice\TybAliPay::alipay($orderid,$orderno,$remainmoney);
                    \think\Log::record('支付包返回数据'.$res);
                    return ['errcode'=>0,'msg'=>'success','result'=>['paystr'=>$res]];
                }
            }

        catch (Exception $e)
        {
            return ['errcode'=>$e->getCode(),'msg'=>$e->getMessage()];
        }
    }

    /**支付宝支付回调
     * @param $res
     * @return string
     * @throws Exception
     */
    public static function payResult($res){
        $res['fund_bill_list']=htmlspecialchars_decode($res['fund_bill_list']);
        \think\Log::record('支付宝回调数据为'.json_encode($res),'INFO');
        $checkRes = \tybservice\TybAliPay::checkSign($res);
        \think\Log::record('验签结果为'.json_encode($checkRes),'INFO');
        if(($res['trade_status'] === 'TRADE_SUCCESS')&&($checkRes===true)){
            \paymodel\MyNotify::notify($res['passback_params'],'支付宝',$res['trade_no']);
        }else{
            \think\Log::record('支付宝支付的订单：'.$res['out_trade_no'].':处理失败,交易状态为'. $res['trade_status'],'INFO');
        }
        return "";
    }

    /**
     * @param $orderid
     * @param $paysn
     * @param $paytime
     * @throws Exception
     */
    public static function wxPayResult($orderid,$paysn){

        \paymodel\MyNotify::notify($orderid,'微信支付',$paysn);
        return "";
    }

 
}
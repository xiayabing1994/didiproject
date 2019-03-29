<?php
/**
 * Created by PhpStorm.
 * UserManager: Administrator
 * Date: 2017/5/31
 * Time: 16:02
 */
namespace paymodel;
use logicmodel;
class MyNotify
{
    /**支付回调
     * @param $orderid
     * @param $payname
     * @param $paysn
     * @throws \think\Exception
     */
    public static function notify($orderid,$payname,$paysn)
    {
        \think\Log::record("MyNotify类:{$payname} 回调来了，orderid:{$orderid}");
        $orderModel= new logicmodel\Orderlogic();
        $landModel = new logicmodel\Landlogic();
        $pOrderModel = new \logicmodel\Porderlogic();
        $pOrderNumModel = new logicmodel\Pordernumlogic();
        $priceModel = new logicmodel\Pricelogic();
        $orderInfo=$orderModel->getOrderInfo(['id'=>$orderid],['*']);
        $landid = $orderInfo['landid'];
        $landids= explode(",", $landid);
        $porderid = $orderInfo['porderid'];
        $porderNumId=$orderInfo['pordernumid'];
        if($orderInfo['payfrom']==0)
        {
            $porderInfo=$pOrderModel->getPorderInfo(['id'=>$porderid],['*']);
           // $pordernumInfo = $pOrderNumModel->getPorderNumInfo(['id'=>$porderNumId],['*']);
            foreach ($landids as $v)
            {
                $area = $landModel->LandInfo(['id'=>$v],['area'])['area'];
                $area+=$area;
            }
            $hasland=bcadd($porderInfo['hasland'],$area,2);
            if($hasland>=$porderInfo['sumarea'])
            {
                $price = $priceModel->getNowPrice(['area'=>['>=',$porderInfo['sumarea']]],['price'],null,['price desc'])[0]['price'];
                $summoney=bcmul($price,$porderInfo['sumarea'],2);
                $pOrderModel->updatepOederInfo(['id'=>$porderid],['summoney'=>$summoney,'price'=>$price,'hasland'=>$hasland,'state'=>2]);
                $orderModel->updateOrderInfo(['id'=>$orderid],['state'=>0]);
                $pOrderNumModel->updatepOrderInfo(['id'=>$porderNumId],['state'=>2]);
            }else
                {
                    $pOrderModel->updatepOederInfo(['id'=>$porderid],['hasland'=>$hasland,'state'=>0]);
                    $orderModel->updateOrderInfo(['id'=>$orderid],['state'=>0]);
                    $pOrderNumModel->updatepOrderInfo(['id'=>$porderNumId],['state'=>0]);
                }
        }else
            {
                $orderModel->updateOrderInfo(['id'=>$orderid],['state'=>0]);
                $pOrderNumModel->updatepOrderInfo(['id'=>$porderNumId],['state'=>3]);
                $pOrderModel->updatepOederInfo(['id'=>$porderid],['state'=>0]);
            }


    }

}
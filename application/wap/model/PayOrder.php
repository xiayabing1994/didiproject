<?php
namespace  app\wap\model;
use think\Db;
class PayOrder extends Base{
    /**
     * 创建支付订单
     */
    public function createOrders($userId, $pOrderNumId, $payfrom = 0)
    {
        $rate = load_config('peace')['land_sub_rate'];
        $OrderNum = $this->createOrderNo($userId);
        $originalPrice = load_config('peace')['land_unit_price'];
        $res =Db::name('pordernum')->where('id',$pOrderNumId)->find();
        $pOrderNum = $res['pordernum'];
        $landid = $res['landid'];
        $porderid = $res['porderid'];
        $area=model('Land')->getLandArea($res['landid']);
        $money = bcmul($area, $originalPrice, 2);
        $money = bcmul($money, $rate, 2);
        $orderData = [
            'userid' => $userId,
            'pordernum' => $pOrderNum,
            'landid' => $landid,
            'ordernum' => $OrderNum,
            'rate' => $rate,
            'porderid' => $porderid,
            'money' => $money,
            'pordernumid' => $pOrderNumId,
            'payfrom' => $payfrom,
            'createtime' => date('Y-m-d H:i:s')
        ];
        $orderData['describe'] = explain_payfrom($payfrom);
        $orderId = Db::name('order')->insertGetId($orderData);
        if($orderId>0){
            return ['orderid'=>$orderId,'orderdata'=>$orderData];
        }
        return false;
    }
    private function createOrderNo($userId){
        return date('YmdHis') . $userId . mt_rand(100000, 999999);
    }

}
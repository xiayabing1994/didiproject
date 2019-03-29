<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/7
 * Time: 10:23
 */
namespace logicmodel;
class Orderlogic
{
    private $_order;
    private $_pordernum;
    private $_porder;
    private $_land;
    public function __construct()
    {
        $this->_order=new \datamodel\Order();
        $this->_pordernum = new \datamodel\Pordernum();
        $this->_porder = new \datamodel\Porder();
        $this->_land = new \datamodel\Land();
    }

    /**创建拼单
     * @param $userId int 用户id
     * @param $pOrderNumId int 拼单人员表id
     * @return array
     */
    public function createOrders($userId,$pOrderNumId,$payfrom)
    {
        $rate=0.20;
        $OrderNum=$this->createOrderNo($userId);
        $originalPrice='12.00';
        $res=$this->_pordernum->queryfind(['id'=>$pOrderNumId],['*']);
        $pOrderNum=$res['pordernum'];
        $landid = $res['landid'];
        $porderid=$res['porderid'];
        $landids= explode(",", $landid);
        foreach ($landids as $v)
        {
            $area = $this->_land->queryfind(['id'=>$v],['area'])['area'];
            $area+=$area;

        }
        $money=bcmul($area,$originalPrice,2);
        $money=bcmul($money,$rate,2);
        if($payfrom==0)
        {
            $orderData=['userid'=>$userId,'pordernum'=>$pOrderNum,'landid'=>$landid,'ordernum'=>$OrderNum,'rate'=>$rate,'porderid'=>$porderid,'money'=>$money,'pordernumid'=>$pOrderNumId,'createtime'=>date('Y-m-d H:i:s')];
            $orderId=$this->_order->addEntityReturnID($orderData);
        }else
            {
                $orderData=['userid'=>$userId,'pordernum'=>$pOrderNum,'landid'=>$landid,'payfrom'=>1,'ordernum'=>$OrderNum,'rate'=>$rate,'porderid'=>$porderid,'money'=>$money,'pordernumid'=>$pOrderNumId,'createtime'=>date('Y-m-d H:i:s')];
                $orderId=$this->_order->addEntityReturnID($orderData);
            }
        if($orderId>0)
        {
            return ['errcode'=>0,'msg'=>'success','result'=>['orderid'=>$orderId]];
        }else
            {
                return ['errcode'=>1,'msg'=>false];
            }

    }

    /**创建订单
     * @param $userId
     * @return string
     */
    private function createOrderNo($userId)
    {
        return date('YmdHis') . $userId . mt_rand(100000, 999999);
    }

    /**获取订单信息
     * @param $where
     * @param $fields
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function getOrderInfo($where,$fields)
    {
        return $this->_order->queryfind($where,$fields);
    }

    /**修改订单状态
     * @param $where
     * @param $field
     * @return false|int
     */
    public function changeOrderState($where,$field)
    {
        return $this->_order->updateEntity($where,$field);
    }

    /**上传分组值
     * @param $userId
     * @param $orderId
     * @param $groupId
     * @return array
     */
    public function addGrounpId($userId,$porderId,$groupId)
    {
        $res=$this->_pordernum->updateEntity(['porderid'=>$porderId,'userid'=>$userId],['groupid'=>$groupId]);
        if($res!==false)
        {
            return ['errcode'=>0,'msg'=>'success'];
        }else
        {
            return ['errcode'=>0,'msg'=>'fasle'];
        }
    }

    public function updateOrderInfo($where,$data)
    {
        return $this->_order->updateEntity($where,$data);
    }

}
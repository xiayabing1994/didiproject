<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/7
 * Time: 10:23
 */
namespace logicmodel;
use think\Db;
class Orderlogic
{
    private $_order;
    private $_pordernum;
    private $_porder;
    private $_pordernumlogic;
    private $_pilot;
    public function __construct()
    {
        $this->_order=new \datamodel\Order();
        $this->_pordernum = new \datamodel\Pordernum();
        $this->_porder = new \datamodel\Porder();
        $this->_pordernumlogic = new \logicmodel\Pordernumlogic();
    }

    /**
     * 创建支付订单
     */
    public function createOrders($userId,$pOrderNumId,$ordertype='sub',$paytype='weixin')
    {
        $order_no=$paytype=='weixin' ? 'wx'.$this->createOrderNo($userId) : 'ali'.$this->createOrderNo($userId);
        $res=$this->_pordernum->queryfind(['id'=>$pOrderNumId],['*']);
        $porderid=$res['porderid'];
        $money=$this->_pordernumlogic->getPorderMoney($res['id']);
        $orderData=[
            'userid'=>$userId,
            'order_no'=>$order_no,
            'money'=>$money,
            'pordernumid'=>$pOrderNumId,
            'ordertype'=>$ordertype,
            'paytype'=>$paytype,
            'createtime'=>time()
        ];
        $orderData['describe']=explain_ordertype($ordertype);
        $orderId=$this->_order->addEntityReturnID($orderData);
        if($orderId>0) return ['orderid'=>$orderId,'orderdata'=>$orderData];
        return false;
    }
    /**
     * 根据订单信息处理订单状态(回调) ['order_no':内部单号,'out_no':外部单号,'paymoney':支付金额,'state':支付状态]
     */
    public function dealOrder($data){
        $pay_order=Db::name('order')->where('order_no',$data['order_no'])->find();
        if($pay_order['isdeal']==1) return true;
        $upd_arr=[
            'out_no'=>$data['out_no'],
            'paymoney'=>$data['paymoney'],
            'paystate'=>$data['state'],   //state: 1=支付成功 4=支付失败
            'paytime'=>time(),
            'pay_account'=>$data['pay_account'],
            'isdeal'=>1
        ];
        $pninfo=Db::name('pordernum')->where('id',$pay_order['pordernumid'])->find();
        //支付成功则更改porder表状态,    sub(订金1=>2) final(尾款2=>3) direct(直下1=>3)
        if($data['state']==1){
            $state=$pay_order['ordertype']=='sub' ?  2  :  3 ;
            $p_upd_arr=['state'=>$state];
            if($state==2) $p_upd_arr['code']=$this->mkInviteCode($pay_order['pordernumid']);
            Db::startTrans();
            try{
                Db::name('land')->where("id in ($pninfo[landid]) ")->update(['state'=>1]);
                Db::name('order')->where('order_no',$data['order_no'])->update($upd_arr);
                Db::name('pordernum')->where('id',$pay_order['pordernumid'])->update($p_upd_arr);
                // 提交事务
                Db::commit();
                return true;
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return false;
            }

        }
        return Db::name('order')->where('order_no',$data['order_no'])->update($upd_arr);
    }

    /**
     * 获取支付列表
     */
    public function getPaymentList(){
        $paytype=load_config('basic')['paytype'];
        if($paytype=='') return [];
        $res=[];
        $type_arr=explode(',',$paytype);
        foreach($type_arr as $v){
            $res[]=['paytype'=>$v,'name'=>explain_paytype($v),'logo'=>get_img_url(load_config($v)[$v.'_logo'])];
        }
        return $res;
    }
    /**
     * 获取订单信息
     */
    public function getOrderInfo($where,$fields)
    {
        return $this->_order->queryfind($where,$fields);
    }

    /**
     * 修改订单状态
     */
    public function changeOrderState($where,$field)
    {
        return $this->_order->updateEntity($where,$field);
    }

    public function updateOrderInfo($where,$data)
    {
        return $this->_order->updateEntity($where,$data);
    }
    /**
     * 根据用户id生成订单号
     */
    private function createOrderNo($userId)
    {
        return date('YmdHi') . $userId . mt_rand(10000, 99999);
    }
    /**
     * 根据参与拼单业务id生成邀请码
     */
    private function mkInviteCode($pid,$length=7){
        return substr($pid.randomkeys(8),0,$length);
    }

}
<?php
namespace  app\wap\model;
use think\Db;
class PayOrder extends Base{
    /**
     * 根据订单信息处理订单状态
     */
    public function dealOrder($data){
        $pay_order=Db::name('order')->where('order_no',$data['order_no'])->find();
        if($pay_order['isdeal']==1) return true;
        $upd_arr=[
            'out_no'=>$data['out_no'],
            'paymoney'=>$data['paymoney'],
            'paystate'=>$data['state'],
            'paytime'=>time(),
            'isdeal'=>1
        ];
        //支付成功则更改porder表状态
        if($data['state']==1){
            $state=$pay_order['ordertype']=='sub' ?  2  :  3 ;
            $p_upd_arr=['state'=>$state];
            Db::startTrans();
            try{
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
    private function createOrderNo($userId){
        return date('YmdHis') . $userId . mt_rand(100000, 999999);
    }

}
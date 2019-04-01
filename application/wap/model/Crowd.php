<?php
namespace  app\wap\model;
use think\Db;
class Crowd extends Base{
    /**
     * 创建porder表发布记录
     */
    public function createCrowd($data){
        unset($data['land_id']);
        unset($data['pesticide']);
        unset($data['area']);
       $data['addtime']=date('Y-m-d H:i');
       $data['userid']=session('user.id');
       $data['pordernum']=mk_crowd_no();
       $data['isleader']=1;
       $data['price']=model('order')->getPrice($data['sumarea']);
       return Db::name('porder')->insertGetId($data);
    }

    /**
     * 获取农药列表
     */
    public function getPesticides(){
        $where=['isdel'=>0];
        return Db::name('pesticide')->where($where)->select();
    }

    /**
     * 创建pordernum表拼单记录
     */
    public function addCrowd($pid,$data){
        $insert_data=[
            'userid'=>session('user.id'),
            'landid'=>$data['land_id'],
            'pesticide'=>$data['pesticide'],
            'porderid'=>$pid,
            'addtime'=>date('Y-m-d  H:i'),
            'pordernum'=>mk_crowd_no(),
            'area'=>$data['area'],
            'price'=>$data['area']*model('Order')->getPrice($data['area']),
        ];
        return Db::name('pordernum')->insertGetId($insert_data);
    }

    /**
     * 根据拼单土地面积获取应付订金金额
     */
    public function getSubMoney($area){
        $pconf=load_config('peace');
        return $area*$pconf['land_unit_price']*$pconf['land_sub_rate'];
    }

    /**
     * 根据podernum表id获取应付金额
     */
    public function getPorderMoney($id){
        $pordernum = new \datamodel\Pordernum();
        $pinfo=$pordernum->queryfind(['id'=>$id],'*');
        $area=$this->getLandArea($id);
        $pconf=load_config('peace');
        $money=0;
        if($pinfo['porderid']>0){   //拼单的操作   分为付定金    付尾款
            $oinfo=db('porder')->where('id',$pinfo['porderid'])->field('hasland,price')->find();
            $price=get_land_price($oinfo['hasland']);
            if($pinfo['state']==1) $money=$area*$pconf['land_unit_price']*$pconf['land_sub_rate'];
            if($pinfo['state']==2) $money=$area*$price-$area*$pconf['land_unit_price']*$pconf['land_sub_rate'];
        }else{    //直接下单的操作  只有全部付款一项
            $money=$area*get_land_price($area);
        }
        return $money;
    }

    /**
     * 根据pordernum表id获取单子下土地总面积
     */
    public function getLandArea($id){
        $pordernum = new \datamodel\Pordernum();
        $pinfo=$pordernum->queryfind(['id'=>$id],'*');
        $landids= explode(",", $pinfo['landid']);
        $area=0;
        foreach ($landids as $v)
        {
            $area+=$this->_land->queryfind(['id'=>$v],['area'])['area'];

        }
        return $area;
    }
}

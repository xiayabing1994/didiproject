<?php
namespace  app\wap\model;
use think\Db;
class Crowd extends Base{
    //创建拼单
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
    public function getPesticides(){
        $where=['isdel'=>0];
        return Db::name('pesticide')->where($where)->select();
    }
    public function addCrowd($pid,$data){
        $insert_data=[
            'userid'=>session('user.id'),
            'landid'=>$data['land_id'],
            'pesticide'=>$data['pesticide'],
            'porderid'=>$pid,
            'addtime'=>date('Y-m-d  H:i'),
            'pordernum'=>mk_crowd_no(),
            'area'=>$data['area'],
        ];
        return Db::name('pordernum')->insertGetId($insert_data);
    }
    public function getSubMoney($area){
        $price=10.00;
        $rate=0.1;
        return $area*$price*$rate;
    }
}

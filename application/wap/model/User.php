<?php
namespace  app\wap\model;
use think\Db;
class User extends Base{
    //获取个人土地
    public function getMyLand($userid){
        $where=[
            'userid'=>$userid,
            'isdel'=>0,
        ];
        return Db::name('land')->where($where)->select();
    }
    //删除个人土地
    public function delLand($landId){
        $upd_arr=['isdel'=>1];
        return Db::name('land')->where('id',$landId)->update($upd_arr);
    }
    //根据userid获取用户信息
    public function getUserInfo($userid){
        if(!$userid) return [];
        $fields=['id','nickname','headimg','mobile','sex'];
        $res=Db::name('user')->where('id',$userid)->field($fields)->find();
        $res['ordercount'] =Db::name('pordernum')->where('userid',$userid)->count();
        $res['remainmoney']=$this->getTotalProfit($userid)['total'];
        return $res;
     }
     //获取用户的个人收益
     public function getTotalProfit($userid){
        $profit_list =Db::name('earnings')->where('userid',$userid)->select();
        $total_profit=Db::name('earnings')->where('userid',$userid)->sum('money');
        return ['total'=>$total_profit,'list'=>$profit_list];
     }

}
<?php
namespace  app\wap\model;
use think\Db;
class Order extends Base{
    public function __construct(){

    }

    /**
     *  根据拼单id获取拼单业务详情信息
     */
    public function getPorderInfo($p_id){
        if(!$p_id>0) return [];
        $row=Db::name('porder')->where(['id'=>$p_id])->find();
        $row['land_points']=$this->getOrderLands($p_id);
        return $row;
    }

    /**
     * 获取某个拼单下的所有土地列表
     */
    public function getOrderLands($p_id){
        $porders=Db::name('pordernum')->where('porderid',$p_id)->select();
        $landid='';
        foreach($porders as $k=>$v){
            $landid.=$v['landid'].',';
        }
        return Db::name('land')->where('id','in',$landid)->field('id,name,point')->select();
    }
    /**
     * 获取个人参与所有拼单
     */
    public function getOrders($userid,$state=''){
        $where['userid']=$userid;
//        $where['porderid']=['>',0];
        if($state!='') $where['state']=$state;
        $orders=Db::name('pordernum')->where($where)->order('addtime desc')->select();
        foreach($orders as $k=>$v){
            $orders[$k]['p_info']=$this->getPorderInfo($v['porderid']);
        }
        return $orders;
    }

    /**
     * 获取个人各种状态订单对应的数量
     */
    public function getOrderStates($userid){
        $res=[];
        $states=Db::name('pordernum')->field('state,count(*) as count ')->where('userid',$userid)->group('state')->select();
        foreach($states as $k=>$v){
            $res[$v['state']]=$v['count'];
        }
        return $res;
    }
    /**
     * 获取附近拼单列表
     */
    public function getAroundOrders($map,$page=1,$size=5){
        $keyword =!empty($map['keyword'])  ? $map['keyword']  : '';
        $landid  =!empty($map['land_id'])  ? $map['land_id']  : '';
        $distance=!empty($map['distance']) ? $map['distance'] : 500000;
        $orderModel=new \logicmodel\Porderlogic();
        //getAroundOrder($userid,$landid,$keyword,$distance,$pageIndex,$pageSize)
        return $orderModel->getAroundOrder(session('user.id'),$landid,$keyword,$distance,$page,$size);
    }
    /**
     * 获取附近拼单列表2
     */
    public function getAroundOrders2($landid='',$page=1,$size=5){
        if(input('map')){
            cookie('search_list',input('map'),86400);
        }
        $res=Db::name('porder')
            ->where(['sumarea'=>['>',0]])
            ->limit($size)
            ->order('addtime','desc')
            ->select();
        foreach($res as $k=>$v){
            $res[$k]['current_price']=$this->getPrice($v['hasland']);
        }
        return $res;
    }

    /**
     * 根据土地面积获取土地单价
     */
    public function getPrice($area){
        $where=[
            'isdel'=>0,
            'area'=>['>',$area]
        ];
        $row=Db::name('price')->where($where)->order('area','asc')->find();
        $price=!empty($row['price']) ?  $row['price'] : 0 ;
        return $price;
    }
}

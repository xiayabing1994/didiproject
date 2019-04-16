<?php
namespace app\api\controller;
use think\Controller;
class Crontab extends Controller{
    public function start(){
        $log=[];
        $pushModel=new \logicmodel\Jpushlogic();
        //1.更改土地拼单完成总亩数
        $porders=db('porder')->where('state','<',3)->select();
        if(empty($porders)) return '无需处理拼单';
        foreach($porders as $k=>$v){
            if($v['state']==1){    //待拼单=>待付尾款
                $where=['porderid'=>$v['id'],'state'=>2];
                $total=db('pordernum')->where($where)->sum('area');
                if($total==$v['hasland']) continue;
                $upd_arr=['hasland'=>$total,'price'=>get_land_price($total)];
                if($total>$v['sumarea']){
                    $upd_arr['state']=2;
                    $pushModel->payFinalPush($v['id']);
                }
                $res=db('porder')->where('id',$v['id'])->update($upd_arr);
                $arr=['res'=>$res,'msg'=>'更改订单总亩数','upd_arr'=>$upd_arr,'porderid'=>$v['id']];
            }elseif($v['state']==2){   //待付尾款=>待作业
                $where=['porderid'=>$v['id'],'state'=>2];
                $pordernums=db('pordernum')->where($where)->select();
                if(empty($pordernums)){
                    $upd_arr=['state'=>3];
                    $res=db('porder')->where('id',$v['id'])->update($upd_arr);
                    $arr=['res'=>$res,'msg'=>'更改状态为待作业','upd_arr'=>$upd_arr,'porderid'=>$v['id']];
                }
                $pushModel->payFinalPush($v['id']);
            }
            if(!empty($arr)) $log[]=$arr;
        }
        return json($log);
    }
}
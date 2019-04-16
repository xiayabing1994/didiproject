<?php
namespace logicmodel;
use think\Db;
class Profitlogic{

    public function __construct(){

    }

    /**
     * 订单完成或尾款完成时
     */
    public function dealAllProfit($porderid){
        $distribute_rate=load_config('peace')['land_distribute_rate'];
        $allInfo=Db::name('pordernum')
            ->alias('a')
            ->field('a.id as childpnumid,a.userid as childid,b.id as pnumid,b.userid as parentid')
            ->join('pordernum b','a.superior_code=b.code')
            ->where("a.superior_code",'>',0)
            ->where('a.porderid',$porderid)
            ->select();
        if(empty($allInfo)) return true;   //没有分享记录则返回true
        foreach($allInfo as $info){
            $profit_arr=[
                'pid'=>$info['pnumid'],
                'childpid'=>$info['childpnumid'],
                'userid'=>$info['parentid'],
                'addtime'=>date("Y-m-d H:i:s"),
                'type'=>'earn',
                'money'=>$distribute_rate*(Db::name('order')
                    ->where(['pordernumid'=>$info['pnumid'],'paystate'=>1])
                    ->sum('money')),
            ];
            dump($profit_arr);
            Db::startTrans();
            try{
                Db::name('profit')->insertGetId($profit_arr);
                Db::name('user')->where('id',$profit_arr['userid'])->setInc('money',$profit_arr['money']);
                Db::name('user')->where('id',$profit_arr['userid'])->setInc('profit',$profit_arr['money']);
                Db::commit();
                continue;
            }catch(\Exception $e){
                Db::rollback();
                return false;
            }
        }
        return true;
    }
}
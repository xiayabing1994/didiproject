<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/6
 * Time: 10:09
 */
namespace logicmodel;
 use think\Log;
 use think\queue\job\Database;
use think\Db;
 class Porderlogic
 {
        private $_porder;
        private $_land;
        private $_pesticide;
        private $_price;
        private $_order;
        private $_pordernum;
        private $pconfig;
        public function __construct()
        {
            $this->pconfig=load_config('peace');
            $this->_porder = new \datamodel\Porder();
            $this->_land = new \datamodel\Land();
            $this->_pesticide = new \datamodel\Pesticide();
            $this->_price = new \datamodel\Price();
            $this->_order = new \datamodel\Order();
            $this->_pordernum = new \datamodel\Pordernum();

        }

        public function getPorderInfo($pid,$userid=0){
            $res=$this->_porder->queryfind(['id'=>$pid],['*']);
            $ori_price=load_config('peace')['land_unit_price'];
            if($userid!=0){
                $where=['userid'=>$userid,'porderid'=>$pid,'state'=>['>',1]];
                $pnum_info=$this->_pordernum->queryfind($where,['userid,landid,pesticide,pid,area,state,code,superior_code']);
                $res['isleader']=$res['userid']==$userid ? 1 : 0 ;
                $res['isjoin']=empty($pnum_info) ? 0 : 1 ;
                $res['joininfo']=$pnum_info;
                $res['leader_name']=model('\logicmodel\Personal')->getUserInfo($res['userid'])['result']['nickname'];
                $res['ori_price']=$ori_price;
            }
            $res['landsinfo']=$this->getLandsInfo($pid);
            return $res;
        }

     /**
      * 附近拼单
      */
        public function getAroundOrder($userid,$landid,$keyword,$distance=10000000,$pageIndex=1,$pageSize=10)
        {
            $where=['userid'=>$userid,'isdel'=>0];
            if(!empty($landid)) $where['id']=$landid;
            $lands=$this->_land->queryfind($where,['*']);
            Log::info($lands);
            return $this->getAroundOrders($lands,$userid,$distance,$keyword,$pageIndex,$pageSize);
        }
     /**
      * 获取附近拼单   //lands,distance,keywords
      */
        private function getAroundOrders($lands=[],$userid,$distance,$keyword,$p,$size)
        {
            //如果lands为空则根据发布时间顺序获取拼单列表  如果不为空则获取distance附近的拼单
            $where=['p.state'=>'1','p.pname'=>['like',"%$keyword%"]];
            if(empty($lands)){
                $arr=db('porder')
                    ->alias('p')
                    ->where($where)
                    ->order('addtime desc')
                    ->limit($p*$size-$size,$size)
                    ->select();
            }else{
                $arr=[];
                $centerX=$lands['centerX'];
                $centerY=$lands['centerY'];
                //选出porder表中状态为1订单下用户userid下单的土地id  获取土地信息并计算距离，判断用户是否已经参与
                $res =  $this->_pordernum->queryEntity(['state'=>0,'landid'=>['<>',$lands['id']]],['*']);
                $porders=db('porder')
                    ->alias('p')
                    ->join('pordernum n','n.porderid=p.id')
                    ->where($where)
                    ->field('p.*,n.landid')->select();
                foreach ($porders as &$v)
                {
                    $landInfo=$this->_land->queryfind("id in ($v[landid])",['centerX','centerY','point']);
                    $a=\tybservice\Distance::getDistance($centerX,$centerY,$landInfo['centerX'],$landInfo['centerY']);
                    if($a<=$distance){
                        $v['distance']=$a;
                        $arr[]=$v;
                    }
                }
                $arr=unique_multidim_array($arr,'id');
                array_multisort(array_column($arr,'distance'),SORT_ASC,$arr);
                Log::info($arr);
            }
            if(empty($arr)) return [];
            foreach($arr as $k=>$v){
                $arr[$k]=array_merge($this->getPorderInfo($v['id'],$userid),$v);
//                $count=db('pordernum')->where(['userid'=>$userid,'porderid'=>$v['id']])->count();
//                $arr[$k]['isleader']=$v['userid']==$userid ? 1 : 0 ;
//                $arr[$k]['isjoin']=$count;
//                $arr[$k]['leader_name']=model('\logicmodel\Personal')->getUserInfo($v['userid'])['result']['nickname'];
//                $arr[$k]['lands_info']=$this->getLandsInfo($v['id']);
//                $arr[$k]['ori_price']=$ori_price;

            }
            return $arr;
        }

     /**
      * 发布拼单
      */
        public function releasePorder($userid,$landid,$starttime,$endtime,$pesticide,$sumArea,$pname)
        {
            $area = $this->getLandArea($landid);
            $addtime=date('Y-m-d H:i:s');
            $PorderData=[
                'userid'=>$userid,
                'addtime'=>$addtime,
                'starttime'=>$starttime,
                'pname'=>$pname,
                'endtime'=>$endtime,
                'sumarea'=>$sumArea,
                'price'=>$this->pconfig['land_unit_price'],
            ];
            $porderid=$this->_porder->addEntityReturnID($PorderData);
            if($porderid>0){
                $pordernumData=[
                    'userid'=>$userid,
                    'landid'=>$landid,
                    'porderid'=>$porderid,
                    'pesticide'=>$pesticide,
                    'area'=>$area,
                    'addtime'=>$addtime,
                ];
                $pordernumId = $this->_pordernum->addEntityReturnID($pordernumData);
                if($pordernumId>0){
                    $money=model('\logicmodel\Pordernumlogic')->getPorderMoney($pordernumId);
                    return ['pordernumid'=>$pordernumId,'money'=>$money,'porderid'=>$porderid];
                }
                return false;
            }
            return false;
        }

     /**
      *  加入拼单
      */
        public function joinPorders($userid,$landid,$pesticide,$porderid,$pcode,$p_userid)
        {
            $area = $this->getLandArea($landid);
            $addtime=date('Y-m-d H:i:s');
            $pOrderData=[
                'userid'=>$userid,
                'landid'=>$landid,
                'pesticide'=>$pesticide,
                'area'=>$area,
                'addtime'=>$addtime,
                'porderid'=>$porderid,
                'superior_code'=>$pcode,
                'pid'=>$p_userid,
            ];
            $pordernumId=$this->_pordernum->addEntityReturnID($pOrderData);
            if($pordernumId>0){
                $money=model('\logicmodel\Pordernumlogic')->getPorderMoney($pordernumId);
                return ['pordernumid'=>$pordernumId,'money'=>$money];
            }
            return false;
        }

     /**
      * 直接下单
      */
        public function placeOrder($data){
             if(empty($data['userid']) || empty($data['landid'])) return false;
             $data['addtime']=date('Y-m-d H:i:s');
             $data['porderid']=0;
             $data['type']='direct';
             $data['area'] = $this->getLandArea($data['landid']);
             $pordernumId=$this->_pordernum->addEntityReturnID($data);
             if($pordernumId>0){
                 $money=model('\logicmodel\Pordernumlogic')->getPorderMoney($pordernumId);
                 return ['pordernumid'=>$pordernumId,'money'=>$money];
             }
             return false;
        }

     /**
      * 拼单完成
      */
         public function finishOrder($id){  //完成订单
            $p_upd_arr=['state'=>4,'finishtime'=>time()];
            $pnum_upd_arr=['state'=>4];
            $land_upd_arr=['state'=>0];
            $lands=$this->_pordernum->queryEntity(['porderid'=>$id],['landid']);
            $landstr='';
            $profitModel=new \logicmodel\Profitlogic;
            $pushModel=new \logicmodel\Jpushlogic();
             foreach($lands as $land){
                $landstr.=$land['landid'].',';
            }
            $landstr=rtrim($landstr,',');
             Db::startTrans();
             try{
                 Db::name('land')->where("id in ($landstr) ")->update($land_upd_arr);
                 Db::name('porder')->where('id',$id)->update($p_upd_arr);
                 Db::name('pordernum')->where('porderid',$id)->update($pnum_upd_arr);
                 // 提交事务
                 Db::commit();
                 $pushModel->finishPush($id);
                 if($profitModel->dealAllProfit($id))    return true;
                 return false;
             } catch (\Exception $e) {
                 // 回滚事务
                 Db::rollback();
                 return false;
             }
        }

     /**
      * 根据土地id或id列表串获取土地面积
      */
         private function getLandArea($landid){
             $area=0;
             $land_arr=explode(',',$landid);
             foreach($land_arr as $v){
                 $area+= db('land')->where('id',$v)->find()['area'];
             }
             return $area;
         }

     /**
      * @param 根据邀请码获取拼单信息
      */
         public function getPnumInfo($pcode){
             return $this->_pordernum->queryfind(['code'=>$pcode],['*']);
         }
     /**
      * 获取某个拼单下的所有土地信息
      */
         public  function getLandsInfo($porderid){
             $lands=[];
             $land_str='';
            $pes_str='';
            $landids=$this->_pordernum->queryEntity(['porderid'=>$porderid,'state'=>['>',1]],['landid,pesticide']);
            if(empty($landids)) return [];
            foreach($landids as $land){
                $land_str.=$land['landid'].',';
                $pes_str.=$land['pesticide'].',';
            }
            $land_arr=explode(',',rtrim($land_str,','));
            $pes_arr=explode(',',rtrim($pes_str,','));
            foreach($land_arr as $k=>$v){
                $lands[$k]=$this->_land->queryfind(['id'=>$v],['*']);
                $lands[$k]['pesticide']=$this->_pesticide->queryfind(['id'=>$pes_arr[$k]],['name'])['name'];
            }
            return $lands;
         }
     /**
      * 获取农药列表
      */
        public function getPesticide()
        {
            $res = $this->_pesticide->queryEntity(['isdel'=>0],['id','name']);
            if($res)
            {
                return ['errcode'=>0,'msg'=>'success','result'=>['res'=>$res]];
            }else
                {
                    return ['errcode'=>1,'msg'=>'success'];
                }
        }

     /**
      * 上传分组groupid值
      */
     public function addGrounpId($userId,$porderId,$groupId)
     {
         return $this->_porder->updateEntity(['id'=>$porderId],['groupid'=>$groupId]);
     }


 }
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

 class Porderlogic
 {
        private $_porder;
        private $_land;
        private $_pesticide;
        private $_price;
        private $_order;
        private $_pordernum;
        public function __construct()
        {
            $this->_porder = new \datamodel\Porder();
            $this->_land = new \datamodel\Land();
            $this->_pesticide = new \datamodel\Pesticide();
            $this->_price = new \datamodel\Price();
            $this->_order = new \datamodel\Order();
            $this->_pordernum = new \datamodel\Pordernum();

        }

     /**附近拼单
      * @param $userid
      * @param $pageIndex
      * @param $pageSize
      * @return array|void
      * @throws \think\Exception
      */
        public function getAroundOrder($userid,$landid,$keyword,$distance=100000,$pageIndex,$pageSize)
        {
            $originalPrice='12.00';
            if(empty($landid))
            {
                $lands=$this->_land->queryfind(['userid'=>$userid,'isdel'=>0],['*']);
            }else
                {
                    $lands=$this->_land->queryfind(['id'=>$landid,'isdel'=>0],['*']);;
                }
            Log::info($lands);
            $su=$this->_pordernum->queryfind(['userid'=>$userid,'state'=>0],['*']);
            $leader=$this->_porder->queryfind(['userid'=>$userid,'state'=>0],['isleader'])['isleader'];
            if(is_null($leader)||$leader==1)
            {
                $leader=1;
            }else
            {
                $leader=0;
            }
            if($su)
            {
                $isjoin=0;
            }else
                {
                    $isjoin=1;
                }
            if($lands)
            {
                return $this->getAroundOrders($originalPrice,$lands,$pageIndex,$pageSize,$isjoin,$leader,$distance,$keyword);
            }else
                {
                    return $this->getAllAroundOrder($originalPrice,$pageIndex,$pageSize,$keyword);
                }
        }

     /**全部拼单
      * @param $originalPrice
      * @return array
      * @throws \think\Exception
      */
        public function getAllAroundOrder($originalPrice,$pageIndex,$pageSize,$keyword)
        {
            $res =  $this->_porder->queryEntity(['state'=>0,'pname'=>['like',"%.$keyword.%"]],['*'],null,null,$pageIndex,$pageSize);
            foreach ($res as &$v)
            {
                $nowPrice=$this->_price->queryEntity(['area'=>['>=',$v['hasland']]],['price'],null,['price desc'])[0]['price'];
                $v['nowprice']=$nowPrice;
                $v['originalprice']=$originalPrice;
            }
            if($res)
            {
                return ['errcode'=>0,'msg'=>'success','result'=>['res'=>$res]];
            }else
            {
                return ['errcode'=>1,'msg'=>'附近暂无拼单'];
            }
        }

     /**获取附近拼单
      * @param $originalPrice
      * @param $lands
      * @param $pageIndex
      * @param $pageSize
      * @return array
      * @throws \think\Exception
      */
        public function getAroundOrders($originalPrice,$lands,$pageIndex,$pageSize,$isjoin,$leader,$distance,$keyword)
        {
            $arr=[];
            $centerX=$lands['centerX'];
            $centerY=$lands['centerY'];
            $res =  $this->_pordernum->queryEntity(['state'=>0,'landid'=>['<>',$lands['id']]],['*']);
            foreach ($res as &$v)
            {
                $landInfo=$this->_land->queryfind(['id'=>$v['landid']],['centerX','centerY','point']);
                $a=\tybservice\Distance::getDistance($centerX,$centerY,$landInfo['centerX'],$landInfo['centerY']);
                if($a<=$distance)
                {
                    $arr[]=$v['pordernum'];
                }
            }

            Log::info($arr);
            if(empty($arr))
            {
               return ['errcode'=>1,'msg'=>'您附近没有拼单','result'=>['res'=>['']]];
            }
            if(empty($keyword))
            {
                $res1 =  $this->_porder->queryEntity(['state'=>0,'pordernum'=>['in',$arr]],['id','sumarea','userid','pordernum','state','pname','starttime','endtime','price','hasland'],null,null,$pageIndex,$pageSize);
            }else
                {
                    $res1 =  $this->_porder->queryEntity(['state'=>0,'pordernum'=>['in',$arr],'pname'=>['like',"%$keyword%"]],['id','sumarea','userid','pordernum','state','pname','starttime','endtime','price','hasland'],null,null,$pageIndex,$pageSize);

                }
            Log::info($res1);
            foreach ($res1 as &$v)
            {
                $res2 =  $this->_pordernum->queryEntity(['state'=>0,'pordernum'=>$v['pordernum']],['landid','pesticide']);
                foreach ($res2 as $v5)
                {
                    $landid = $v5['landid'];
                    $landids= explode(",", $landid);
                    foreach ($landids as $v1)
                    {
                        $landInfos = $this->_land->queryfind(['id'=>$v1],['point','centerX','centerY']);
                        $point = $landInfos['point'];
                        $points[]=$point;
                        $a1=\tybservice\Distance::getDistance($centerX,$centerY,$landInfos['centerX'],$landInfos['centerY']);
                    }
                }
                $points=array_unique($points);
                $groupid=$this->_pordernum->queryfind(['porderid'=>$v['id']],['groupid'])['groupid'];
                Log::info($groupid);
                if(!empty($groupid))
                {
                    $v['groupid']=$groupid;
                }
                $nowPrice=$this->_price->queryEntity(['area'=>['>=',$v['hasland']]],['price'],null,['price desc'])[0]['price'];
                $v['nowprice']=$nowPrice;
                $v['originalprice']=$originalPrice;
                $v['point']=$points;
                $v['isjoin']=$isjoin;
                $v['isleader']=$leader;
                $points=[];
                $v['distance']=$a1;
            }
            if($res1)
            {
                return ['errcode'=>0,'msg'=>'success','result'=>['res'=>$res1]];
            }else
            {
                return ['errcode'=>1,'msg'=>'false'];
            }

        }

     /** 农户发布拼单，未支付
      * @param $userid
      * @param $landid
      * @param $starttime
      * @param $endtime
      * @param $pesticide
      * @param $sumArea
      * @return array
      * @throws \think\Exception
      */
        public function releasePorder($userid,$landid,$starttime,$endtime,$pesticide,$sumArea,$pname)
        {
            $area = $this->_land->queryEntity(['id'=>$landid],['area'])[0]['area'];
            $pordernum=mt_rand(100000,9999999).$userid;
            $addtime=date('Y-m-d H:i:s');
            $PorderData=['userid'=>$userid,'addtime'=>$addtime,'starttime'=>$starttime,'pname'=>$pname,'endtime'=>$endtime,'sumarea'=>$sumArea,'pordernum'=>$pordernum];
            $porderid=$this->_porder->addEntityReturnID($PorderData);
            if($porderid>0){
                $pordernumData=[
                    'userid'=>$userid,
                    'landid'=>$landid,
                    'porderid'=>$porderid,
                    'pesticide'=>$pesticide,
                    'area'=>$area,
                    'addtime'=>$addtime,
                    'pordernum'=>$pordernum
                ];
                $pordernumId = $this->_pordernum->addEntityReturnID($pordernumData);
                $money=model('\logicmodel\Pordernumlogic')->getPorderMoney($pordernumId);
                if($pordernumId>0) return ['pordernumid'=>$pordernumId,'money'=>$money,'porderid'=>$porderid];
                return false;
            }
            return false;
        }

     /**加入拼单
      * @param $userid
      * @param $landid
      * @param $pordernum
      * @param $pesticide
      * @param $porderid
      * @return array
      * @throws \think\Exception
      */
        public function joinPorders($userid,$landid,$pordernum,$pesticide,$porderid,$pcode)
        {
            $area = $this->_land->queryEntity(['id'=>$landid],['area'])[0]['area'];
            $addtime=date('Y-m-d H:i:s');
            $pOrderData=['userid'=>$userid,'landid'=>$landid,'pordernum'=>$pordernum,'pesticide'=>$pesticide,'area'=>$area,'addtime'=>$addtime,'porderid'=>$porderid,'pcode'=>$pcode];
            $pordernumid=$this->_pordernum->addEntityReturnID($pOrderData);
            if($pordernumid>0)
            {
                return ['errcode'=>0,'msg'=>'加入拼单成功','pordernumid'=>$pordernumid];
            }else
                {
                    return ['errcode'=>1,'msg'=>'加入拼单失败'];
                }
        }
        public function placeOrder($data){
             if(empty($data['userid']) || empty($data['landid'])) return false;
             $data['addtime']=date('Y-m-d H:i:s');
             $data['porderid']=0;
             return $pordernumid=$this->_pordernum->addEntityReturnID($data);
        }

     /**获取农药列表
      * @return array
      * @throws \think\Exception
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

     /**生成邀请码接口
      * @param $userid
      * @param $porderid
      * @return array
      */
        public function addCodes($userid,$porderid)
        {
            $code=$porderid.$userid.mt_rand(10000,99999);
            $res=$this->_pordernum->updateEntity(['userid'=>$userid,'porderid'=>$porderid],['code'=>$code]);
            if($res)
            {
                return ['errcode'=>0,'msg'=>'success','result'=>['code'=>$code]];
            }else
            {
                return ['errcode'=>1,'msg'=>'false'];
            }

        }

        public function getPorderInfo($where,$fields)
        {
            return $this->_porder->queryfind($where,$fields);
        }

        public function updatepOederInfo($where,$data)
        {
            return $this->_porder->updateEntity($where,$data);
        }
 }
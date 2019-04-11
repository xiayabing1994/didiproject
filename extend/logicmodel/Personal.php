<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/15
 * Time: 10:15
 */
namespace logicmodel;

class Personal
{
    const ADDTIME_DESC = 'addtime desc';
    private $_user;
    private $_land;
    private $_order;
    private $_porder;
    private $_banner;
    private $_suggest;
    private $_profit;
    private $_pordernum;
    private $_version;
    private $_price;
    private $_usemoney;
    private $_keyword;
    public function __construct()
    {
        $this->_user = new \datamodel\User();
        $this->_land = new \datamodel\Land();
        $this->_order = new \datamodel\Order();
        $this->_porder = new \datamodel\Porder();
        $this->_banner = new \datamodel\Banner();
        $this->_suggest = new \datamodel\Suggest();
        $this->_earnings = new \datamodel\Profit();
        $this->_pordernum = new \datamodel\Pordernum();
        $this->_version = new \datamodel\Version();
        $this->_price = new \datamodel\Price();
        $this->_usemoney = new \datamodel\Usemoney();
        $this->_keyword = new \datamodel\Keyword();


    }

    /**个人中心
     * @param $uid
     * @return array
     */
    public function getUserInfo($uid)
    {
        $orderCount=$this->_pordernum->querycount(['userid'=>$uid]);
        $allearnings=$this->_user->queryfind(['id'=>$uid],['money'])['money'];
        if($allearnings==0)
        {
            $remainMoney=0;
        }else
            {
                $hasMoney=$this->_usemoney->getSum(['userid'=>$uid],'usemoney');
                $remainMoney=bcsub($allearnings,$hasMoney,2);
            }
        $res=$this->_user->queryfind(['id'=>$uid],['*']);
        $nickname=$res['nickname'];
        $mobile=$res['mobile'];
        $headimg=get_img_url($res['headimg']);
        $sex=$res['sex'];
        return ['errcode'=>0,'msg'=>'success','result'=>['ordercount'=>$orderCount,'remainmoney'=>$remainMoney,'nickname'=>$nickname,'mobile'=>$mobile,'headimg'=>$headimg,'sex'=>$sex]];
    }
    /**获取banner
     * @return array
     * @throws \think\Exception
     */
    public function getBanner()
    {
        $res=$this->_banner->queryEntity(['isshow'=>0],['*'],null,['order desc']);
        if($res)
        {
            return ['errcode'=>0,'msg'=>'success','result'=>['res'=>$res]];
        }else{
            return ['errcode'=>1,'msg'=>'false'];
        }
    }

    /**上传建议
     * @param $userid
     * @param $suggest
     * @return array
     */
    public function addSuggest($userid,$suggest)
    {
        $res = $this->_suggest->addEntityReturnID(['userid'=>$userid,'suggest'=>$suggest]);
        if($res>0)
        {
            return ['errcode'=>0,'msg'=>'success'];
        }else
            {
                return ['errcode'=>1,'msg'=>'false'];
            }
    }

    /**根据用户名获取头像
     * @param $username
     * @return array
     */
    public function getUserName($username)
    {
        $headimg=$this->_user->queryfind(['name'=>$username],['headimg'])['headimg'];
        if($headimg)
        {
            return ['errcode'=>0,'msg'=>'success','result'=>['headimg'=>$headimg]];
        }else
            {
               return ['errcode'=>1,'msg'=>'false'];
            }
    }

    /**我的收益
     * @param $userid
     * @return array
     * @throws \think\Exception
     */
    public function getEarningsList($userid)
    {
        $res=$this->_earnings->queryEntity(['userid'=>$userid],['*']);
        $sumEarnings=$this->_earnings->getSum(['userid'=>$userid],'money');
        if(!$res)
        {
            return ['errcode'=>1,'msg'=>'您暂时没有收益'];
        }
        foreach ($res as &$v)
        {
            $name = $this->_user->queryfind(['id'=>$userid],['name'])['name'];
            $v['name']=$name;
        }
        return ['errcode'=>0,'msg'=>'success','result'=>['res'=>$res,'sumearnings'=>$sumEarnings]];
    }
    /**我的订单列表
     * @param $userid
     * @return array
     * @throws \think\Exception
     */
    public function getOrderInfos($userid,$ordertype='crowd')
    {
        if($ordertype=='crowd'){
            $where=['a.userid'=>$userid,'a.state'=>['>',1],'a.porderid'=>['>',0]];
            $fields=['a.state as orderstate','a.code','p.id','p.state','p.pname','p.price as money','p.starttime','p.endtime','p.sumarea','a.landid','a.pesticide','a.area'];
            $res = $this->_pordernum->queryRelation([['porder p','a.porderid = p.id','inner']],$where,$fields,'',['a.addtime desc']);
        }elseif($ordertype=='direct'){
            $where=['userid'=>$userid,'porderid'=>0];
            $res=$this->_pordernum->queryEntity($where,['id,userid,landid,pesticide,area,addtime,type,price'],'', ['addtime desc']);
        }else{
            return [];
        }
        foreach($res as $k=>$v){
            $pests=$this->getPesticideName($v['pesticide']);
            $landsinfo=model('\logicmodel\Landlogic')->getLandInfo($v['landid']);
            foreach($pests as $pk=>$pv){
                $landsinfo[$pk]['pes_name']=$pv;
            }
            $res[$k]['landsinfo']=$landsinfo;
        }
        return $res;
    }

    /**获取当前app版本号
     * @return array
     */
    public function getVersion()
    {
        $version=$this->_version->queryfind(['id'=>1],['version'])['version'];
        return ['errcode'=>0,'msg'=>'success','result'=>['version'=>$version]];

    }

    /**拼单详情
     * @param $userid
     * @param $porderid
     * @return array
     * @throws \think\Exception
     */
    public function getPorderInfo($userid,$porderid)
    {
        $porderInfo=model('\logicmodel\Porderlogic')->getPorderinfo($porderid);
        if(empty($porderInfo)) return false;
        $field=['userid,landid,pesticide,pid,area,state,code,superior_code'];
        $pnum_info=$this->_pordernum->queryfind(['userid'=>$userid,'porderid'=>$porderid,'state'=>['>',1]],$field);
        $leader=$porderInfo['userid']==$userid ? 1 : 0;
        $isjoin=empty($pnum_info) ? 0 : 1;
        $porderInfo['joininfo']=$pnum_info;
        $porderInfo['isleader']=$leader;
        $porderInfo['isjoin']=$isjoin;
        return $porderInfo;
    }

    public function addKeyword($userid,$keysword)
    {
        $keywords=$this->_keyword->queryfind(['userid'=>$userid],['keyword']);
        if(empty($keywords))
        {
           $res=$this->_keyword->addEntityReturnID(['userid'=>$userid,'keyword'=>$keysword]);
           if($res>0) {
               return ['errcode'=>0,'msg'=>'success'];
           }else
               {
                   return ['errcode'=>1,'msg'=>'false'];
               }
        }else
            {
                $keywords=$keysword.','.$keywords['keyword'];
                $res=$this->_keyword->updateEntity(['userid'=>$userid],['keyword'=>$keywords]);
                if($res!==false)
                {
                    return ['errcode'=>0,'msg'=>'success'];
                }else
                {
                    return ['errcode'=>1,'msg'=>'false'];
                }
            }


    }

    public function getkeyWords($userid)
    {
        $keywords=$this->_keyword->queryfind(['userid'=>$userid],['keyword']);
        if(empty($keywords))
        {
            return ['errcode'=>1,'msg'=>'暂无搜索记录'];
        }else
        {
            $keywords=explode(',',$keywords['keyword']);
            $keywords=array_slice($keywords,0,4);
            return ['errcode'=>0,'msg'=>'success','result'=>['keyword'=>$keywords]];
        }
    }
    private function getPesticideName($pesticide){
            $pest_arr=explode(',',$pesticide);
            $res=[];
            $pestModel=new \datamodel\Pesticide();
            foreach($pest_arr as $v){
                $res[]=$pestModel->queryfind(['id'=>$v],['*'])['name'];
            }
            return $res;
    }
}
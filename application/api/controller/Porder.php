<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/6
 * Time: 10:06
 */
namespace app\api\controller;
use think\Request;
class Porder
{
    private $_request;
    private $_porderlogic;
    public function __construct(Request $request,\logicmodel\Porderlogic $porderlogic)
    {
        $this->_request=$request;
        $this->_porderlogic = $porderlogic;
    }

    /**农户发布拼单
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function addPorder()
    {
        $userid=$this->_request->param('userid');
        $landid=$this->_request->param('landid');
        $pname=$this->_request->param('pname');
        $starttime=$this->_request->param('starttime');
        $endtime = $this->_request->param('endtime');
        $pesticide=$this->_request->param('pesticide');
        $sumArea=$this->_request->param('sumarea');
        if($res=$this->_porderlogic->releasePorder($userid,$landid,$starttime,$endtime,$pesticide,$sumArea,$pname)){
            return json(['errcode'=>0,'msg'=>'发布拼单成功','result'=>$res]);
        }else{
            return json(['errcode'=>0,'msg'=>'发布拼单失败']);
        }
    }

    /**加入拼单
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function joinPorder()
    {
        $userid=$this->_request->param('userid');
        $landid=$this->_request->param('landid');
        $pordernum=$this->_request->param('pordernum');
        $pesticide=$this->_request->param('pesticide');
        $porderId = $this->_request->param('porderid');
        $pcode = $this->_request->param('pcode');
        return json($this->_porderlogic->joinPorders($userid,$landid,$pordernum,$pesticide,$porderId,$pcode));
    }

    /**
     *  直接下单接口
     */
    public function placeOrder(){
        if($res=$this->_porderlogic->placeOrder($this->_request->param())){
            return json(['errcode'=>0,'msg'=>'下单成功','result'=>['id'=>$res]]);
        }else{
            return json(['errcode'=>1,'msg'=>'下单失败']);
        }
    }
    /**农药列表
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function getPesticideList()
    {
        return json($this->_porderlogic->getPesticide());
    }

    /**附近拼单
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function aroundOrder()
    {
        $userid = $this->_request->param('userid');
        $landid = $this->_request->param('landid');
        $keyword = $this->_request->param('keyword');
        $distance = $this->_request->param('distance',1000);
        $pageIndex=$this->_request->param('pageindex',1);
        $pageSize=$this->_request->param('pagesize',5);
        return json($this->_porderlogic->getAroundOrder($userid,$landid,$keyword,$distance,$pageIndex,$pageSize));
    }





}

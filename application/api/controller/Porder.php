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

    /**
     * 发布拼单接口
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

    /**
     * 加入拼单接口
     */
    public function joinPorder()
    {
        $userid=$this->_request->param('userid');
        $landid=$this->_request->param('landid');
        $pesticide=$this->_request->param('pesticide');
        $porderId = $this->_request->param('porderid');
        $pcode = $this->_request->param('pcode');
        $pnuminfo=$this->_porderlogic->getPnumInfo($pcode);
        if(!empty($pcode) && !empty($pnuminfo)){
            return json(['errcode'=>3,'msg'=>'邀请码填写错误']);
        }
        if($res=$this->_porderlogic->joinPorders($userid,$landid,$pesticide,$porderId,$pcode,$pnuminfo['userid'])){
            return json(['errcode'=>0,'msg'=>'加入成功','result'=>$res]);
        }
        return json(['errcode'=>1,'msg'=>'加入失败']);
    }

    /**
     *  直接下单接口
     */
    public function placeOrder(){
        if($res=$this->_porderlogic->placeOrder($this->_request->param())){
            return json(['errcode'=>0,'msg'=>'下单成功','result'=>$res]);
        }else{
            return json(['errcode'=>1,'msg'=>'下单失败']);
        }
    }
    /**
     * 农药列表接口
     */
    public function getPesticideList()
    {
        return json($this->_porderlogic->getPesticide());
    }

    /**
     * 附近拼单接口
     */
    public function aroundOrder()
    {
        $userid = $this->_request->param('userid');
        $landid = $this->_request->param('landid');
        $keyword = $this->_request->param('keyword');
        $distance = $this->_request->param('distance',10000000);
        $pageIndex=$this->_request->param('pageindex',1);
        $pageSize=$this->_request->param('pagesize',5);
        $data=$this->_porderlogic->getAroundOrder($userid,$landid,$keyword,$distance,$pageIndex,$pageSize);
        if(empty($data)) return json(['errcode'=>1,'msg'=>'附近暂无拼单']);
        return json(['errcode'=>0,'msg'=>'获取拼单成功','result'=>$data]);
    }

    /**
     * 后台完单接口
     */
    public function finish(){
        $id=input('id');
        if($res=$this->_porderlogic->finishOrder($id)){
            return json(['errcode'=>0,'msg'=>'完单成功']);
        }else{
            return json(['errcode'=>1,'msg'=>'操作失败']);
        }
    }

    /**s上传分组值
     * @return \think\response\Json
     */
    public function uploadGroupId()
    {
        $userId = $this->_request->param('userid');
        $orderId = $this->_request->param('orderid');
        $groupId = $this->_request->param('groupid');
        if($res=$this->_porderlogic->addGrounpId($userId,$orderId,$groupId)){
            return json(['errcode'=>0,'msg'=>'创建群组成功']);
        }
        return json(['errcode'=>1,'msg'=>'创建群组失败']);
    }


}

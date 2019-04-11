<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/15
 * Time: 9:40
 */
namespace app\api\controller;
use think\Request;
class Person
{
    private $_request;
    private $_order;
    private $_porderlogic;
    private $_pordernumlogic;
    public function __construct(Request $request)
    {
        $this->_personal = new \logicmodel\Personal();
        $this->_order = new \logicmodel\Orderlogic();
        $this->_porderlogic = new \logicmodel\Porderlogic();
        $this->_pordernumlogic = new \logicmodel\Pordernumlogic();
        $this->_request = $request;
    }

    /**个人信息
     * @return \think\response\Json
     */
    public function userInfo()
    {
        $uid=$this->_request->param('userid');
        return json($this->_personal->getUserInfo($uid));
    }

    /**展示banner
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function showBanner()
    {
        return json($this->_personal->getBanner());
    }

    /**添加建议
     * @return \think\response\Json
     */
    public function addSuggest()
    {
        $userid = $this->_request->param('userid');
        $suggest = $this->_request->param('suggest');
        return json($this->_personal->addSuggest($userid,$suggest));
    }

    /**我的订单
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function myOrder()
    {   $ordertype=$this->_request->param('ordertype','crowd');
        $userid = $this->_request->param('userid');
        if($res=$this->_personal->getOrderInfos($userid,$ordertype)){
            return json(['errcode'=>0,'msg'=>'获取订单列表成功','result'=>['res'=>$res]]);
        }else{
            return json(['errcode'=>1,'msg'=>'暂无数据']);
        }
    }

    /**根据用户名获取头像
     * @return \think\response\Json
     */
    public function getHeadimg()
    {
        $username=$this->_request->param('username');
        return json($this->_personal->getUserName($username));
    }

    /**我的收益
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function myEarnings()
    {
        $userid = $this->_request->param('userid');
        return json($this->_personal->getEarningsList($userid));
    }

    public function shareLink()
    {
        return json(['errcode'=>0,'msg'=>'success','result'=>['link'=>'']]);
    }
    /**生成邀请码
     * @return \think\response\Json
     */
    public function addCode()
    {
        $userid=$this->_request->param('userid');
        $porderid = $this->_request->param('porderid');
        return json($this->_porderlogic->addCodes($userid,$porderid));
    }

    /**获取版本号
     * @return \think\response\Json
     */
    public function updateVersion()
    {
        return json($this->_personal->getVersion());
    }

    /**获取要加入的拼单详情
     * @return \think\response\Json
     */
    public function getPorderInfo()
    {
        $userid=$this->_request->param('userid');
        $porderid = $this->_request->param('porderid');
        if(empty($userid) || empty($porderid)){
            return json(['errcode'=>4,'msg'=>'参数错误']);
        }
        if($res=$this->_personal->getPorderInfo($userid,$porderid)){
            return json(['errcode'=>0,'msg'=>'获取详情成功','result'=>$res]);
        }else{
            return json(['errcode'=>3,'msg'=>'暂无详情信息']);
        }
    }
    public function getJoinInfo(){
        $pnumid=$this->_request->param('pnumid');
        if($res=$this->_pordernumlogic->getPorderNumInfo($pnumid)){
            return json(['errcode'=>0,'msg'=>'获取个人订单信息成功','result'=>$res]);
        }
        return json(['errcode'=>2,'msg'=>'暂无信息']);
    }
    public function recordKeyword()
    {
        $userid=$this->_request->param('userid',26);
        $keyword = $this->_request->param('keyword','你好');
        return json($this->_personal->addKeyword($userid,$keyword));
    }

    public function getKeyword()
    {
        $userid=$this->_request->param('userid',26);
        return json($this->_personal->getkeyWords($userid));

    }

}


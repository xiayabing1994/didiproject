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
    public function __construct(Request $request)
    {
        $this->_personal = new \logicmodel\Personal();
        $this->_order = new \logicmodel\Orderlogic();
        $this->_porderlogic = new \logicmodel\Porderlogic();
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
    {
        $userid = $this->_request->param('userid');
        return json($this->_personal->getOrderInfos($userid));
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
        return json($this->_personal->getPorderInfo($userid,$porderid));
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


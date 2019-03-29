<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/7
 * Time: 9:54
 */
namespace app\api\controller;
use think\Request;
class Order
{
    private $_request;
    private $_orderlogic;

    public function __construct(Request $request,\logicmodel\Orderlogic $orderlogic)
    {
        $this->_request=$request;
        $this->_orderlogic = $orderlogic;
    }

    /**创建订单
     * @return \think\response\Json
     */
    public function createOrder()
    {
        $payfrom=$this->_request->param('payfrom');
        $userId = $this->_request->param('userid');
        $pOrderNumId = $this->_request->param('pordernumid');
        return json($this->_orderlogic->createOrders($userId,$pOrderNumId,$payfrom));

    }

    /**s上传分组值
     * @return \think\response\Json
     */
    public function uploadGroupId()
    {
        $userId = $this->_request->param('userid');
        $orderId = $this->_request->param('orderid');
        $groupId = $this->_request->param('groupid');
        return json($this->_orderlogic->addGrounpId($userId,$orderId,$groupId));
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: awang
 * Date: 2018/2/8
 * Time: 15:34
 */
namespace app\pay\controller;
use paymodel\Alipaymodel;
use think\Request;
use think\Log;


/**
 * Class Wxpay
 * @package app\pay\controller
 */
class Wxpay
{

    private $_alipayModel;
    private $_request;

    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    /**
     * @return string
     * @throws \think\Exception
     */
    public function WxBackReceive()
    {
        $orderid = $this->_request->param('orderid');
        \think\Log::record("orderid:{$orderid}的回调来了");
        $paysn = $this->_request->param('paysn');
        Log::info('微信回调的订单id为：' . json_encode($orderid));
        //处理回调信息
        $res=Alipaymodel::wxPayResult($orderid,$paysn);
        return 'success';
    }
}
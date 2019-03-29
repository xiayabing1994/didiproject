<?php

namespace app\pay\controller;
use paymodel\Alipaymodel;
use think\Request;
use think\Log;

class Alipay
{
    private $_alipayModel;
    private $_request;

    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    public function pay()
    {
        $orderid=$this->_request->param('orderid');
        $res=Alipaymodel::createAlipay($orderid);
        return json($res);
    }

    /**回调函数
     * @throws \Think\Exception
     */
    public function BackReceive()
    {
        $data=$this->_request->param();
        $res=Alipaymodel::payResult($data);
        return 'success';
    }



   

}
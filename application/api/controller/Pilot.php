<?php
namespace app\api\controller;

class Pilot{

    private $_request;
    private $_pilotlogic;
    public function __construct(\think\Request $request,\logicmodel\Pilotlogic $pilotlogic){
          $this->_request=$request;
          $this->_pilotlogic=$pilotlogic;
    }

    public function getOrders(){
        $data=$this->_request->param();
        if(empty($data['device_no'])){
            return json(['errcode'=>3,'msg'=>'空设备号']);
        }
        $orders=$this->_pilotlogic->getAlotOrders($data['device_no']);
        if(empty($orders)){
            return json(['errcode'=>2,'msg'=>'暂无分配订单']);
        }else{
            return json(['errcode'=>0,'msg'=>'获取分配订单成功','result'=>$orders]);
        }
    }
}
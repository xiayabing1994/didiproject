<?php
namespace logicmodel;

class Pilotlogic{

    private $_pilot;
    private $_porderlogic;
    public function __construct(){
        $this->_pilot=new \datamodel\Pilot();
        $this->_porderlogic=new \logicmodel\Porderlogic();
    }

    /**
     * 根据飞行员设备号获取分配的订单
     */
    public function getAlotOrders($device_no){
        $pilot_info=$this->_pilot->queryFind(['device_no'=>$device_no],['*']);
        if(!$pilot_info['allot_orders']) return false;
        $orderinfo=$this->_porderlogic->getPorderInfo($pilot_info['allot_orders']);
//        $orderinfo['landinfo']=$this->_porderlogic->getLandsInfo($pilot_info['allot_orders']);
        return $orderinfo;
    }
}
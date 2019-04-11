<?php
namespace  app\api\controller;
use logicmodel\Profitlogic;
class Profit{
    private $_profit;
    private $_request;
    public function __construct(\think\Request $request){
        $this->_request=$request;
        $this->_profit=new Profitlogic();
    }

    public function deal(){
        $pid=$this->_request->param('pid');
        $this->_profit->dealAllProfit($pid);
    }

}
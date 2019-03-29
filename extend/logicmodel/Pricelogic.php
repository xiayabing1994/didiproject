<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/26
 * Time: 15:40
 */
namespace logicmodel;
use think\Request;

class Pricelogic
{
    private $_requset;
    private $_price;
    public function __construct(Request $request)
    {
        $this->_price=new \datamodel\Price();
        $this->_requset = $request;
    }

    public function getNowPrice($where,$fields,$group,$sort)
    {
        return $this->_price->queryEntity($where,$fields,$group,$sort);
    }
}
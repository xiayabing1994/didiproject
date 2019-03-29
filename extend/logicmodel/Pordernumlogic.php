<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/25
 * Time: 15:36
 */
namespace logicmodel;
use think\Request;

class Pordernumlogic
{
    private $_pordernum;
    private $_request;

    public function __construct(Request $request)
    {
        $this->_request=$request;
        $this->_pordernum = new \datamodel\Pordernum();
    }

    public function getPorderNumInfo($where,$fields)
    {
        return $this->_pordernum->queryfind($where,$fields);
    }

    public function updatePorderNumInfo($where,$data)
    {
        return $this->_pordernum->updateEntity($where,$data);
    }

}
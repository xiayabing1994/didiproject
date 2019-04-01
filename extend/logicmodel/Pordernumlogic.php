<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/25
 * Time: 15:36
 */
namespace logicmodel;

class Pordernumlogic
{
    private $_land;
    public function __construct()
    {
        $this->_land = new \datamodel\Land();
    }

    public function getPorderNumInfo($where,$fields)
    {
        return $this->_pordernum->queryfind($where,$fields);
    }

    public function updatePorderNumInfo($where,$data)
    {
        return $this->_pordernum->updateEntity($where,$data);
    }

    /**
     * 根据podernum表id获取应付金额
     */
    public function getPorderMoney($id){
        $pordernum = new \datamodel\Pordernum();
        $pinfo=$pordernum->queryfind(['id'=>$id],'*');
        $area=$this->getLandArea($id);
        $pconf=load_config('peace');
        $money=0;
        if($pinfo['porderid']>0){   //拼单的操作   分为付定金    付尾款
            $oinfo=db('porder')->where('id',$pinfo['porderid'])->field('hasland,price')->find();
            $price=get_land_price($oinfo['hasland']);
            if($pinfo['state']==1) $money=$area*$pconf['land_unit_price']*$pconf['land_sub_rate'];
            if($pinfo['state']==2) $money=$area*$price-$area*$pconf['land_unit_price']*$pconf['land_sub_rate'];
        }else{    //直接下单的操作  只有全部付款一项
            $money=$area*get_land_price($area);
        }
        return $money;
    }

    /**
     * 根据pordernum表id获取单子下土地总面积
     */
    public function getLandArea($id){
        $pordernum = new \datamodel\Pordernum();
        $pinfo=$pordernum->queryfind(['id'=>$id],'*');
        $landids= explode(",", $pinfo['landid']);
        $area=0;
        foreach ($landids as $v)
        {
            $area+=$this->_land->queryfind(['id'=>$v],['area'])['area'];

        }
        return $area;
    }
}
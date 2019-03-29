<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 9:42
 */
namespace logicmodel;
class Landlogic
{
    private $_land;
    public function __construct()
    {
        $this->_land = new \datamodel\Land();
    }

    /**农户添加土地
     * @param $name string 土地名称
     * @param $area string 土地面积
     * @param $point string 坐标点
     * @param $userid int 用户id
     * @return array
     * @throws \think\Exception
     */
    public function addLandInfo($name,$area,$point,$userid,$centerX,$centerY,$perimeter,$landarea)
    {
        $data=['name'=>$name,'area'=>$area,'point'=>$point,'userid'=>$userid,'centerX'=>$centerX,'centerY'=>$centerY,'perimeter'=>$perimeter,'landarea'=>$landarea,'addtime'=>date('Y-m-d H:i:s')];
        $landid=$this->_land->addEntityReturnID($data);
        if($landid>0)
        {
            $res=$this->_land->queryEntity(['id'=>$landid],['*']);
            return ['errcode'=>0,'msg'=>'success','result'=>['res'=>$res]];
        }else
            {
                return ['errcode'=>1,'msg'=>'false'];
            }
    }

    /**农户添加的地块
     * @param $userid
     * @return array
     * @throws \think\Exception
     */
    public function userLands($userid)
    {
        $res=$this->_land->queryEntity(['userid'=>$userid,'state'=>0,'isdel'=>0],['name','area','id','state','point','landarea','perimeter']);
        if(!$res)
        {
            return ['errcode'=>1,'msg'=>'农户暂无添加土地，请添加土地','result'=>['res'=>[]]];
        }else
        {
            return ['errcode'=>0,'msg'=>'success','result'=>['res'=>$res]];
        }
    }

    /**删除土地
     * @param $where
     * @param $fields
     * @return bool|false|int
     */
    public function changeLandState($where,$fields)
    {
        return $this->_land->updateEntity($where,$fields);
    }

    /**删除土地
     * @param $userid
     * @param $landid
     * @return array
     */
    public function delLands($userid,$landid)
    {
        $up=$this->_land->updateEntity(['id'=>$landid,'userid'=>$userid],['isdel'=>1]);
        if($up!==false)
        {
            return ['errcode'=>0,'msg'=>'success'];
        }else
            {
                return ['errcode'=>1,'msg'=>'false'];
            }
    }

    public function LandInfo($where,$fields)
    {
       return $this->_land->queryfind($where,$fields);
    }

}
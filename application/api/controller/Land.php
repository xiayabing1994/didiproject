<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/5
 * Time: 9:38
 */
namespace app\api\controller;
use think\Request;
class Land
{
    private $_request;
    private $_land;
    public function __construct(Request $request,\logicmodel\Landlogic $land)
    {
        $this->_request = $request;
        $this->_land = $land;
    }

    /**添加土地
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function addLand()
    {
        $name=$this->_request->param('name');
        $area=$this->_request->param('area');
        $userid = $this->_request->param('userid');
        $point = $this->_request->param('point');
        $centerX=$this->_request->param('centerX');
        $centerY=$this->_request->param('centerY');
        $perimeter=$this->_request->param('perimeter');
        $landarea = $this->_request->param('landarea');
        return json($this->_land->addLandInfo($name,$area,$point,$userid,$centerX,$centerY,$perimeter,$landarea));
    }

    /**农户添加的地块
     * @return \think\response\Json
     * @throws \think\Exception
     */
    public function userLand()
    {
        $userid=$this->_request->param('userid');
        return json($this->_land->userLands($userid));
    }

    /**删除土地
     * @return \think\response\Json
     */
    public function delLand()
    {
        $userid=$this->_request->param('userid');
        $landid=$this->_request->param('landid');
        return json($this->_land->delLands($userid,$landid));
    }

}
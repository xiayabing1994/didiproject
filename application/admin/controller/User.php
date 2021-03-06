<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 
 *
 * @icon fa fa-user
 */
class User extends Backend
{
    
    /**
     * User模型对象
     * @var \app\admin\model\User
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\User;
        $this->view->assign("sexList", $this->model->getSexList());
        $this->view->assign("typeList", $this->model->getTypeList());
        $this->view->assign("stateList", $this->model->getStateList());
        $this->view->assign("loginTypeList", $this->model->getLoginTypeList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function showUserInfo(){
        $userid=input('userid');
        $row=$this->model->where('id',$userid)->find();
        $joins=model('\logicmodel\Personal')->getOrderInfos($userid);
        $this->view->assign('row',$row);
        $this->view->assign('joins',$joins);
        return $this->view->fetch();
    }

}

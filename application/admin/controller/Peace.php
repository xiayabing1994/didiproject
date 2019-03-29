<?php

namespace app\admin\controller;

use app\common\controller\Backend;

/**
 * 拼单管理
 *
 * @icon fa fa-circle-o
 */
class Peace extends Backend
{
    
    /**
     * Peace模型对象
     * @var \app\admin\model\Peace
     */
    protected $model = null;
    protected $relationSearch = true;    //关联查询配置
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Peace;
        $this->view->assign("statuList", $this->model->getStatuList());
        $this->view->assign("isEffectList", $this->model->getIsEffectList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function lists()
    {
        if ($this->request->isAjax())
        {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with(["user"])
                ->where($where)
                ->order($sort, $order)
                ->count();
            $list = $this->model
                ->with(["user"])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch('index');
    }

}

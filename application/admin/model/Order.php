<?php

namespace app\admin\model;

use think\Model;

class Order extends Model
{
    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'paytype_text',
        'orderstate_text'
    ];
    

    
    public function getPaytypeList()
    {
        return ['weixin' => __('Paytype weixin'),'alipay' => __('Paytype alipay')];
    }     

    public function getOrderstateList()
    {
        return ['0' => __('Orderstate 0'),'1' => __('Orderstate 1'),'4' => __('Orderstate 4'),'3' => __('Orderstate 3')];
    }     


    public function getPaytypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['paytype']) ? $data['paytype'] : '');
        $list = $this->getPaytypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getOrderstateTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['orderstate']) ? $data['orderstate'] : '');
        $list = $this->getOrderstateList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

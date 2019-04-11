<?php

namespace app\admin\model;

use think\Model;

class Pordernum extends Model
{
    // 表名
    protected $name = 'pordernum';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'state_text',
        'type_text'
    ];
    

    
    public function getStateList()
    {
        return ['0' => __('State 0'),'1' => __('State 1'),'2' => __('State 2'),'3' => __('State 3'),'4' => __('State 4')];
    }     

    public function getTypeList()
    {
        return ['direct' => __('Type direct'),'crowd' => __('Type crowd')];
    }     


    public function getStateTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

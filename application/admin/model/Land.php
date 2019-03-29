<?php

namespace app\admin\model;

use think\Model;

class Land extends Model
{
    // 表名
    protected $name = 'land';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'state_text',
        'isdel_text'
    ];
    

    
    public function getStateList()
    {
        return ['0' => __('State 0'),'1' => __('State 1')];
    }     

    public function getIsdelList()
    {
        return ['0' => __('Isdel 0'),'1' => __('Isdel 1')];
    }     


    public function getStateTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsdelTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['isdel']) ? $data['isdel'] : '');
        $list = $this->getIsdelList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

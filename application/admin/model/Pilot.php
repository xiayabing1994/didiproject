<?php

namespace app\admin\model;

use think\Model;

class Pilot extends Model
{
    // 表名
    protected $name = 'pilot';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'is_effect_text'
    ];
    

    
    public function getIsEffectList()
    {
        return ['1' => __('Is_effect 1'),'0' => __('Is_effect 0')];
    }     


    public function getIsEffectTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['is_effect']) ? $data['is_effect'] : '');
        $list = $this->getIsEffectList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

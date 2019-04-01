<?php

namespace app\admin\model;

use think\Model;

class Question extends Model
{
    // 表名
    protected $name = 'question';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'iseffect_text'
    ];
    

    
    public function getIseffectList()
    {
        return ['0' => __('Iseffect 0'),'1' => __('Iseffect 1')];
    }     


    public function getIseffectTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['iseffect']) ? $data['iseffect'] : '');
        $list = $this->getIseffectList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

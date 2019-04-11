<?php

namespace app\admin\model;

use think\Model;

class Profit extends Model
{
    // 表名
    protected $name = 'profit';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'iseffect_text',
        'type_text'
    ];
    

    
    public function getIseffectList()
    {
        return ['1' => __('Iseffect 1'),'0' => __('Iseffect 0')];
    }     

    public function getTypeList()
    {
        return ['earn' => __('Type earn'),'other' => __('Type other')];
    }     


    public function getIseffectTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['iseffect']) ? $data['iseffect'] : '');
        $list = $this->getIseffectList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

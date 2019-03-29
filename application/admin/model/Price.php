<?php

namespace app\admin\model;

use think\Model;

class Price extends Model
{
    // 表名
    protected $name = 'price';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'isdel_text'
    ];
    

    
    public function getIsdelList()
    {
        return ['1' => __('Isdel 1'),'0' => __('Isdel 0')];
    }     


    public function getIsdelTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['isdel']) ? $data['isdel'] : '');
        $list = $this->getIsdelList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

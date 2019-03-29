<?php

namespace app\admin\model;

use think\Model;

class Banner extends Model
{
    // 表名
    protected $name = 'banner';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'isshow_text'
    ];
    

    
    public function getIsshowList()
    {
        return ['0' => __('Isshow 0'),'1' => __('Isshow 1')];
    }     


    public function getIsshowTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['isshow']) ? $data['isshow'] : '');
        $list = $this->getIsshowList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

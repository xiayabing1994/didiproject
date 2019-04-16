<?php

namespace app\admin\model\push;

use think\Model;

class Log extends Model
{
    // 表名
    protected $name = 'push_log';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'state_text'
    ];
    

    
    public function getStateList()
    {
        return ['success' => __('State success'),'fail' => __('State fail')];
    }     


    public function getStateTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

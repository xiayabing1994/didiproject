<?php

namespace app\admin\model;

use think\Model;

class Sms extends Model
{
    // 表名
    protected $name = 'sms';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'event_text',
        'sendstate_text'
    ];
    

    
    public function getEventList()
    {
        return ['bind' => __('Event bind'),'reg' => __('Event reg')];
    }     

    public function getSendstateList()
    {
        return ['success' => __('Sendstate success'),'fail' => __('Sendstate fail')];
    }     


    public function getEventTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['event']) ? $data['event'] : '');
        $list = $this->getEventList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getSendstateTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['sendstate']) ? $data['sendstate'] : '');
        $list = $this->getSendstateList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

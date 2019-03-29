<?php

namespace app\admin\model;

use think\Model;

class Peace extends Model
{
    // 表名
    protected $name = 'peace';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'statu_text',
        'is_effect_text'
    ];
    

    
    public function getStatuList()
    {
        return ['0' => __('Statu 0'),'1' => __('Statu 1')];
    }     

    public function getIsEffectList()
    {
        return ['0' => __('Is_effect 0'),'1' => __('Is_effect 1')];
    }     


    public function getStatuTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['statu']) ? $data['statu'] : '');
        $list = $this->getStatuList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsEffectTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['is_effect']) ? $data['is_effect'] : '');
        $list = $this->getIsEffectList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function user()
    {
        $user=$this->belongsTo('User', 'user_id')->setEagerlyType(0);
        return $user;
    }


}

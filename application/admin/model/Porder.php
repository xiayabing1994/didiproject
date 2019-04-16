<?php

namespace app\admin\model;

use think\Model;

class Porder extends Model
{
    // 表名
    protected $name = 'porder';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    // 追加属性
    protected $append = [
        'isleader_text',
        'state_text'
    ];
    

    
    public function getIsleaderList()
    {
        return ['0' => __('Isleader 0'),'1' => __('Isleader 1')];
    }     

    public function getStateList()
    {
        return ['1' => __('State 1'),'2' => __('State 2'),'3' => __('State 3'),'4' => __('State 4')];
    }     


    public function getIsleaderTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['isleader']) ? $data['isleader'] : '');
        $list = $this->getIsleaderList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStateTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }
    public function user()
    {
        $user=$this->belongsTo('User', 'userid')->setEagerlyType(0);
        return $user;
    }
    public function getTotalPubs(){
        return [
            'totalpub'=>$this->count(),
        ];
    }


}

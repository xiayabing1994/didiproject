<?php

namespace app\admin\model;

use think\Model;

class User extends Model
{
    // 表名
    protected $name = 'user';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'sex_text',
        'type_text',
        'state_text',
        'login_type_text'
    ];
    

    
    public function getSexList()
    {
        return ['0' => __('Sex 0'),'1' => __('Sex 1')];
    }     

    public function getTypeList()
    {
        return ['1' => __('Type 1'),'2' => __('Type 2'),'3' => __('Type 3')];
    }     

    public function getStateList()
    {
        return ['0' => __('State 0'),'1' => __('State 1')];
    }     

    public function getLoginTypeList()
    {
        return ['weixin' => __('Login_type weixin'),'mobile' => __('Login_type mobile')];
    }     


    public function getSexTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['sex']) ? $data['sex'] : '');
        $list = $this->getSexList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['type']) ? $data['type'] : '');
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStateTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['state']) ? $data['state'] : '');
        $list = $this->getStateList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getLoginTypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['login_type']) ? $data['login_type'] : '');
        $list = $this->getLoginTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}

<?php

namespace app\admin\model;

use think\Model;
use think\Db;
class Order extends Model
{
    // 表名
    protected $name = 'order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'paytype_text',
        'paystate_text',
        'paytime_text',
        'ordertype_text',
        'isdeal_text'
    ];
    

    
    public function getPaytypeList()
    {
        return ['weixin' => __('Paytype weixin'),'alipay' => __('Paytype alipay')];
    }     

    public function getPaystateList()
    {
        return ['0' => __('Paystate 0'),'1' => __('Paystate 1'),'4' => __('Paystate 4'),'3' => __('Paystate 3')];
    }     

    public function getOrdertypeList()
    {
        return ['sub' => __('Ordertype sub'),'final' => __('Ordertype final'),'direct' => __('Ordertype direct')];
    }     

    public function getIsdealList()
    {
        return ['0' => __('Isdeal 0'),'1' => __('Isdeal 1')];
    }     


    public function getPaytypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['paytype']) ? $data['paytype'] : '');
        $list = $this->getPaytypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getPaystateTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['paystate']) ? $data['paystate'] : '');
        $list = $this->getPaystateList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getPaytimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['paytime']) ? $data['paytime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getOrdertypeTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['ordertype']) ? $data['ordertype'] : '');
        $list = $this->getOrdertypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsdealTextAttr($value, $data)
    {        
        $value = $value ? $value : (isset($data['isdeal']) ? $data['isdeal'] : '');
        $list = $this->getIsdealList();
        return isset($list[$value]) ? $list[$value] : '';
    }
    public function user()
    {
        $user=$this->belongsTo('User', 'userid')->setEagerlyType(0);
        return $user;
    }
    public function getTotalOrders(){
        $today=strtotime(date('Y-m-d'));
        $res=[
            'totalorder'=>Db::name('order')->count(),
            'totalorderamount'=>Db::name('order')->sum('money'),
            'todayorder'=>Db::name('order')->where('createtime','>',$today)->count(),
            'unpayorder'=>Db::name('order')->where('paystate','0')->count(),

        ];
        return $res;
    }
    protected function setPaytimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}

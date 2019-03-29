<?php

namespace app\wap\validate;

use think\Validate;

class Crowd extends Validate{
    protected $rule = [
        'pname'  =>  'require',
        'area' =>  'require|number',
        'land_id'=>'require',
        'pesticide'=>'require',
    ];

    protected $message = [
        'pname.require'  =>  '标题必须设置',
        'area.number'    =>  '请输入正确的亩数',
        'land_id.require'=>  '请选择土地',
        'pesticide.require'=>  '请选择杀虫剂',
    ];

    protected $scene = [
        'deal'   =>  ['title','area','land_id','pesticide'],
    ];
}
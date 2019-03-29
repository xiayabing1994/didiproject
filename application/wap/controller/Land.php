<?php
namespace  app\wap\controller;
class Land extends Base{
    public function __construct(){

    }
    public function addLand(){
        $data=input('param.');
        if(model('Land')->addLand($data)){
            return json(['errcode'=>0,'msg'=>'添加成功']);
        }else{
            return json(['errcode'=>1,'msg'=>'添加失败']);
        }
    }
    public function updLandName(){
        $data=input('param.');
        if(model("Land")->updLandName($data['land_id'],$data['name'])){
            return json(['errcode'=>0,'msg'=>'修改成功']);
        }else{
            return json(['errcode'=>1,'msg'=>'修改失败']);
        }
    }
}